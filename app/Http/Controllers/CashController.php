<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;
use App\Models\System;
use App\Models\StorePos;
use App\Models\CashRegister;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CashController extends Controller
{
    /* ++++++++++++++++++++++ index() ++++++++++++++++++++++ */
    // public function index()
    // {
    //     $default_currency_id = System::getProperty('currency');
    //     // $cash_registers = CashRegister::with('cash_register_transactions','cashier')->orderBy('cash_registers.created_at', 'desc')->get();
    //     // dd($cash_registers);
    //     $stores = Store::getDropdown();
    //     $store_pos = StorePos::orderBy('name', 'asc')->pluck('name', 'id');
    //     $users = User::Notview()->orderBy('name', 'asc')->pluck('name', 'id');
    //     $cash_registers = CashRegister::with('cashRegisterTransactions')->get();
    //     foreach ($cash_registers as $register)
    //     {
    //         $totalSale = $register->totalSale;
    //         $totalDiningIn = $register->totalDiningIn;
    //         $totalDiningInCash = $register->totalDiningInCash;
    //         $totalCashSales = $register->totalCashSales;
    //         $totalRefundCash = $register->totalRefundCash;
    //     }
    //     return view('cash.index', compact('cash_registers','stores','users','store_pos') );
    // }
        public function index()
        {
            $default_currency_id = System::getProperty('currency');
            // Retrieve data for dropdowns
            $stores = Store::getDropdown();
            $store_pos = StorePos::orderBy('name', 'asc')->pluck('name', 'id');
            $users = User::Notview()->orderBy('name', 'asc')->pluck('name', 'id');

            // Retrieve cash registers with related transactions and cashier
            $cash_registers = CashRegister::with(['cashRegisterTransactions', 'cashier'])->orderBy('created_at', 'desc')->get();

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
