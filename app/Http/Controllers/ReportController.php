<?php

namespace App\Http\Controllers;

use App\Models\AddStockLine;
use App\Models\ProductStore;
use App\Models\SellLine;
use App\Models\StockTransaction;
use App\Models\Store;
use App\Models\TransactionSellLine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Utils\TransactionUtil;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\User;
use App\Models\Variation;
use App\Utils\ReportsFilters;
use App\Utils\Util;
use Illuminate\Support\Facades\DB;
class ReportController extends Controller
{
     /**
     * All Utils instance.
     *
     */
    protected $reportsFilters;
    protected $common_util;

    protected $transactionUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct( TransactionUtil $transactionUtil,ReportsFilters $reportsFilters, Util $util)
    {
        $this->reportsFilters = $reportsFilters;
        $this->common_util = $util;
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
    }

    public function getProductReport(){
        $products = $this->reportsFilters->productFilters();
        $units = Unit::orderBy('created_at', 'desc')->pluck('name','id');
        $categories = Category::whereNull('parent_id')->orderBy('created_at', 'desc')->pluck('name','id');
        $subcategories = Category::whereNotNull('parent_id')->orderBy('created_at', 'desc')->pluck('name','id');
        $brands = Brand::orderBy('created_at', 'desc')->pluck('name','id');
        $users = User::orderBy('created_at', 'desc')->pluck('name','id');
        $suppliers = Supplier::orderBy('created_at', 'desc')->pluck('name','id');
        $stores = Store::orderBy('created_at', 'desc')->pluck('name','id');
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

    public function viewProductDetails($id){

        $product = Product::find($id);
        $stock_details = ProductStore::where('product_id', $id)->get();
        $sales = SellLine::with('transaction')->where('product_id', $id)->get();
        $add_stocks = AddStockLine::with('transaction')
            ->where('product_id', $id)
            ->whereHas('transaction', function ($query) {
                $query->where('type', 'add_stock');
            })->get();

        return view('reports.products.partials.view_product_details',compact('product','stock_details',
            'sales','add_stocks'));
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
        $categories = Category::where('parent_id',1)->orderBy('created_at', 'desc')->pluck('name','id');
        $subcategories1 = Category::where('parent_id',2)->orderBy('created_at', 'desc')->pluck('name','id');
        $subcategories2 = Category::where('parent_id',3)->orderBy('created_at', 'desc')->pluck('name','id');
        $subcategories3 = Category::where('parent_id',4)->orderBy('created_at', 'desc')->pluck('name','id');
        $payment_status_array = $this->common_util->getPaymentStatusArray();
        $stocks  = $this->reportsFilters->addStockFilter();
        return view('reports.add_stock.index',compact('suppliers','brands','users',
            'stocks','categories','subcategories1','subcategories2','subcategories3','payment_status_array'));
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
    public function getStoreStockChart(Request $request)
    {
        $store_id = $this->transactionUtil->getFilterOptionValues($request)['store_id'];

        $item_query = ProductStore::where('quantity_available', '>', 0);
        if (!empty($store_id)) {
            $item_query->where('store_id', $store_id);
        }
        $total_item = $item_query->count();



        $qty_query = ProductStore::where('quantity_available', '>', 0);
        if (!empty($store_id)) {
            $qty_query->where('store_id', $store_id);
        }
        $total_qty = $qty_query->sum('quantity_available');


        $price_query = Variation::leftjoin('product_stores', 'variations.id', 'product_stores.variation_id');
        if (!empty($store_id)) {
            $price_query->where('store_id', $store_id);
        }
        $total_price =  $price_query->select(DB::raw('SUM(quantity_available * 1) as total_price'))->first()->total_price;



        $cost_query = Variation::leftjoin('product_stores', 'variations.id', 'product_stores.variation_id');
        if (!empty($store_id)) {
            $cost_query->where('store_id', $store_id);
        }
        $total_cost =  $cost_query->select(DB::raw('SUM(quantity_available * 1) as total_cost'))->first()->total_cost;
        $stores = Store::getDropdown();


        return view('reports.sales-report.store_stock_chart', compact(
            'total_item',
            'total_qty',
            'total_price',
            'total_cost',
            'stores',
        ));
    }

    public function  dailySalesReport(){
        $stores = Store::orderBy('created_at', 'desc')->pluck('name','id');
        $branches = Branch::where('type','branch')->orderBy('created_at', 'desc')->pluck('name','id');
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
                ->whereDate('transaction_date', $date)
                ->when(\request()->branch_id != null, function ($query) {
                    $branchId = \request()->branch_id;
                    $query->whereHas('transaction_sell_lines.product.product_stores.store.branch', function ($storeQuery) use ($branchId) {
                        $storeQuery->where('id', $branchId);
                    });
                })
                ->when(\request()->store_id != null, function ($query) {
                    $query->whereHas('transaction_sell_lines.product.product_stores', function ($query) {
                        $query->where('store_id',\request()->store_id);
                    });
                });

            $sale_data = $query->select(
                DB::raw('SUM(discount_amount) AS total_discount'),
                DB::raw('SUM(total_product_discount) AS total_product_discount'),
                DB::raw('SUM(total_tax) AS total_tax'),
                DB::raw('SUM(delivery_cost) AS shipping_cost'),
                DB::raw('SUM(final_total) AS grand_total'),
                DB::raw('SUM(dollar_final_total) AS dollar_grand_total'),
                DB::raw('SUM(total_product_surplus) AS total_surplus'),
            )->first();
            $total_discount[$start] = $sale_data->total_discount + $sale_data->total_product_discount;
            $total_surplus[$start] = $sale_data->total_surplus;
            $order_discount[$start] = $sale_data->order_discount;
            $total_tax[$start] = $sale_data->total_tax;
            $order_tax[$start] = $sale_data->order_tax;
            $shipping_cost[$start] = $sale_data->shipping_cost;
            $grand_total[$start] = $sale_data->grand_total;
            $dollar_grand_total[$start] = $sale_data->dollar_grand_total;
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
            'total_discount', 'total_surplus', 'order_discount', 'total_tax',
            'order_tax', 'shipping_cost', 'grand_total', 'dollar_grand_total', 'start_day', 'year',
            'month', 'number_of_day', 'prev_year', 'prev_month', 'next_year', 'next_month', 'stores',
            'payment_types', 'cashiers', 'stores', 'branches'
        ));
    }

    public function dailyPurchaseReport(){
        $branches = Branch::where('type','branch')->orderBy('created_at', 'desc')->pluck('name','id');
        $stores = Store::orderBy('created_at', 'desc')->pluck('name','id');
        $suppliers = Supplier::orderBy('created_at', 'desc')->pluck('name','id');


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
            if ($start < 10)
                $date = $year . '-' . $month . '-0' . $start;
            else
                $date = $year . '-' . $month . '-' . $start;
            $query1 = array(
                'SUM(discount_amount) AS total_discount',
//                'SUM(delivery_cost) AS shipping_cost',
                'SUM(final_total) AS grand_total',
                'SUM(dollar_final_total) AS dollar_grand_total'
            );
            $query = StockTransaction::where('type', 'add_stock')->where('status', 'received')->whereDate('transaction_date', $date)
                ->when(\request()->branch_id != null, function ($query) {
                    $branchId = \request()->branch_id;
                    $query->whereHas('add_stock_lines.product.product_stores.store.branch', function ($storeQuery) use ($branchId) {
                        $storeQuery->where('id', $branchId);
                    });
                })
                ->when(\request()->store_id != null, function ($query) {
                    $query->whereHas('add_stock_lines.product.product_stores', function ($query) {
                        $query->where('store_id',\request()->store_id);
                    });
                })
                ->when(request()->supplier_id != null, function ($query) {
                    $query->where('supplier_id',request()->supplier_id);
                });
            $purchase_data = $query->select(
                DB::raw('SUM(discount_amount) AS total_discount'),
                DB::raw('SUM(final_total) AS grand_total'),
                DB::raw('SUM(dollar_final_total) AS dollar_grand_total'),

            )->first();

            $total_discount[$start] = $purchase_data->total_discount;
            $grand_total[$start] = $purchase_data->grand_total;
            $dollar_grand_total[$start] = $purchase_data->dollar_grand_total;
            $start++;
        }
        $start_day = date('w', strtotime($year . '-' . $month . '-01')) + 1;
        $prev_year = date('Y', strtotime('-1 month', strtotime($year . '-' . $month . '-01')));
        $prev_month = date('m', strtotime('-1 month', strtotime($year . '-' . $month . '-01')));
        $next_year = date('Y', strtotime('+1 month', strtotime($year . '-' . $month . '-01')));
        $next_month = date('m', strtotime('+1 month', strtotime($year . '-' . $month . '-01')));

        $stores = Store::getDropdown();

        return view('reports.daily_purchase_report.index', compact(
            'total_discount', 'grand_total','dollar_grand_total',
            'start_day', 'year', 'month', 'number_of_day', 'prev_year', 'prev_month',
            'next_year', 'next_month', 'stores', 'branches', 'stores','suppliers'
        ));
    }

}
