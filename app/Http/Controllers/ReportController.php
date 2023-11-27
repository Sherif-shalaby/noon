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

    public function __construct(ReportsFilters $reportsFilters)
    {
        request()->reportsFilters = $reportsFilters;
    }
    public function getProductReport(){
        $products = request()->reportsFilters->productFilters();
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
        $stocks =  StockTransaction::whereIn('type',['initial_balance_payment','initial_balance'])
            ->when(\request()->dont_show_zero_stocks =="on", function ($query) {
                $query->whereHas('product_stores', function ($query) {
                    $query->where('quantity_available', '>', 0);
                });
            })
            ->when(request()->supplier_id != null, function ($query) {
                $query->where('supplier_id',request()->supplier_id);
            })
            ->when(request()->created_by != null, function ($query) {
                $query->where('created_by',request()->created_by);
            })
            ->when(request()->product_name != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('name', 'like', '%' . request()->product_name . '%');
                });
            })
            ->when(request()->product_sku != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('sku', 'like', '%' . request()->product_sku . '%');
                });
            })
            ->when(request()->product_symbol != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('product_symbol', 'like', '%' . request()->product_symbol . '%');
                });
            })
            ->when(request()->brand_id != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('brand_id', request()->brand_id);
                });
            })
            ->when(request()->from != null, function ($query) {
                $query->whereRaw("STR_TO_DATE(transaction_date, '%Y-%m-%d') >= ?", [request()->from]);
            })
            ->when(request()->to != null, function ($query) {
                $query->whereRaw("STR_TO_DATE(transaction_date, '%Y-%m-%d') <= ?", [request()->to]);
            })
            ->orderBy('created_at', 'desc')->get();
        return view('reports.initial_balance.index',compact('suppliers','brands','users','stocks'));
    }
}
