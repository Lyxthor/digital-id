<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Helpers\RequestHandler;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('auth.login');
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
                        return redirect()->route('citizen.document.index')->with('success', 'citizen logged in successfully');
                    case 'dukcapil' :
                        return redirect()->route('dukcapil.document.index')->with('success', 'dukcapil logged in successfully');
                }
            }
            return back()->with('error', 'invalid credentials');
        });
    }
    public function logout()
    {
        return RequestHandler::handle(function() {
            Auth::logout();
            return redirect()->route('login')->with('success', 'user logged out successfully');
        });
    }


}
