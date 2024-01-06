<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;
use App\Models\System;
use App\Models\StorePos;
use App\Models\CashRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CashController extends Controller
{
    /* ++++++++++++++++++++++ index() ++++++++++++++++++++++ */
    public function index()
    {
        $default_currency_id = System::getProperty('currency');
        // Retrieve data for dropdowns
        $stores = Store::getDropdown();
        $store_pos = StorePos::orderBy('name', 'asc')->pluck('name', 'id');
        $users = User::Notview()->orderBy('name', 'asc')->pluck('name', 'id');

        // Retrieve cash registers with related transactions and cashier
        $query = CashRegister::with(['cashRegisterTransactions', 'cashier']);
        // +++++++ filters +++++++
        // 1- start_date filter
        if (!empty(request()->start_date))
        {
            $query->whereDate('created_at', '>=', request()->start_date);
        }
        // 2- end_date filter
        if (!empty(request()->end_date))
        {
            $query->whereDate('created_at', '<=', request()->end_date);
        }
        // 3- store_pos filter
        if (!empty(request()->store_pos_id))
        {
            $query->where('store_pos_id', request()->store_pos_id);
        }
        // 4- store filter
        if (!empty(request()->store_id))
        {
            $query->where('store_id', request()->store_id);
        }
        // 5- users filter
        if (!empty(request()->user_id))
        {
            $query->where('user_id', request()->user_id);
        }
        $cash_registers = $query->orderBy('created_at', 'desc')->get();
        // Iterate through each cash register
        foreach ($cash_registers as $register)
        {
            // Access the calculated attributes using accessor methods
            $totalSale = $register->totalSale;
            $totalDiningIn = $register->totalDiningIn;
            $totalDiningInCash = $register->totalDiningInCash;
            $totalCashSales = $register->totalCashSales;
            $totalRefundCash = $register->totalRefundCash;
            $totalCardSales = $register->totalCardSales;
            // Perform the manipulation within the controller
            $register->total_cash_sales -= $register->total_refund_cash;
            $register->total_card_sales -= $register->total_refund_card;
            // Store the manipulated values back in the cash register model
            $cr_data[$register->id]['cash_register'] = $register;
        }
        return view('cash.index', compact('cash_registers', 'stores', 'users', 'store_pos'));
    }
    /* ++++++++++++++++++++++ show() ++++++++++++++++++++++ */
    public function show($id)
    {
        $cash_register = CashRegister::withCount([
            'cashRegisterTransactions as total_dining_in' => function ($query) {
                $query->where('transaction_type', 'sell')
                    ->where('pay_method', 'cash')
                    ->where('type', 'credit')
                    ->select(DB::raw("SUM(amount)"));
            },
            'cashRegisterTransactions as total_sale' => function ($query) {
                $query->where('transaction_type', 'sell')
                    ->select(DB::raw("SUM(amount)"));
            },
            'cashRegisterTransactions as total_refund' => function ($query) {
                $query->where('transaction_type', 'refund')
                    ->select(DB::raw("SUM(amount)"));
            },
            'cashRegisterTransactions as total_cash_sales' => function ($query) {
                $query->where('transaction_type', 'sell')
                    ->where('pay_method', 'cash')
                    ->where('type', 'credit')
                    ->select(DB::raw("SUM(amount)"));
            },
            'cashRegisterTransactions as total_refund_cash' => function ($query) {
                $query->where('transaction_type', 'refund')
                    ->where('pay_method', 'cash')
                    ->where('type', 'debit')
                    ->select(DB::raw("SUM(amount)"));
            },
        ])->findOrFail($id);

        return view('cash.show', compact('cash_register'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
