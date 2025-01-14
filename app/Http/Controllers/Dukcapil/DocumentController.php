<?php

namespace App\Http\Controllers\Dukcapil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\RequestHandler;
use App\Http\Requests\Dukcapil\Document\IndexDocumentRequest;
use App\Http\Requests\Dukcapil\Document\StoreDocumentRequest;
use App\Http\Requests\Dukcapil\Document\UpdateDocumentRequest;
use App\Http\Requests\Dukcapil\Document\GenerateDocumentRequest;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Citizen;
use App\Models\SocialUnit;
use Illuminate\Http\Response;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        return RequestHandler::handle(function() use($req) {
            $citizen = Citizen::find($req->citizen);
            if($citizen == null)
            {
                throw new Exception("Citizen not found", Response::HTTP_NOT_FOUND);
                return;
            }
            $documents = $citizen->documents;
            return view('dukcapil.document.index', compact('documents', 'citizen'));
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return RequestHandler::handle(function() {
            // $citizen = Citizen::find($req->citizen);
            // if($citizen == null)
            // {
            //     throw new Exception("Citizen not found", Response::HTTP_NOT_FOUND);
            //     return;
            // }
            $types = DocumentType::select(['id', 'name'])->where('category', 'official')->get();
            return view('dukcapil.document.create', compact('types'));
        });
    }
    public function generate(GenerateDocumentRequest $req)
    {
        return RequestHandler::handle(function() use($req) {
            $validData = $req->validated();
            $members = $validData['members'];
            $owner = $validData['owner'];
            $type = $validData['type'];
            $additional = $validData['additional'];

            $templateName = implode("_", explode(" ", $type->name));
            $templateName = strtolower($templateName);

            return view("templates.$templateName", compact('members', 'owner', 'type', 'additional'));
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentRequest $req)
    {
        return RequestHandler::handle(function() use($req) {
            $validData = $req->validated();
            $socialUnitData = Arr::only($validData, ["owner_id"]);
            $documentData = Arr::only($validData, ["filename", "type_id", "name"]);

            $members = $validData['members'];
            unset($validData['members']);

            DB::beginTransaction();
            $socialUnit = SocialUnit::create($socialUnitData);
            $documentData['unit_id'] = $socialUnit->id;
            $document = Document::create($documentData);

            try
            {
                foreach($members as $m)
                {
                    $document->members()->attach($m['id'], ['role'=>$m['role']]);
                }
                DB::commit();
            }
            catch(\Exception $e)
            {
                DB::rollBack();
                throw new Exception($e->getMessage(), 500);
            }


            return redirect()
            ->route('citizen.document.index')
            ->with('success', 'document created successfully');
        });
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return RequestHandler::handle(function() use($id) {
            $document = Document::find($id);
            if($document==null)
            {
                throw new Exception("Document not found", Response::HTTP_NOT_FOUND);
                return;
            }

            return view('dukcapil.document.show', compact('document'));
        });
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return RequestHandler::handle(function() use($id) {
            $document = Document::find($id);
            if($document==null)
            {
                throw new Exception("Document not found", Response::HTTP_NOT_FOUND);
                return;
            }

            $types = DocumentType::select(['id', 'name'])->get();

            return view('dukcapil.document.show', compact('document'));
        });
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocumentRequest $req, $id)
    {
        return RequestHandler::handle(function() use($req, $id) {
            $document = Document::find($id);
            if($document==null)
            {
                throw new Exception("Document not found", Response::HTTP_NOT_FOUND);
                return;
            }

            $validData = $req->validated();
            $citizen = $document->citizen;
            // save image logic here
            $document->update($validData);

            return redirect()
            ->route('dukcapil.document.index')
            ->with('success', "Document $document->type->name for citizen $citizen->nik updated successfully");
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return RequestHandler::handle(function() use($id) {
            $document = Document::find($id);
            if($document==null)
            {
                throw new Exception("Document not found", Response::HTTP_NOT_FOUND);
                return;
            }

            $citizen = $document->citizen;
            $document->delete();

            return redirect()
            ->route('dukcapil.document.index')
            ->with('success', "Document $document->type->name for citizen $citizen->nik deleted");
        });
    }
}
