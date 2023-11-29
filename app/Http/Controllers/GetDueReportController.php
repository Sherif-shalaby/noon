<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\StorePos;
use App\Models\TransactionSellLine;
use Illuminate\Http\Request;

class GetDueReportController extends Controller
{
    /* +++++++++++++++++++ index() +++++++++++++++++++ */
    public function index()
    {
        $query= TransactionSellLine::where('payment_status', '!=', 'paid')->where('status', 'final');
        if (!empty(request()->store_id)) {
            $query->where('store_id', request()->store_id);
        }
        if (!empty(request()->pos_id)) {
            $query->where('store_pos_id', request()->pos_id);
        }
        if (!empty(request()->start_date)) {
            $query->whereDate('transaction_date', '>=', request()->start_date);
        }
        if (!empty(request()->end_date)) {
            $query->whereDate('transaction_date', '<=', request()->end_date);
        }
        $dues=$query->latest()->get();
        
        $stores = Store::getDropdown();
        $store_pos = StorePos::orderBy('name', 'asc')->pluck('name', 'id');
        return view('reports.get-due-report.index',compact('dues','stores','store_pos'));
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
