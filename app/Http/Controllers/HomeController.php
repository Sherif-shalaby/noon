<?php

namespace App\Http\Controllers;

use App\Models\System;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
    public function checkPassword()
    {
        $user = User::find(request()->user()->id);
        if (Hash::check(request()->value, $user->password)) {
            return ['success' => true];
        }
        return ['success' => false];
    }
}
