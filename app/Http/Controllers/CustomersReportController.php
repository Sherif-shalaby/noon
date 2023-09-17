<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TransactionSellLine;
use Illuminate\Http\Request;

class CustomersReportController extends Controller
{
    /* ++++++++++++++++++ index() +++++++++++++++++ */
    public function index()
    {
        $customer_transactions_sell_lines = TransactionSellLine::with('transaction_sell_lines.product','transaction_payments.created_by_user','customer')->orderBy('customer_id')->get();
        // return $customer_transactions_sell_lines;
        return view('reports.customers-report.index',compact('customer_transactions_sell_lines'));
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
