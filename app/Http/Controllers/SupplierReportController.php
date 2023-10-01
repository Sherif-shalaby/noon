<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AddStockLine;
use App\Models\PurchaseOrderLine;
use App\Models\PurchaseOrderTransaction;
use Illuminate\Http\Request;

class SupplierReportController extends Controller
{
    /* ++++++++++++++++++++ index() ++++++++++++++++++++ */
    public function index()
    {
        // ++++++++++++++ "supplier_report" => "شراء" ++++++++++++++
        $purchase_orders = PurchaseOrderTransaction::get();
        $add_stocks = AddStockLine::with('transaction.supplier','transaction.transaction_payments','product')->get();
        // ++++++++++++++ "supplier_report" => "امر شراء" ++++++++++++++
        $supplier_purchase_orders = PurchaseOrderLine::with('transaction.supplier','product')->get();
        // return $supplier_purchase_orders;
        return view('reports.suppliers-report.index',compact('purchase_orders','add_stocks','supplier_purchase_orders'));
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
