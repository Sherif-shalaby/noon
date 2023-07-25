<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Currency;
use App\Models\Product;
use App\Models\Size;
use App\Models\StockTransaction;
use App\Models\Store;
use App\Models\Unit;
use App\Models\User;
use App\Utils\Util;
use http\Client\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class AddStockController extends Controller
{
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
        return view('add_stock.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
//        $suppliers = Supplier::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
//        $po_nos = StockTransaction::where('type', 'purchase_order')->where('status', '!=', 'received')->pluck('po_no', 'id');
        $status_array = $this->commonUtil->getPurchaseOrderStatusArray();
        $payment_status_array = $this->commonUtil->getPaymentStatusArray();
        $payment_type_array = $this->commonUtil->getPaymentTypeArray();
        $payment_types = $payment_type_array;

        $variation_id = request()->get('variation_id');
        $product_id = request()->get('product_id');

        $is_raw_material = request()->segment(1) == 'raw-material' ? true : false;

        $sub_categories = Category::whereNotNull('parent_id')->orderBy('name', 'asc')->pluck('name', 'id');
        $colors = Color::orderBy('name', 'asc')->pluck('name', 'id');
        $sizes = Size::orderBy('name', 'asc')->pluck('name', 'id');
//        $exchange_rate_currencies = $this->commonUtil->getCurrenciesExchangeRateArray(true);
        $products=Product::
        when(\request()->category_id != null, function ($query) {
            $query->where('category_id',\request()->category_id);
        })
            ->when(\request()->unit_id != null, function ($query) {
                $query->where('unit_id',\request()->unit_id);
            })
            ->when(\request()->store_id != null, function ($query) {
                $query->where('store_id',\request()->store_id);
            })
            ->when(\request()->brand_id != null, function ($query) {
                $query->where('brand_id',\request()->brand_id);
            })
            ->when(\request()->created_by != null, function ($query) {
                $query->where('created_by',\request()->created_by);
            })
            ->latest()->get();
        $units=Unit::orderBy('created_at', 'desc')->pluck('name','id');
        $categories=Category::orderBy('created_at', 'desc')->pluck('name','id');
        $brands=Brand::orderBy('created_at', 'desc')->pluck('name','id');
        $stores  = Store::getDropdown();
        $users = User::Notview()->pluck('name', 'id');

        return view('add_stock.create')->with(compact(
            'is_raw_material',
            'status_array',
            'payment_status_array',
            'payment_type_array',
            'stores',
            'variation_id',
            'product_id',
//            'po_nos',
            'payment_types',
            'payment_status_array',
            'categories',
            'sub_categories',
            'brands',
            'units',
            'colors',
            'sizes',
            'products',
//            'exchange_rate_currencies',
            'users',
        ));
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

    public function addProductRow(Request $request)
    {
        dd($request);

        if ($request->ajax()) {
            $currency_id = $request->currency_id;
            $currency = Currency::find($currency_id);
            $exchange_rate = $this->commonUtil->getExchangeRateByCurrency($currency_id, $request->store_id);

            $product_id = $request->input('product_id');
            $variation_id = $request->input('variation_id');
            $store_id = $request->input('store_id');
            $qty = $request->qty?$request->qty:0;
            $is_batch = $request->is_batch;
            if (!empty($product_id)) {
                $index = $request->input('row_count');
                $products = $this->productUtil->getDetailsFromProduct($product_id, $variation_id, $store_id);

                return view('add_stock.partials.product_row')
                    ->with(compact('products', 'index', 'currency', 'exchange_rate','qty','is_batch'));
            }
        }
    }
}
