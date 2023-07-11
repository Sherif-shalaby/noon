<?php

namespace App\Http\Controllers;

use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $logo = System::getProperty('logo');
        $site_title = System::getProperty('site_title');
        if (Auth::check()) {
            return view('home.index',compact('logo','site_title'));
        } else {
            return redirect('/login');
        }
    }
}
