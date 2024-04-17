<?php

namespace App\Http\Controllers;

use App\Utils\Util;
use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\StockTransaction;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

class ReturnStockController extends Controller
{
    protected $commonUtil;

    public function __construct(Util $commonUtil)
    {
        $this->commonUtil = $commonUtil;

    }
    /* ++++++++++++++++++++ index() ++++++++++++++++++++ */
    public function index()
    {
        $suppliers = Supplier::orderBy('created_at', 'desc')->pluck('name','id');
        $users = User::orderBy('created_at', 'desc')->pluck('name','id');
        // brands filters
        $brands = Brand::pluck('name','id');
        $payment_status_array = $this->commonUtil->getPaymentStatusArray();
        $payment_type_array = $this->commonUtil->getPaymentTypeArray();
        // sub_categories filters
        $categories     = Category::orderBy('name', 'asc')->where('parent_id',1)->pluck('name', 'id')->toArray();
        $subcategories1 = Category::orderBy('name', 'asc')->where('parent_id',2)->pluck('name', 'id')->toArray();
        $subcategories2 = Category::orderBy('name', 'asc')->where('parent_id',3)->pluck('name', 'id')->toArray();
        $subcategories3 = Category::orderBy('name', 'asc')->where('parent_id',4)->pluck('name', 'id')->toArray();

        $stocks =  StockTransaction::
            // suppliers filter
            when(request()->supplier_id != null, function ($query) {
                $query->where('supplier_id',\request()->supplier_id);
            })
            // brands filter
            ->when(request()->brand_id != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('id', \request()->brand_id);
                });
            })
            // product_name filter
            ->when(request()->product_name != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('name', 'like', '%' . \request()->product_name . '%');
                });
            })
            // product_symbol filter
            ->when(request()->product_symbol != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('product_symbol', 'like', '%' . \request()->product_symbol . '%');
                });
            })
            // categories filter
            ->when(request()->category_id, function ($query, $category_id) {
                $query->whereHas('add_stock_lines.product.category', function ($query) use ($category_id) {
                    $query->where('category_id', $category_id);
                });
            })
            // subcategories1 filter
            ->when(request()->subcategory_id1, function ($query, $subcategory_id1) {
                $query->whereHas('add_stock_lines.product.subCategory1', function ($query) use ($subcategory_id1) {
                    $query->where('subcategory_id1', $subcategory_id1);
                });
            })
            // subcategories2 filter
            ->when(request()->subcategory_id2, function ($query, $subcategory_id2) {
                $query->whereHas('add_stock_lines.product.subCategory2', function ($query) use ($subcategory_id2) {
                    $query->where('subcategory_id2', $subcategory_id2);
                });
            })
            // subcategories3 filter
            ->when(request()->subcategory_id3, function ($query, $subcategory_id3) {
                $query->whereHas('add_stock_lines.product.subCategory3', function ($query) use ($subcategory_id3) {
                    $query->where('subcategory_id3', $subcategory_id3);
                });
            })
            ->orderBy('created_at', 'desc')->get();

        return  view('suppliers.returns.invoice',
                compact('brands', 'suppliers','users',
            'payment_status_array','stocks','payment_type_array',
            'categories','subcategories1','subcategories2',
                      'subcategories3'));
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
        dd($id);
    }
    // ++++++++++++++++++ return_invoice() ++++++++++++++++++
    public function return_invoice($id)
    {
        return view('suppliers.returns.return_invoice',compact('id'));
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
