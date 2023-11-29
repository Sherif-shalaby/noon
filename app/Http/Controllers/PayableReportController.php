<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Product;
use App\Models\Customer;
use App\Models\StorePos;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\StockTransaction;
use App\Http\Controllers\Controller;

class PayableReportController extends Controller
{
    /* +++++++++++++++++++++++ index() +++++++++++++++++++++++ */
    public function index(Request $request)
    {
        // $transactions_stock_lines = StockTransaction::with(['paying_currency_relationship','supplier','created_by_relationship'])->get();
        // return $transactions_stock_lines;

        // ====== stores Filter ======
        $stores = Store::getDropdown();
        // ====== stores_pos Filter ======
        $store_pos = StorePos::orderBy('name', 'asc')->pluck('name', 'id');
        // ====== products Filter ======
        $products = Product::orderBy('name', 'asc')->pluck('name', 'id');
        // ====== suppliers Filter ======
        $suppliers = Supplier::orderBy('name', 'asc')->pluck('name', 'id');


        // dd($store_pos);
        $query=StockTransaction::query();
        if( request()->ajax() )
        {
            // ====== store Filter ======
            $transactions_stock_lines = $query->when($request->store_id != null, function ($query) use ( $request ) {
                $query->where('store_id', $request->store_id);
            })
            // ====== store_pos Filter ======
            // ->when($request->store_pos_id != null, function ($query) use ( $request ) {
            //     $query->where('store_pos_id', $request->store_pos_id);
            // })
            // ====== suppliers Filter ======
            ->when( $request->supplier_id != null,function ($query) use ( $request ) {
                $query->where('supplier_id', $request->supplier_id);
            })
            // ====== products Filter ======
            ->when($request->product_id != null, function ($query) use ($request) {
                $query->whereHas('add_stock_products', function ($subquery) use ($request) {
                    $subquery->where('products.id', $request->product_id);
                });
            })

            // ====== date Filter ======
            ->when( $request->start_date != null && $request->end_date != null , function ($query) use ( $request ) {
                $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
            })
            // ->latest()->get();
            ->orderBy("created_at","asc")->with(['add_stock_products','paying_currency_relationship','supplier','created_by_relationship'])->get();
            return $transactions_stock_lines;
        }
        else
        {
            $transactions_stock_lines = StockTransaction::with(['add_stock_products','paying_currency_relationship','supplier','created_by_relationship'])->orderBy("created_at","asc")->get();
        }
        // return($transactions_stock_lines);
        return view('reports.payable-report.index',
                compact('transactions_stock_lines','stores',
                            'suppliers','store_pos','products'));
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
