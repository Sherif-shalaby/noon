<?php

namespace App\Http\Controllers;

use App\Models\System;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
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
     * @return Application|RedirectResponse|Redirector
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
        if (Hash::check(request()->value['value'], $user->password)) {
            return ['success' => true];
        }
        return ['success' => false];
    }
}
