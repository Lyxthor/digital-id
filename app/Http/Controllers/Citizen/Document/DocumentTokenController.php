<?php

namespace App\Http\Controllers\Citizen\Document;

use App\Helpers\RequestHandler;
use App\Helpers\TextCipherHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Citizen\Token\StoreTokenRequest;
use App\Http\Requests\Citizen\Token\UpdateTokenRequest;
use App\Models\DocumentFolderToken;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\Middleware;
use Exception;

class DocumentTokenController extends Controller
{
    //
    public static function middleware()
    {
        return [
            new Middleware('token.authorized_citizes', only: ['show']),
        ];
    }
    public function store(StoreTokenRequest $req)
    {
        return RequestHandler::handle(function() use($req) {
            $validData = $req->validated();

            $tokenData = Arr::only($validData, ['name', 'folder_id', 'accessibility', 'expires_at']);
            $randomToken = TextCipherHelper::encrypt(Str::random(8).Carbon::now(), env('ENCRYPTION_KEY'));
            $randomToken = base64_encode($randomToken);
            $randomToken = implode(explode('/', $randomToken));
            $tokenData['token'] = $randomToken;
            $token = DocumentFolderToken::create($tokenData);

            if($token->accessibility == 'restricted' && isset($validData['authorized_citizens']))
            {
                $authorizedCitizens = $validData['authorized_citizens'];
                $token->authorized_citizens()->sync($authorizedCitizens);
            }
            return redirect()->back()->with('success', 'token created successfully');
        });
    }
    public function update(UpdateTokenRequest $req, $id)
    {
        return RequestHandler::handle(function() use($req, $id) {
            $token = DocumentFolderToken::find($id);
            if($token == null)
            {
                throw new Exception("Folder not found", Response::HTTP_NOT_FOUND);
                return;
            }

            $validData = $req->validated();
            $tokenData = Arr::only($validData, ['name', 'folder_id', 'accessibility', 'expires_at']);
            $token->update($tokenData);

            if($token->accessibility == 'restricted' && isset($validData['authorized_citizens']))
            {
                $authorizedCitizens = $validData['authorized_citizens'];
                $token->authorized_citizens()->sync($authorizedCitizens);
            }
            else if($token->accessibility == 'public' && $token->authorized_citizens->count() > 0)
            {
                $token->authorized_citizens()->sync([]);
            }
            return redirect()->back()->with('success', 'token updated successfully');

        });
    }
    public function show($token)
    {
        return RequestHandler::handle(function() use($token) {
            $token = DocumentFolderToken::where('token', $token)->get();
            if($token->isEmpty())
            {
                throw new Exception("Token not found", Response::HTTP_NOT_FOUND);
                return;
            }
            $token = $token->first();
            $folder = $token->folder;
            $documents = $folder->documents;

            return view('citizen.document_folder.show', compact('folder', 'documents'));
        });
    }
    public function destroy($id)
    {
        return RequestHandler::handle(function() use($id) {
            $token = DocumentFolderToken::find($id);
            if($token == null)
            {
                throw new Exception("Token not found", Response::HTTP_NOT_FOUND);
                return;
            }
            $token->delete();
            return back()
            ->with('success', 'token deleted successfully');
        });
    }
}
