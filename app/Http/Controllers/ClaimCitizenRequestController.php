<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\RequestHandler;
use App\Models\ClaimCitizenRequest;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class ClaimCitizenRequestController extends Controller
{
    public function checkPage()
    {
        return RequestHandler::handle(function()
        {
            return view('auth.claim_request.check');
        });
    }
    public function check(Request $request)
    {
        return RequestHandler::handle(function() use($request)
        {
            if(!isset($request->token) && $request->token != null)
            {
                return back()->with('error', 'token credentials invalid');
            }

            $claimRequest = ClaimCitizenRequest::where('token', $request->token)->first();
            if($claimRequest == null)
            {
                return back()->with('error', 'token credentials invalid');
            }
            if($claimRequest->status == 'accepted')
            {
                return redirect()
                ->route('login')
                ->with('success', 'Request already accepted, login');
            }
            if(Hash::check($request->password, $claimRequest->request_password))
            {
                return view('auth.claim_request.show', compact('claimRequest'));
            }

            return back()->with('error', 'Invalid credentials');
        });
    }

    public function show(Request $request)
    {

    }
    public function cancel($token)
    {
        return RequestHandler::handle(function() use($token)
        {
            $claimRequest = ClaimCitizenRequest::where('token', $token)->get();
            if($claimRequest->isEmpty())
            {
                throw new Exception("Claim not found");
                return;
            }
            $claimRequest = $claimRequest->first();
            $claimRequest->delete();
            return redirect()->route('register')->with('success', 'request deleted successfully');
        });
    }
    public function resend($token)
    {
        return RequestHandler::handle(function() use($token)
        {
            $claimRequest = ClaimCitizenRequest::where('token', $token)->get();
            if($claimRequest->isEmpty())
            {
                throw new Exception("Claim not found");
                return;
            }
            $claimRequest = $claimRequest->first();
            $claimRequest->status = 'waiting';
            $claimRequest->save();
            //return view('auth.claim_request.show', compact('claimRequest'));
        });
    }
}
