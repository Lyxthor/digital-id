<?php

namespace App\Http\Controllers\Citizen;

use App\Helpers\RequestHandler;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
use App\Http\Requests\Citizen\Document\StoreDocumentRequest;
use App\Http\Requests\Citizen\Document\UpdateDocumentRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use App\Models\DocumentType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Models\SocialUnit;

class DocumentController extends Controller
{
    public function index()
    {
        return RequestHandler::handle(function() {
            $user = Auth::user();
            $id = $user->userable_id;
            $documents = Document::ownership($id)->get();
            $officialDocuments = $documents->filter(function($doc) {
                return $doc->type->category == 'official';
            });
            $customDocuments = $documents->filter(function($doc) {
                return $doc->type->category == 'custom';
            });
            $types = DocumentType::select(['id', 'name'])->where('category', 'custom')->get();
            return view('citizen.document.index', compact('customDocuments', 'officialDocuments','types'));
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
            $socialUnitData = ["owner_id"=>Auth::user()->userable->id];
            $documentData = Arr::only($validData, ["type_id", "name"]);

            DB::beginTransaction();


            try
            {
                $fileName = ImageController::saveImage($validData['file']);
                $documentData['filename'] = $fileName;

                $socialUnit = SocialUnit::create($socialUnitData);
                $documentData['unit_id'] = $socialUnit->id;
                $document = Document::create($documentData);

                $socialUnit->citizens()->sync([$socialUnit->owner_id=>['role'=>'owner']]);
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
    public function update(UpdateDocumentRequest $req, $id)
    {
        return RequestHandler::handle(function() use($req, $id) {
            $document = Document::ownership(Auth::user()->userable_id)->where('id', $id)->get();
            if($document->count() == 0)
            {
                throw new Exception("Document not found", Response::HTTP_NOT_FOUND);
                return;
            }
            $document = $document->first();
            $validData = $req->validated();
            $documentData = Arr::only($validData, ["type_id", "name"]);

            DB::beginTransaction();


            try
            {

                if(isset($validData['file']) && $validData['file'] != null)
                {
                    ImageController::destroy($document->filename);
                    $fileName = ImageController::saveImage($validData['file']);
                    $documentData['filename'] = $fileName;
                }
                $document->update($documentData);
                DB::commit();
            }
            catch(\Exception $e)
            {
                DB::rollBack();
                throw new Exception($e->getMessage(), 500);
            }


            return redirect()
            ->route('citizen.document.index')
            ->with('success', 'document updated successfully');
        });
    }
    public function destroy($id)
    {
        return RequestHandler::handle(function() use($id) {
            $citizen = Auth::user()->userable;
            $document = Document::ownership($citizen->id);
            if($document->count() == 0)
            {
                throw new Exception("Document not found", Response::HTTP_NOT_FOUND);
                return;
            }
            $document = $document->first();
            ImageController::destroy($document->filename);
            $document->delete();

            return redirect()
            ->route('citizen.document.index')
            ->with('success', "Document deleted successfully");
        });
    }
}
