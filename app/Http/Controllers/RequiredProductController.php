<?php

namespace App\Http\Controllers;

use App\Models\RequiredProduct;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequiredProductController extends Controller
{
    /* ++++++++++++++++++++ index() +++++++++++++++++++++  */
    public function index()
    {
        return view('purchase_order.required_products.index');
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
     * @param  \App\Models\RequiredProduct  $requiredProduct
     * @return \Illuminate\Http\Response
     */
    public function show(RequiredProduct $requiredProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RequiredProduct  $requiredProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(RequiredProduct $requiredProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RequiredProduct  $requiredProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequiredProduct $requiredProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RequiredProduct  $requiredProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequiredProduct $requiredProduct)
    {
        //
    }
}
