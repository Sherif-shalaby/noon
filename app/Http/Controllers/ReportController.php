<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\TransactionSellLine;
use App\Models\Unit;
use App\Models\User;
use App\Utils\ReportsFilters;
use App\Utils\Util;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    protected $reportsFilters;
    protected $common_util;

    public function __construct(ReportsFilters $reportsFilters, Util $util)
    {
        $this->reportsFilters = $reportsFilters;
        $this->common_util = $util;
    }
    public function getProductReport(){
        $products = $this->reportsFilters->productFilters();
        $units = Unit::orderBy('created_at', 'desc')->pluck('name','id');
        $categories = Category::whereNull('parent_id')->orderBy('created_at', 'desc')->pluck('name','id');
        $subcategories = Category::whereNotNull('parent_id')->orderBy('created_at', 'desc')->pluck('name','id');
        $brands = Brand::orderBy('created_at', 'desc')->pluck('name','id');
        $stores = Store::orderBy('created_at', 'desc')->pluck('name','id');
        $users = User::orderBy('created_at', 'desc')->pluck('name','id');
        $suppliers = Supplier::orderBy('created_at', 'desc')->pluck('name','id');
        $branches = Branch::where('type','branch')->orderBy('created_at', 'desc')->pluck('name','id');

        return view('reports.products.index',compact('products','categories','suppliers','brands',
            'units','stores','users','subcategories','branches'));

    }
    public function sell_price_less_purchase_price($pid){
        $sell_lines = TransactionSellLine::whereHas('transaction_sell_lines', function ($query) use ($pid) {
            $query->where('product_id', $pid)
                ->where(function ($subquery) {
                    $subquery->whereNotNull('stock_sell_price')
                        ->orWhereNotNull('stock_dollar_sell_price')
                        ->where(function ($qq) {
                            $qq->where('sell_price', '<', 'stock_sell_price')
                                ->orWhere('dollar_sell_price', '<', 'stock_dollar_sell_price');
                        });
                });
        })->get();
        return view('reports.products.sell_prise_less_purchase_prise',compact('sell_lines'));
    }

    public function initialBalanceReport(){
        $suppliers = Supplier::orderBy('created_at', 'desc')->pluck('name','id');
        $brands = Brand::orderBy('created_at', 'desc')->pluck('name','id');
        $users = User::orderBy('created_at', 'desc')->pluck('name','id');
        $categories = Category::whereNull('parent_id')->orderBy('created_at', 'desc')->pluck('name','id');
        $subcategories = Category::whereNotNull('parent_id')->orderBy('created_at', 'desc')->pluck('name','id');
        $stocks  = $this->reportsFilters->initialBalanceFilters();
        return view('reports.initial_balance.index',compact('suppliers','brands','users',
            'stocks','categories','subcategories'));
    }
    public function addStock(){
        $suppliers = Supplier::orderBy('created_at', 'desc')->pluck('name','id');
        $brands = Brand::orderBy('created_at', 'desc')->pluck('name','id');
        $users = User::orderBy('created_at', 'desc')->pluck('name','id');
        $categories = Category::whereNull('parent_id')->orderBy('created_at', 'desc')->pluck('name','id');
        $subcategories = Category::whereNotNull('parent_id')->orderBy('created_at', 'desc')->pluck('name','id');
        $payment_status_array = $this->common_util->getPaymentStatusArray();
        $stocks  = $this->reportsFilters->addStockFilter();
        return view('reports.add_stock.index',compact('suppliers','brands','users',
            'stocks','categories','subcategories','payment_status_array'));
    }
}
