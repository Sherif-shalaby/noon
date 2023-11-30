<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Customer;
use App\Models\StorePos;
use Illuminate\Http\Request;
use App\Models\TransactionSellLine;
use App\Http\Controllers\Controller;

class ReceivableController extends Controller
{
    /* +++++++++++++++++++++++ index() +++++++++++++++++++++++ */
    public function index(Request $request)
    {
        // $transaction_sell_lines = TransactionSellLine::with(['transaction_currency_relationship','customer'])->get();
        // $query = TransactionSellLine::with(['transaction_currency_relationship','customer']);
        // if (!empty(request()->customer_id))
        // {
        //     $query->where('customer_id', request()->customer_id);
        // }
        // $transaction_sell_lines = $query->get();
        // ====== customers Filter ======
        $customers = Customer::orderBy('name', 'asc')->pluck('name', 'id');
        // ====== stores Filter ======
        $stores = Store::getDropdown();
        // ====== stores_pos Filter ======
        $store_pos = StorePos::orderBy('name', 'asc')->pluck('name', 'id');
        // dd($store_pos);

        $query=TransactionSellLine::query();
        if( request()->ajax() )
        {
            // ====== store Filter ======
            $transaction_sell_lines = $query->when($request->store_id != null, function ($query) use ( $request ) {
                $query->where('store_id', $request->store_id);
            })
            // ====== store Filter ======
            ->when($request->store_pos_id != null, function ($query) use ( $request ) {
                $query->where('store_pos_id', $request->store_pos_id);
            })
            // ====== customers Filter ======
            ->when( $request->customer_id != null,function ($query) use ( $request ) {
                $query->where('customer_id', $request->customer_id);
            })
            // ====== date Filter ======
            ->when( $request->start_date != null && $request->end_date != null , function ($query) use ( $request ) {
                $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
            })
            // ->latest()->get();
            ->orderBy("created_at","asc")->with(['transaction_currency_relationship','customer','store_pos'])->get();
            return $transaction_sell_lines;
        }
        else
        {
            $transaction_sell_lines = TransactionSellLine::with(['transaction_currency_relationship','customer','store_pos'])->orderBy("created_at","asc")->get();
        }
        return view('reports.receivable-report.index',
                    compact('transaction_sell_lines','customers',
                                    'stores','store_pos'));
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
