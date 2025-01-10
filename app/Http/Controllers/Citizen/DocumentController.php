<?php

namespace App\Http\Controllers\Citizen;

use App\Helpers\RequestHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Citizen\StoreDocumentRequest;
use App\Http\Requests\Citizen\UpdateDocumentRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use App\Models\DocumentType;

class DocumentController extends Controller
{
    public function index()
    {
        return RequestHandler::handle(function() {
            $user = Auth::user();
            $documents = $user->documents;
            return view('citizen.document.index', compact('documents'));
        });
    }
    public function show($id)
    {
        return RequestHandler::handle(function() use($id) {
            $document = Auth::user()->documents->where('id', $id);
            if($document->count() == 0)
            {
                throw new Exception("Document not found", Response::HTTP_NOT_FOUND);
                return;
            }
            return view('citizen.document.show', compact('document'));
        });
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return RequestHandler::handle(function() use($id) {
            $document = Auth::user()->documents->where('id', $id);
            if($document->count() == 0)
            {
                throw new Exception("Document not found", Response::HTTP_NOT_FOUND);
                return;
            }

            $types = DocumentType::select(['id', 'name'])->get();

            return view('citizen.document.edit', compact('document', 'types'));
        });
    }
    public function store(StoreDocumentRequest $req)
    {
        return RequestHandler::handle(function() use($req) {
            $validData = $req->validated();
            // save image logic here
            $document = Document::create($validData);

            return redirect()
            ->route('citizen.document.index')
            ->with('success', "Document $document->type->name created successfully");
        });
    }
    public function update(UpdateDocumentRequest $req, $id)
    {
        return RequestHandler::handle(function() use($req, $id) {
            $document = Auth::user()->documents->where('id', $id);
            if($document->count() == 0)
            {
                throw new Exception("Document not found", Response::HTTP_NOT_FOUND);
                return;
            }
            $document = $document->first();

            $validData = $req->validated();
            // save image logic here
            $document->update($validData);

            return redirect()
            ->route('citizen.document.index')
            ->with('success', "Document $document->type->name updated successfully");
        });
    }
    public function destroy($id)
    {
        return RequestHandler::handle(function() use($id) {
            $document = Auth::user()->documents->where('id', $id);
            if($document->count() == 0)
            {
                throw new Exception("Document not found", Response::HTTP_NOT_FOUND);
                return;
            }
            $document = $document->first();

            $document->delete();

            return redirect()
            ->route('citizen.document.index')
            ->with('success', "Document $document->type->name deleted successfully");
        });
    }
}
