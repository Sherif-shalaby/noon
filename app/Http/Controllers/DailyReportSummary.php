<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\StockTransaction;
use App\Models\TransactionSellLine;
use App\Models\WageTransaction;
use Illuminate\Http\Request;

class DailyReportSummary extends Controller
{
    /* ++++++++++++++++++++++ index() +++++++++++++++++++++ */
    public function index()
    {
        // *********** Transactions of "sell_lines" ***********
        $transactions_sell_lines = TransactionSellLine::with('transaction_payments','transaction_currency_relationship')->get();
        // *********** Transactions of "stock_lines" ***********
        $transactions_stock_lines = StockTransaction::with('transaction_payments','paying_currency_relationship')->get();
        // *********** Employees Wages ***********
        $employees_wage = WageTransaction::select('final_total')->get();
        return view('reports.daily-report-summary.index',compact('transactions_sell_lines','transactions_stock_lines','employees_wage'));
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
