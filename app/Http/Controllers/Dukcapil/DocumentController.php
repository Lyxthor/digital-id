<?php

namespace App\Http\Controllers\Dukcapil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\RequestHandler;
use App\Http\Requests\Dukcapil\Document\IndexDocumentRequest;
use App\Http\Requests\Dukcapil\Document\StoreDocumentRequest;
use App\Http\Requests\Dukcapil\Document\UpdateDocumentRequest;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Citizen;
use Illuminate\Http\Response;
use Exception;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexDocumentRequest $req)
    {
        return RequestHandler::handle(function() use($req) {
            $validData = $req->validated();
            $citizen = $validData['citizen'];
            $documents = $citizen->documents;
            return view('dukcapil.document.index', compact('documents'));
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $req)
    {
        return RequestHandler::handle(function() use($req) {
            $citizen = Citizen::find($req->citizen);
            if($citizen == null)
            {
                throw new Exception("Citizen not found", Response::HTTP_NOT_FOUND);
                return;
            }
            $types = DocumentType::select(['id', 'name'])->where('category', 'protected')->get();
            return view('dukcapil.document.create', compact('types', 'citizen'));
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentRequest $req)
    {
        return RequestHandler::handle(function() use($req) {
            $validData = $req->validated();
            $citizen = $validData['citizen'];
            //unset($validData['citizen']);
            // save image logic here
            $type = DocumentType::find($validData['type_id']);
            $type = implode("_", explode(" ", $type->name));
            $type = strtolower($type);
            return view("templates.$type", compact('citizen'));
            // $document = Document::create($validData);

            // return redirect()
            // ->route('dukcapil.document.index')
            // ->with('success', "Document $document->type->name for citizen $citizen->nik created successfully");
        });
    }
    public function save(Request $req)
    {
        return RequestHandler::handle(function() use($req) {
            $document = Document::create($req->all());
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
