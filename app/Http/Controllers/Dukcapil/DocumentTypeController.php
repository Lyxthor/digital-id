<?php

namespace App\Http\Controllers\Dukcapil;

use App\Helpers\RequestHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dukcapil\DocumentType\StoreDocumentTypeRequest;
use App\Http\Requests\Dukcapil\DocumentType\UpdateDocumentTypeRequest;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class DocumentTypeController extends Controller
{
    public function index()
    {
        return RequestHandler::handle(function() {
            $types = DocumentType::paginate(5);
            $search = request()->query('search');
            $types = DocumentType::when($search, function ($query) use ($search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })->paginate(5);
            return view('dukcapil.document_type.index', compact('types'));
        });
    }
    public function store(StoreDocumentTypeRequest $req)
    {
        return RequestHandler::handle(function() use($req) {
            $validData = $req->validated();
            $requisites = $validData['requisites'];
            $typeData = Arr::except($validData, ['requisites']);


            DB::beginTransaction();
            try
            {
                $type = DocumentType::create($typeData);
                $type->requisites()->sync($requisites);
                DB::commit();
            }
            catch(\Throwable $e)
            {
                throw new \Exception($e->getMessage(), $e->getCode());
                DB::rollBack();
            }
            return redirect()->back()->with('success', 'document type created successfully');
        });
    }
    public function update(UpdateDocumentTypeRequest $req, $id)
    {
        return RequestHandler::handle(function() use($req, $id) {
            $type = DocumentType::find($id);
            if($type == null)
            {
                return;
            }
            if($type->documents->isNotEmpty())
            {

                return back()
                ->with('error', "Cant update this type. The type already has document");
            }
            $validData = $req->validated();
            $requisites = $validData['requisites'];
            $typeData = Arr::except($validData, ['requisites']);


            DB::beginTransaction();
            try
            {
                $type->update($typeData);
                $type->requisites()->sync($requisites);
                DB::commit();
            }
            catch(\Throwable $e)
            {
                throw new \Exception($e->getMessage(), $e->getCode());
                DB::rollBack();
            }
            return redirect()->back()->with('success', 'document type updated successfully');
        });
    }
    public function destroy($id)
    {
        return RequestHandler::handle(function() use($id) {
            $type = DocumentType::find($id);
            if($type == null)
            {
                return;
            }
            if($type->documents->isNotEmpty())
            {

                return back()
                ->with('error', "Cant delete this type. The type already has document");
            }
            $type->delete();
            return redirect()->back()->with('success', 'document type deleted successfully');
        });
    }
}
