<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Helpers\RequestHandler;
use App\Http\Requests\CitizenDataClaimRequest;
use App\Models\ClaimCitizenRequest;
use Illuminate\Support\Str;
use App\Models\Citizen;
use Exception;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('auth.login');
    }
    public function registerPage()
    {
        return view('auth.register');
    }
    public function login(LoginRequest $req)
    {
        return RequestHandler::handle(function() use($req) {
            $credentials = $req->validated();
            if(Auth::attempt($credentials))
            {
                $user = Auth::user();
                switch($user->userable_type)
                {
                    case 'citizen' :
                        return redirect()
                        ->route('dashboard.citizen')
                        ->with('success', 'citizen logged in successfully');
                    case 'dukcapil' :
                        return redirect()
                        ->route('dashboard.dukcapil')
                        ->with('success', 'dukcapil logged in successfully');
                }
            }
            return back()
            ->with('error', 'invalid credentials');
        });
    }
    public function register(CitizenDataClaimRequest $req)
    {
        return RequestHandler::handle(function() use($req)
        {
            $validData = $req->validated();
            $citizen = Citizen::where('nik', $validData['nik']);
            if($citizen->has('user'))
            {
                return back()->with('error', 'This citizen already has user');
            }
            $randomToken = Str::random(12);
            $validData['status'] = 'waiting';
            $validData['citizen_id'] = $citizen->id;
            $validData['request_password'] = bcrypt($validData['request_password']);
            $validData['token'] = $randomToken;

            $claimRequest = ClaimCitizenRequest::create($validData);
            return view('auth.claim_request.show', compact('claimRequest'))->with('success', 'request sent successfully, copy the token to monitor request status');
        });
    }

    public function logout()
    {
        return RequestHandler::handle(function() {
            Auth::logout();
            return redirect()
            ->route('login')
            ->with('success', 'user logged out successfully');
        });
    }



}
