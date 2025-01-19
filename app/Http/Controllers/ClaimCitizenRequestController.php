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
    public function see($token)
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
            if($claimRequest->status == 'accepted')
            {
                return redirect()->route('login')->with('success', 'Request already accepted, login');
            }
            return view('auth.claim_request.see', compact('claimRequest'));
        });
    }
    public function show(Request $request, $token)
    {
        return RequestHandler::handle(function() use($request, $token)
        {

            if(!isset($request->password))
            {
                return back()->with('error', 'your password is required');
            }
            $claimRequest = ClaimCitizenRequest::where('token', $token)->get();
            if($claimRequest->isEmpty())
            {
                throw new Exception("Claim not found");
                return;
            }
            $claimRequest = $claimRequest->first();
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
