<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function citizenIndex(){
        return view('citizen.dashboard');
    }

    public function dukcapilIndex(){
        return view('dukcapil.dashboard');
    }

}
