<?php

namespace App\Http\Controllers;

use App\Models\StockTransaction;
use App\Models\Store;
use App\Models\TransactionSellLine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Utils\TransactionUtil;
class ReportController extends Controller
{
     /**
     * All Utils instance.
     *
     */
    protected $transactionUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct( TransactionUtil $transactionUtil)
    {
        $this->transactionUtil = $transactionUtil;
    }
    public function getMonthlySaleReport(Request $request)
    {
        // return $request->year;
        $store_id = $this->transactionUtil->getFilterOptionValues($request)['store_id'];

        $year = request()->year;

        if (empty($year)) {
            $year = Carbon::now()->year;
        }

        $start = strtotime($year . '-01-01');
        $end = strtotime($year . '-12-31');

        while ($start <= $end) {
            $start_date =  date("Y-m-d", $start);
            if(in_array(date('m', $start), [4, 6, 9, 11])){
                $end_date = $year . '-' . date('m', $start) . '-' . '30';
            } elseif (date('m', $start) == 2) {
                $end_date = $year . '-' . date('m', $start) . '-' . '29';
            } else {
                $end_date = $year . '-' . date('m', $start) . '-' . '31';
            }
            $total_sell_query = TransactionSellLine::where('type', 'sell')->where('status', 'final')->whereDate('transaction_date', '>=', $start_date)->whereDate('transaction_date', '<=', $end_date);
            if (!empty($store_id)) {
                $total_sell_query->where('store_id', $store_id);
            }
            $total_discount_sell[] = $total_sell_query->sum('discount_amount');
            //
            $total_addstock_query = StockTransaction::where('type', 'add_stock')->where('status', 'received')->whereDate('transaction_date', '>=', $start_date)->whereDate('transaction_date', '<=', $end_date)
            ->with('add_stock_lines');

            if (!empty($store_id)) {
                $total_addstock_query->where('store_id', $store_id);
            }
            $total_discount_addstock[] = $total_addstock_query->sum('discount_amount');
        
            $total_tax_sell[] = $total_sell_query->sum('total_tax');
            ///

            // $total_tax_addstock[] = $total_addstock_query->sum('total_tax');
            //
            $shipping_cost_sell[] = $total_sell_query->sum('delivery_cost');
            //
            // $shipping_cost_addstock[] = $total_addstock_query->sum('delivery_cost');
            ///

            $total_sell[] = $total_sell_query->sum('final_total');

            //
            $total_addstock[] = $total_addstock_query->sum('final_total');
            $term=$total_sell_query->with('transaction_sell_lines');
                $total_net_profit[] = $term->get()
                ->sum(function ($transaction) {
                    return $transaction->transaction_sell_lines->sum(function ($line) {
                        return $line->sell_price * ($line->quantity - $line->quantity_returned);
                    });
                })- ($term->get()
                ->sum(function ($transaction) {
                    return $transaction->transaction_sell_lines->sum(function ($line) {
                        return $line->purchase_price * ($line->quantity - $line->quantity_returned);
                    });
                }));
            $start = strtotime("+1 month", $start);
        }
        $stores = Store::getDropdown();
        ///////

        return view('reports.sales-report.monthly_sale_report', compact(
            'year',
            'total_discount_sell',
            'total_tax_sell',
            'shipping_cost_sell',
            'total_sell',
            'stores',
            'total_discount_addstock',
            // 'total_tax_addstock',
            // 'shipping_cost_addstock',
            'total_addstock',
            'total_net_profit',
            // 'total_p'
        ));
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
}