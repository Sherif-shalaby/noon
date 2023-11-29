<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Employee;
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

    public function bestSellerReport(){
        $suppliers = Supplier::orderBy('created_at', 'desc')->pluck('name','id');
        $brands = Brand::orderBy('created_at', 'desc')->pluck('name','id');
        $categories = Category::whereNull('parent_id')->orderBy('created_at', 'desc')->pluck('name','id');
        $subcategories = Category::whereNotNull('parent_id')->orderBy('created_at', 'desc')->pluck('name','id');
        $branches = Branch::where('type','branch')->orderBy('created_at', 'desc')->pluck('name','id');
        $stores = Store::orderBy('created_at', 'desc')->pluck('name','id');
        $best_selling = $this->reportsFilters->bestSellerFilter();

        $product = [];
        $sold_qty = [];
        if (!empty($best_selling)) {
            $product_data = Product::find($best_selling->product_id);
            if (!empty($product_data)) {
                $product[] = $product_data->name . ': ' . $product_data->sku;
                $sold_qty[] = $best_selling->sold_qty;
            }
        }
        return view('reports.best_seller.index',compact('product','sold_qty','subcategories','categories',
            'suppliers','brands','branches','stores'));
    }
    public function  dailySalesReport(){
        $year = request()->year;
        $month = request()->month;

        if (empty($year)) {
            $year = Carbon::now()->year;
        }
        if (empty($month)) {
            $month = Carbon::now()->month;
        }
        $start = 1;
        $number_of_day = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        while ($start <= $number_of_day) {
            if ($start < 10) {
                $date = $year . '-' . $month . '-0' . $start;
            } else {
                $date = $year . '-' . $month . '-' . $start;
            }
            $query = TransactionSellLine::where('type', 'sell')->whereIn('status', ['final', 'canceled'])
                ->whereDate('transaction_date', $date);

            $sale_data = $query->select(
                DB::raw('SUM(discount_amount) AS total_discount'),
                DB::raw('SUM(total_product_discount) AS total_product_discount'),
                DB::raw('SUM(total_tax) AS total_tax'),
                DB::raw('SUM(delivery_cost) AS shipping_cost'),
                DB::raw('SUM(final_total) AS grand_total'),
                DB::raw('SUM(total_product_surplus) AS total_surplus'),
            )->first();
            $total_discount[$start] = $sale_data->total_discount + $sale_data->total_product_discount;
            $total_surplus[$start] = $sale_data->total_surplus;
            $order_discount[$start] = $sale_data->order_discount;
            $total_tax[$start] = $sale_data->total_tax;
            $order_tax[$start] = $sale_data->order_tax;
            $shipping_cost[$start] = $sale_data->shipping_cost;
            $grand_total[$start] = $sale_data->grand_total;
            $start++;
        }
        $start_day = date('w', strtotime($year . '-' . $month . '-01')) + 1;
        $prev_year = date('Y', strtotime('-1 month', strtotime($year . '-' . $month . '-01')));
        $prev_month = date('m', strtotime('-1 month', strtotime($year . '-' . $month . '-01')));
        $next_year = date('Y', strtotime('+1 month', strtotime($year . '-' . $month . '-01')));
        $next_month = date('m', strtotime('+1 month', strtotime($year . '-' . $month . '-01')));

        $stores = Store::getDropdown();
        $payment_types = $this->common_util->getPaymentTypeArrayForPos();
        $cashiers = Employee::getDropdownByJobType('Cashier', true, true);

        return view('reports.daily_sell_report.index',compact(
            'total_discount',
            'total_surplus',
            'order_discount',
            'total_tax',
            'order_tax',
            'shipping_cost',
            'grand_total',
            'start_day',
            'year',
            'month',
            'number_of_day',
            'prev_year',
            'prev_month',
            'next_year',
            'next_month',
            'stores',
            'payment_types',
            'cashiers',
        ));
    }
}
