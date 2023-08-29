<?php

namespace App\Http\Controllers;

use App\Models\SellLine;
use App\Models\TransactionSellLine;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SellPosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $sell_lines = SellLine::with('transaction','product')->get();
//        dd($sell_lines);
        return view('invoices.index',compact('sell_lines'));

    }

    public function showInvoice(){
        //        dd(TransactionSellLine::all()->last());
        $transaction = TransactionSellLine::all()->last();
//        dd($transaction->transaction_sell_lines);
        $payment_types = $this->getPaymentTypeArrayForPos();
        $invoice_lang = request()->session()->get('language');

        return view('invoices.partials.invoice',compact('transaction','payment_types','invoice_lang'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {

    }

    public function getPaymentTypeArrayForPos()
    {
        return [
            'cash' => __('lang.cash'),
        ];
    }
}
