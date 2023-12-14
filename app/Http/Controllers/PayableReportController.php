<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Customer;
use App\Models\StorePos;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\WageTransaction;
use App\Models\StockTransaction;
use App\Http\Controllers\Controller;

class PayableReportController extends Controller
{
    /* +++++++++++++++++++++++ index() +++++++++++++++++++++++ */
    public function index(Request $request)
    {
        // *********** WageTransaction ***********
        $wage_transactions = WageTransaction::get();
        // *********** StockTransaction ***********
        $stock_transactions = StockTransaction::get();
        // *********** branches filter ***********
        $branches = Branch::where('type','branch')->orderBy('created_at', 'desc')->pluck('name','id');
        // *********** stores filter ***********
        $stores = Store::orderBy('created_at', 'desc')->pluck('name','id');
        // query1 => WageTransaction , query2 => StockTransaction
        $query1=WageTransaction::query();
        $query2=StockTransaction::query();

        if( request()->ajax() )
        {
            // ====== start , end date Filter ======
            // wages Transaction
            $wage_transactions = $query1
            // start , end date Filter
            ->when( $request->start_date != null && $request->end_date != null , function ($query) use ( $request ) {
                $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
            })
            // store Filter
            ->when( $request->store_filter != null , function ($query) use ( $request ) {
                $query->where('store_id',$request->store_filter);
            })
            ->orderBy("created_at","asc")->get();
            // stock Transaction
            $stock_transactions = $query2
            // start , end date Filter
            ->when( $request->start_date != null && $request->end_date != null , function ($query) use ( $request ) {
                $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
            })
            // store Filter
            ->when($request->store_filter != null , function ($query) use ( $request ) {
                $query->where('store_id',$request->store_filter);
            })
            ->orderBy("created_at","asc")->get();
            // Calculate totals outside the loop
            $wage_transactions_final_total = !empty($wage_transactions->sum('final_total')) ? $wage_transactions->sum('final_total') : '';
            $stock_transactions_final_total = !empty($stock_transactions->sum('final_total')) ? $stock_transactions->sum('final_total') : '';
            // Return multiple values as an associative array
            return response()->json([
                'wage_transactions_final_total' => $wage_transactions_final_total,
                'stock_transactions_final_total' => $stock_transactions_final_total,
            ]);
        }
        else
        {
            $transactions_stock_lines = StockTransaction::with(['add_stock_products','paying_currency_relationship','supplier','created_by_relationship'])->orderBy("created_at","asc")->get();
        }


        return view('reports.payable-report.index',
                    compact('wage_transactions','stock_transactions','branches'));
    }
    // =========== branch and store filter ===========
    // ++++++ fetch_branch_stores() : Get stores According to "selected branch" selectbox ++++++
    public function fetch_branch_stores(Request $request)
    {
        $data['store_id'] = Store::where('branch_id', $request->branch_id)->get(['id','name']);
        return response()->json($data);
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
