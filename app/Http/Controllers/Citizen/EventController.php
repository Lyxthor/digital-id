<?php

namespace App\Http\Controllers\Citizen;

use App\Helpers\RequestHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Citizen\Event\StoreEventRequest;
use App\Http\Requests\Citizen\Event\SubmitTokenToEventRequest;
use App\Http\Requests\Citizen\Event\UpdateEventRequest;
use App\Models\DocumentType;
use App\Models\Event;
use App\Models\EventDocumentRequirement;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Helpers\TextCipherHelper;
use App\Models\Document;
use App\Models\DocumentFolder;
use Illuminate\Support\Carbon;
use App\Models\DocumentFolderToken;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index()
    {
        return RequestHandler::handle(function() {
            $user = Auth::user();
            $events = $user->userable->events;

            return view('citizen.event.index', compact('events'));
        });
    }
    public function create()
    {
        return RequestHandler::handle(function() {
            $document_types = DocumentType::select(['id', 'name'])->get();
            return view('citizen.event.create', compact('document_types'));
        });
    }
    public function edit($id)
    {
        return RequestHandler::handle(function() use($id) {
            $event = Auth::user()->userable->events->where('id', $id);
            if($event->isEmpty())
            {
                throw new Exception("Event not found", Response::HTTP_NOT_FOUND);
                return;
            }
            $event = $event->first();
            $document_types = DocumentType::select(['id', 'name'])->get();

            return view('citizen.event.edit', compact('event', 'document_types'));
        });
    }
    public function share($id)
    {
        return RequestHandler::handle(function() use($id) {
            $event = Event::where('id', $id)->get();
            if($event->isEmpty())
            {
                throw new Exception("Event not found", Response::HTTP_NOT_FOUND);
                return;
            }
            $event = $event->first();
            return view('citizen.event.share', compact('event'));
        });
    }
    public function scan()
    {
        return RequestHandler::handle(function() {
            return view('citizen.event.scan');
        });
    }
    public function confirmation($id)
    {
        return RequestHandler::handle(function() use($id) {
            $event = Event::where('id', $id)->get();
            if($event->isEmpty())
            {
                throw new Exception("Event not found", Response::HTTP_NOT_FOUND);
                return;
            }
            $event = $event->first();
            $citizen = Auth::user()->userable;
            $documents = Document::ownership($citizen->id)->get();
            $requirements = $event->requirements;

            $coll1 = $documents->pluck('type_id');
            $coll2 = $requirements->pluck('id');
            if($coll2->diff($coll1)->isNotEmpty())
            {
                return redirect()->back()->with("error", "You dont have required document for this event");
            }
            return view('citizen.event.confirmation', compact('event', 'documents'));
        });
    }
    public function submit(SubmitTokenToEventRequest $req, $id)
    {
        return RequestHandler::handle(function() use($req, $id) {
            $event = Event::where('id', $id)->get();
            if($event->isEmpty())
            {
                throw new Exception("Event not found", Response::HTTP_NOT_FOUND);
                return;
            }
            $event = $event->first();
            $citizen = Auth::user()->userable;
            $randomName = Str::random(12);
            $folderData =
            [
                "name"=>$randomName,
                "category"=>"onDemand",
                "owner_id"=>Auth::user()->userable->id
            ];
            $documentsData = $req->validated();
            $documentsIds = $documentsData['document_ids'];
            $requirementIds = $event->requirements->pluck('id')->toArray();

            $documentsData = Document::ownership($citizen->id)
            ->find($documentsIds)
            ->whereIn('type_id', $requirementIds)
            ->pluck('id')
            ->toArray();

            DB::beginTransaction();
            try
            {
                $folder = DocumentFolder::create($folderData);
                $folder->documents()->sync($documentsData);
                $tokenData = [];
                $randomToken = TextCipherHelper::encrypt(Str::random(8).Carbon::now(), env('ENCRYPTION_KEY'));
                $randomToken = base64_encode($randomToken);
                $randomToken = implode(explode('/', $randomToken));
                $reviewers = $event->reviewers->pluck('id');
                $tokenData =
                [
                    'token'=>$randomToken,
                    'name'=>$randomName,
                    'folder_id'=>$folder->id,
                    'accessibility'=>'restricted',
                    'expires_at'=>$event->access_expires_at,
                ];
                $token = DocumentFolderToken::create($tokenData);
                $token->authorized_citizens()->sync($reviewers);
                $token->authorized_events()->attach($event->id);
                DB::commit();
                return redirect()->route('dashboard.citizen');
            }
            catch(Exception $e)
            {
                DB::rollBack();
                throw new Exception($e->getMessage(), Response::HTTP_NOT_FOUND);
            }
        });
    }
    public function show($id)
    {
        return RequestHandler::handle(function() use($id) {
            $event = Event::where('id', $id)->get();
            if($event->count() == 0)
            {
                throw new Exception("Event not found", Response::HTTP_NOT_FOUND);
                return;
            }
            $citizen = Auth::user()->userable;
            $event = $event->first();
            return view('citizen.event.show', compact('event','citizen'));
        });
    }
    public function store(StoreEventRequest $req)
    {
        return RequestHandler::handle(function() use($req) {
            $validData = $req->validated();
            $requirements = $validData['document_requirements'];
            $reviewers = $validData['reviewers'];
            $validData = Arr::except($validData, ['document_requirements', 'reviewers']);

            $event = Event::create($validData);
            array_push($reviewers, $event->author_id);
            $event->requirements()->sync($requirements);
            $event->reviewers()->sync($reviewers);
            return redirect()
            ->route('citizen.event.index')
            ->with('success', 'Event created successfully');
        });
    }
    public function update(UpdateEventRequest $req, $id)
    {
        return RequestHandler::handle(function() use($req, $id) {
            $event = Auth::user()->userable->events->where('id', $id);
            if($event->isEmpty())
            {
                throw new Exception("Event not found", Response::HTTP_NOT_FOUND);
                return;
            }
            $event = $event->first();
            $validData = $req->validated();
            $requirements = $validData['document_requirements'];
            $reviewers = $validData['reviewers'];
            $validData = Arr::except($validData, ['document_requirements', 'reviewers']);
            array_push($reviewers, $event->author_id);

            $event->update($validData);
            $event->requirements()->sync($requirements);
            $event->reviewers()->sync($reviewers);

            return redirect()
            ->route('citizen.event.index')
            ->with('success', 'Event updated successfully');
        });
    }
    public function destroy($id)
    {
        return RequestHandler::handle(function() use($id) {
            $event = Auth::user()->userable->events->where('id', $id)->get();
            if($event->isEmpty())
            {
                throw new Exception("Event not found", Response::HTTP_NOT_FOUND);
                return;
            }
            $event->requirements()->delete();
            $event->delete();
            return redirect()
            ->route('citizen.event.index')
            ->with('success', 'Event deleted successfully');
        });
    }
}
