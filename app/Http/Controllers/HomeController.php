<?php

namespace App\Http\Controllers;

use App\Models\BalanceRequestNotification;
use App\Models\Customer;
use App\Models\Store;
use App\Models\System;
use App\Models\User;
use Carbon\Carbon;
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
        $customers = [];
        if(!empty(request()->customer_name) || !empty(request()->customer_phone)){
           $customers = Customer::when(\request()->customer_name != null, function ($query) {
                $query->where('name',\request()->category_id);
            })
           ->when(\request()->customer_phone != null, function ($query) {
               $query->where('phone', 'like', '%' . request()->customer_phone . '%');
           })->orderBy('created_at', 'desc')->get();
//           dd($customers);
        }
        $start_date = new Carbon('first day of this month');
        $end_date = new Carbon('last day of this month');
        $stores = Store::getDropdown();
        $store_ids = [];
        $store_pos_id = null;
        $logo = System::getProperty('logo');
        $site_title = System::getProperty('site_title');
        if (Auth::check()) {
            return view('home.index',compact('logo','site_title',
            'stores',
            'start_date',
            'end_date','customers'));
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
