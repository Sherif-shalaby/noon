<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\StockTransaction;
use App\Models\Supplier;
use App\Models\User;
use App\Utils\Util;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ReturnStockController extends Controller
{
    protected $commonUtil;

    public function __construct(Util $commonUtil)
    {
        $this->commonUtil = $commonUtil;

    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $suppliers = Supplier::orderBy('created_at', 'desc')->pluck('name','id');
        $users = User::orderBy('created_at', 'desc')->pluck('name','id');
        $brands = Brand::pluck('name','id');
        $payment_status_array = $this->commonUtil->getPaymentStatusArray();
        $payment_type_array = $this->commonUtil->getPaymentTypeArray();

        $stocks =  StockTransaction::
            when(\request()->po_no, function ($query) {
                $query->where('po_no','like', '%' . \request()->po_no . '%');
            })
            ->when(\request()->supplier_id != null, function ($query) {
                $query->where('supplier_id',\request()->supplier_id);
            })
            ->when(\request()->created_by != null, function ($query) {
                $query->where('created_by',\request()->created_by);
            })
            ->when(\request()->brand_id != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('id', \request()->brand_id);
                });
            })
            ->when(\request()->product_name != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('name', 'like', '%' . \request()->product_name . '%');
                });
            })
            ->when(\request()->product_sku != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('sku', 'like', '%' . \request()->product_sku . '%');
                });
            })
            ->when(\request()->product_symbol != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('product_symbol', 'like', '%' . \request()->product_symbol . '%');
                });
            })
            ->when(\request()->from != null, function ($query){
                $query->where('created_at', '>=', \request()->from);
            })
            ->when(\request()->to, function ($query){
                return $query->where('created_at', '<=', \request()->to);
            })
            ->orderBy('created_at', 'desc')->get();
        return  view('suppliers.returns.invoice',compact('brands', 'suppliers','users',
            'payment_status_array','stocks','payment_type_array'));
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
