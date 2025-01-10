<?php

namespace App\Http\Controllers\Citizen;

use App\Helpers\RequestHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Citizen\StoreEventRequest;
use App\Http\Requests\Citizen\UpdateEventRequest;
use App\Models\DocumentType;
use App\Models\Event;
use App\Models\EventDocumentRequirement;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        return RequestHandler::handle(function() {
            $user = Auth::user();
            $events = $user->events;

            return view('citizen.event.index', compact('events'));
        });
    }
    public function create()
    {
        return RequestHandler::handle(function() {
            $document_types = DocumentType::select(['id', 'name'])->get();
            return view('citizen.event.index', compact('document_types'));
        });
    }
    public function edit($id)
    {
        return RequestHandler::handle(function() use($id) {
            $event = Auth::user()->events->where('id', $id);
            if($event->count() == 0)
            {
                throw new Exception("Event not found", Response::HTTP_NOT_FOUND);
                return;
            }
            $event = $event->first();
            $document_types = DocumentType::select(['id', 'name'])->get();

            return view('citizen.event.edit', compact('event', 'document_types'));
        });
    }
    public function show($id)
    {
        return RequestHandler::handle(function() use($id) {
            $event = Auth::user()->events->where('id', $id);
            if($event->count() == 0)
            {
                throw new Exception("Event not found", Response::HTTP_NOT_FOUND);
                return;
            }
            $event = $event->first();

            return view('citizen.event.show', compact('event'));
        });
    }
    public function store(StoreEventRequest $req)
    {
        return RequestHandler::handle(function() use($req) {
            $validData = $req->validated();
            $requirements = $validData['document_requirements'];
            unset($validData['document_requirements']);

            $event = Event::create($validData);
            foreach($requirements as $r)
            {
                $reqData =
                [
                    "event_id"=>$event->id,
                    "type_id"=>$r
                ];
                EventDocumentRequirement::create($reqData);
            }
            return redirect()
            ->route('citizen.event.index')
            ->with('success', 'Event created successfully');
        });
    }
    public function update(UpdateEventRequest $req, $id)
    {
        return RequestHandler::handle(function() use($req, $id) {
            $event = Auth::user()->events->where('id', $id);
            if($event->count() == 0)
            {
                throw new Exception("Event not found", Response::HTTP_NOT_FOUND);
                return;
            }
            $event = $event->first();
            $validData = $req->validated();
            $requirements = $validData['document_requirements'];
            unset($validData['document_requirements']);

            $event->document_requirements()->delete();
            $event->update($validData);
            foreach($requirements as $r)
            {
                $reqData =
                [
                    "event_id"=>$event->id,
                    "type_id"=>$r
                ];
                EventDocumentRequirement::create($reqData);
            }

            return redirect()
            ->route('citizen.event.index')
            ->with('success', 'Event updated successfully');
        });
    }
    public function destroy($id)
    {
        return RequestHandler::handle(function() use($id) {
            $event = Auth::user()->events->where('id', $id);
            if($event->count() == 0)
            {
                throw new Exception("Event not found", Response::HTTP_NOT_FOUND);
                return;
            }
            $event->delete();

            return redirect()
            ->route('citizen.event.index')
            ->with('success', 'Event deleted successfully');
        });
    }
}
