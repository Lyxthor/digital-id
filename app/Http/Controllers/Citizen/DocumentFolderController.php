<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\RequestHandler;
use App\Http\Requests\Citizen\StoreDocumentFolder;
use App\Http\Requests\Dukcapil\Document\UpdateDocumentRequest;
use App\Models\DocumentFolder;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class DocumentFolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return RequestHandler::handle(function() {
            // $user = Auth::user();
            // $folders = $user->folders;
            $folders = DocumentFolder::all();
            return view('citizen.document_folder.index', compact('folders'));
        });
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return RequestHandler::handle(function() {
            $user = Auth::user();
            $documents = $user->documents;
            return view('citizen.document_folder.create', compact('documents'));
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentFolder $req)
    {
        //
        return RequestHandler::handle(function() use($req) {
            $validData = $req->validated();
            $documents = $validData['documents'];
            unset($validData['documents']);
            $folder = DocumentFolder::create($validData);
            $folder->documents()->sync($documents);

            return redirect()
            ->route('citizen.document_folder.index')
            ->with('success', 'Documents folder created successfully');
        });
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return RequestHandler::handle(function() use($id) {
            $folder = DocumentFolder::with(['documents'])->find($id);
            if($folder == null)
            {
                throw new Exception("Folder not found", Response::HTTP_NOT_FOUND);
                return;
            }

            return view('citizen.document_folder.show', compact('folder'));
        });
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return RequestHandler::handle(function() use($id) {
            $folder = DocumentFolder::with(['documents'])->find($id);
            if($folder == null)
            {
                throw new Exception("Folder not found", Response::HTTP_NOT_FOUND);
                return;
            }

            $user = Auth::user();
            $documents = $user->documents;

            return view('citizen.document_folder.edit', compact('folder', 'documents'));
        });
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocumentRequest $req, string $id)
    {
        return RequestHandler::handle(function() use($req, $id) {
            $folder = DocumentFolder::with(['documents'])->find($id);
            if($folder == null)
            {
                throw new Exception("Folder not found", Response::HTTP_NOT_FOUND);
                return;
            }

            $validData = $req->validated();
            $documents = $validData['documents'];
            unset($validData['documents']);
            $folder->update($validData);
            $folder->documents()->sync($documents);

            return redirect()
            ->route('citizen.document_folder.index')
            ->with('success', 'Documents folder updated successfully');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return RequestHandler::handle(function() use($id) {
            $folder = DocumentFolder::with(['documents'])->find($id);
            if($folder == null)
            {
                throw new Exception("Folder not found", Response::HTTP_NOT_FOUND);
                return;
            }

            $folder->delete();

            return redirect()
            ->route('citizen.document_folder.index')
            ->with('success', 'Documents folder deleted successfully');
        });
    }
}
