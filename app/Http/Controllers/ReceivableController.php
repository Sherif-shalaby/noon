<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Customer;
use App\Models\StorePos;
use Illuminate\Http\Request;
use App\Models\TransactionSellLine;
use App\Http\Controllers\Controller;
use App\Models\CashRegisterTransaction;
use App\Models\User;

class ReceivableController extends Controller
{
    /* +++++++++++++++++++++++ index() +++++++++++++++++++++++ */
    public function index(Request $request)
    {
        // ====== paid_by Filter ======
        $payers = StorePos::orderBy('created_at', 'asc')->pluck('name','id');
        // ====== receiver Filter ======
        $receivers = User::orderBy('created_at', 'asc')->pluck('name','id');
        // dd($receivers);

        $query=CashRegisterTransaction::query();
        if( request()->ajax() )
        {
            // ====== date Filter ======
            $cash_register_transactions = $query
            ->when($request->start_date != null && $request->end_date != null , function ($query) use ( $request ) {
                $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
            })
            // receivers Filter
            ->when($request->receiver_filter != null, function ($query) use ($request) {
                // Assuming CashRegisterTransaction has a relationship with CashRegister,
                // and CashRegister has a relationship with User
                $query->whereHas('cash_register', function ($subquery) use ($request) {
                    $subquery->where('user_id', $request->receiver_filter);
                });
            })
            // payers Filter
            ->when($request->payer_filter != null, function ($query) use ($request) {
                // Assuming CashRegisterTransaction has a relationship with CashRegister,
                // and CashRegister has a relationship with User
                $query->whereHas('cash_register', function ($subquery) use ($request) {
                    $subquery->where('store_pos_id', $request->payer_filter);
                });
            })
            // ->latest()->get();
            ->orderBy("created_at","asc")->with('cash_register.cashier','cash_register.store_pos')->get();
            return $cash_register_transactions;
        }
        else
        {
            $cash_register_transactions = CashRegisterTransaction::with('cash_register.cashier','cash_register.store_pos')->orderBy("created_at","asc")->get();
        }
        // dd($cash_register_transactions);
        return view('reports.receivable-report.index',
                    compact('cash_register_transactions','receivers','payers'));
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
