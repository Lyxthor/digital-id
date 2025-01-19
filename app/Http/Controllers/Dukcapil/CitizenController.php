<?php

namespace App\Http\Controllers\Dukcapil;

use App\Http\Controllers\Controller;
use App\Helpers\RequestHandler;
use App\Helpers\TextCipherHelper;
use App\Helpers\ImageCipherHelper;
use App\Http\Controllers\ImageController;
use App\Http\Requests\Dukcapil\Citizen\StoreCitizenRequest;
use App\Http\Requests\Dukcapil\Citizen\UpdateCitizenRequest;
use App\Models\Citizen;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use App\Models\Document;

class CitizenController extends Controller
{
    public function index()
    {
        return RequestHandler::handle(function() {
            $citizens = Citizen::all();
            $date = new Carbon();
            return view('dukcapil.citizen.index', compact('citizens', 'date'));
        });
    }
    public function search(Request $req)
    {
        return RequestHandler::handle(function() use($req) {
            $citizens = Citizen::select(['id', 'nik', 'name', 'pp_img_path'])
            ->where('nik', 'LIKE', '%'.$req->nik.'%')->get();
            return response()->json([
                'citizens'=>$citizens
            ], 200);
        });
    }
    public function create()
    {
        return RequestHandler::handle(function() {
            $blood_types = config('citizen.blood_types');
            return view('dukcapil.citizen.create', compact('blood_types'));
        });
    }
    public function edit($id)
    {
        return RequestHandler::handle(function() use($id) {
            $citizen = Citizen::find($id);
            $blood_types = config('citizen.blood_types');
            if($citizen==null)
            {
                throw new Exception("Citizen not found", Response::HTTP_NOT_FOUND);
                return;
            }

            return view('dukcapil.citizen.edit', compact('citizen', 'blood_types'));
        });
    }
    public function show($id)
    {
        return RequestHandler::handle(function() use($id) {
            $citizen = Citizen::with(['claim_requests'=>function($query) {
                $query->where('status', '!=', 'accepted');
            }])->find($id);
            if($citizen==null)
            {
                throw new Exception("Citizen not found", Response::HTTP_NOT_FOUND);
                return;
            }
            $documents = Document::ownership($citizen->id)->get();

            return view('dukcapil.citizen.show', compact('citizen', 'documents'));
        });
    }
    public function store(StoreCitizenRequest $req)
    {
        return RequestHandler::handle(function() use($req) {
            $validData = $req->validated();
            $file = $req->file('pp_img');
            $path = ImageController::saveImage($file);
            $validData['pp_img_path'] = $path;
            // <- store profile img here
            unset($validData['pp_img']);
            $citizen = Citizen::create($validData);

            return redirect()
            ->route('dukcapil.citizen.index')
            ->with('success', "citizen $citizen->nik added successfully");
        });
    }
    public function update(UpdateCitizenRequest $req, $id)
    {
        return RequestHandler::handle(function() use($req, $id) {
            $citizen = Citizen::find($id);
            if($citizen==null)
            {
                throw new Exception("Citizen not found", Response::HTTP_NOT_FOUND);
                return;
            }

            $validData = $req->validated();
            if(isset($validData['pp_img']))
            {
                if(Storage::disk('public')->exists("images/$citizen->pp_img_path"))
                {
                    Storage::disk('public')->delete("images/$citizen->pp_img_path");
                }
                $file = $req->file('pp_img');
                $path = ImageController::saveImage($file);
                $validData['pp_img_path'] = $path;
                // <- store profile img here
                unset($validData['pp_img']);
            }

            $citizen->update($validData);

            return redirect()
            ->route('dukcapil.citizen.index')
            ->with('success', "citizen $citizen->nik updated successfully");
        });
    }
    public function destroy($id)
    {
        return RequestHandler::handle(function() use($id) {
            $citizen = Citizen::find($id);
            if($citizen==null)
            {
                throw new Exception("Citizen not found", Response::HTTP_NOT_FOUND);
                return;
            }

            if(Storage::disk('public')->exists("images/$citizen->pp_img_path"))
            {
                Storage::disk('public')->delete("images/$citizen->pp_img_path");
            }
            $citizen->delete();

            return redirect()
            ->route('dukcapil.citizen.index')
            ->with('success', "citizen $citizen->nik updated successfully");
        });
    }
}
