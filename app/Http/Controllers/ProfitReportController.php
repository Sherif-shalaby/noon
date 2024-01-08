<?php

namespace App\Http\Controllers;

use App\Http\Livewire\Returns\Suppliers\Product;
use App\Models\CustomerType;
use App\Models\Employee;
use App\Models\ExchangeRate;
use App\Models\ExpenseTransaction;
use App\Models\Product as ModelsProduct;
use App\Models\StockTransaction;
use App\Models\Store;
use App\Models\StorePos;
use App\Models\System;
use App\Models\TransactionSellLine;
use App\Models\Wage;
use App\Utils\ProductUtil;
use App\Utils\StockTransactionUtil;
use App\Utils\TransactionUtil;
use App\Utils\Util;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfitReportController extends Controller
{
    protected $commonUtil;
    protected $productUtil;
    protected $stockTransactionUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(Util $commonUtil,ProductUtil $productUtil, StockTransactionUtil $stockTransactionUtil)
    {
        $this->commonUtil = $commonUtil;
        $this->productUtil = $productUtil;
        $this->stockTransactionUtil = $stockTransactionUtil;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dollarExchange = System::getProperty('dollar_exchange'); 
        $exchange_rate_currencies = $this->commonUtil->getExchangeRateCurrencies(true);
        $stores = Store::select('name', 'id')->get();
        $store_id = $request->get('store_id');
        $pos_id = $request->get('pos_id');

        $sale_query = TransactionSellLine::leftjoin('stores', 'transaction_sell_lines.store_id', 'stores.id')
            ->leftjoin('customers', 'transaction_sell_lines.customer_id', 'customers.id')
            ->where('transaction_sell_lines.status', 'final');

        if (!empty($request->start_date)) {
            $sale_query->whereDate('transaction_date', '>=', $request->start_date);
        }
        if (!empty($request->end_date)) {
            $sale_query->whereDate('transaction_date', '<=', $request->end_date);
        }
        if (!empty(request()->start_time)) {
            $sale_query->where('transaction_date', '>=', request()->start_date . ' ' . Carbon::parse(request()->start_time)->format('H:i:s'));
        }
        if (!empty(request()->end_time)) {
            $sale_query->where('transaction_date', '<=', request()->end_date . ' ' . Carbon::parse(request()->end_time)->format('H:i:s'));
        }
        if (!empty($request->customer_type_id)) {
            $sale_query->where('customer_type_id', $request->customer_type_id);
        }

        if (!empty($store_id)) {
            $sale_query->where('store_id', $store_id);
        }
        if (!empty($pos_id)) {
            $sale_query->where('store_pos_id', $pos_id);
        }
        if (!empty($request->product_id)) {
            $sale_query->where('product_id', $request->product_id);
        }

        $s_query = clone $sale_query;
        $sales = [];
        $sales_totals = [];
        $i = 0;
        foreach ($stores as $store) {
            $sales[$i]['store_id'] = $store->id;
            $sales[$i]['store_name'] = $store->name;
            $currency_array = [];
            foreach ($exchange_rate_currencies as $currency) {
                $s_query = clone $sale_query;
                $currency_array[$currency['currency_id']]['currency_id'] = $currency['currency_id'];
                $currency_array[$currency['currency_id']]['symbol'] = $currency['symbol'];
                $currency_array[$currency['currency_id']]['is_default'] = $currency['is_default'];
                $currency_array[$currency['currency_id']]['conversion_rate'] = $currency['conversion_rate'];
                if (!$currency['is_default']) {
                    $currency_array[$currency['currency_id']]['total'] = $s_query->where('stores.id', $store->id)->where('received_currency_id', $currency['currency_id'])->sum('final_total');
                } else {
                    $currency_array[$currency['currency_id']]['total'] = $s_query->where('stores.id', $store->id)
                        ->where(function ($q) use ($currency) {
                            $q->where('received_currency_id', $currency['currency_id'])->orWhereNull('received_currency_id');
                        })
                        ->sum('final_total');
                }
                $currency_array[$currency['currency_id']]['dollar_final_total'] = $s_query
                    ->where('stores.id', $store->id)
                    ->where('received_currency_id', $currency['currency_id'])
                    ->sum('dollar_final_total');

                // Add the dollar_final_total to sales_totals
                if (!empty($sales_totals[$currency['currency_id']])) {
                    $sales_totals[$currency['currency_id']] += $currency_array[$currency['currency_id']]['dollar_final_total'] * $dollarExchange ;
                } else {
                    $sales_totals[$currency['currency_id']] = $currency_array[$currency['currency_id']]['dollar_final_total'] * $dollarExchange;
                }
                if (!empty($sales_totals[$currency['currency_id']])) {
                    $sales_totals[$currency['currency_id']] += $currency_array[$currency['currency_id']]['total'];
                } else {
                    $sales_totals[$currency['currency_id']] = $currency_array[$currency['currency_id']]['total'];
                }
            }
            $sales[$i]['currency'] = (array) $currency_array;

            $i++;
        }

        $purchase_query = TransactionSellLine::leftjoin('sell_lines', 'transaction_sell_lines.id', 'sell_lines.transaction_id')
            ->leftjoin('products', 'sell_lines.product_id', 'products.id')
            // ->where('transaction_sell_lines.type', 'sell')
            ->where('transaction_sell_lines.status', 'final');

        if (!empty($request->start_date)) {
            $purchase_query->whereDate('transaction_date', '>=', $request->start_date);
        }
        if (!empty($request->end_date)) {
            $purchase_query->whereDate('transaction_date', '<=', $request->end_date);
        }
        if (!empty(request()->start_time)) {
            $purchase_query->where('transaction_date', '>=', request()->start_date . ' ' . Carbon::parse(request()->start_time)->format('H:i:s'));
        }
        if (!empty(request()->end_time)) {
            $purchase_query->where('transaction_date', '<=', request()->end_date . ' ' . Carbon::parse(request()->end_time)->format('H:i:s'));
        }

        if (!empty($store_id)) {
            $purchase_query->where('store_id', $store_id);
        }

        // $purchase_totals = [];
        // $currency_array = [];
        // foreach ($exchange_rate_currencies as $currency) {
        //     $p_query = clone $purchase_query;
        //     $currency_array[$currency['currency_id']]['currency_id'] = $currency['currency_id'];
        //     $currency_array[$currency['currency_id']]['symbol'] = $currency['symbol'];
        //     $currency_array[$currency['currency_id']]['is_default'] = $currency['is_default'];
        //     $currency_array[$currency['currency_id']]['conversion_rate'] = $currency['conversion_rate'];
        //     if (!$currency['is_default']) {
        //         $exchange_rate = ExchangeRate::find($currency['currency_id']);
        //         if (!empty($exchange_rate)) {
        //             $exchange_rate = $exchange_rate->conversion_rate;
        //         } else {
        //             $exchange_rate = 1;
        //         }

        //         $p_total = $p_query->where('received_currency_id', $currency['currency_id'])->select(
        //             DB::raw('SUM(products.purchase_price * transaction_sell_lines.quantity) as total_amount')
        //         )->first();
        //         $currency_array[$currency['currency_id']]['total'] = !empty($p_total->total_amount) ? $p_total->total_amount / $exchange_rate : 0;
        //     } else {
        //         $exchange_rate = 1;
        //         $p_total = $p_query
        //             ->where(function ($q) use ($currency) {
        //                 $q->where('received_currency_id', $currency['currency_id'])->orWhereNull('received_currency_id');
        //             })
        //             ->select(
        //                 DB::raw('SUM(products.purchase_price * transaction_sell_lines.quantity) as total_amount')
        //             )->first();
        //         $currency_array[$currency['currency_id']]['total'] = !empty($p_total->total_amount) ? $p_total->total_amount  / $exchange_rate : 0;
        //     }
        //     if (!empty($purchase_totals[$currency['currency_id']])) {
        //         $purchase_totals[$currency['currency_id']] += $currency_array[$currency['currency_id']]['total'];
        //     } else {
        //         $purchase_totals[$currency['currency_id']] = $currency_array[$currency['currency_id']]['total'];
        //     }
        // }
        // $purchases[$i]['currency'] = (array) $currency_array;
        $i++;


        $expense_query = ExpenseTransaction::leftjoin('expense_transaction_payments', 'expense_transactions.id', 'expense_transaction_payments.transaction_id')
            ->leftjoin('expense_categories', 'expense_transactions.expense_category_id', 'expense_categories.id')
            // ->where('transactions.type', 'expense')
            ->where('expense_transactions.status', 'final');

        if (!empty($request->start_date)) {
            $expense_query->whereDate('transaction_date', '>=', $request->start_date);
        }
        if (!empty($request->end_date)) {
            $expense_query->whereDate('transaction_date', '<=', $request->end_date);
        }
        if (!empty(request()->start_time)) {
            $expense_query->where('transaction_date', '>=', request()->start_date . ' ' . Carbon::parse(request()->start_time)->format('H:i:s'));
        }
        if (!empty(request()->end_time)) {
            $expense_query->where('transaction_date', '<=', request()->end_date . ' ' . Carbon::parse(request()->end_time)->format('H:i:s'));
        }

        if (!empty($store_id)) {
            $expense_query->where('store_id', $store_id);
        }

        $expenses = $expense_query->select(
            'expense_categories.name as expense_category_name',
            'expense_category_id',
            DB::raw('SUM(expense_transactions.final_total) as total_amount')
        )->groupBy('expense_categories.name','expense_category_id')->get();

        $wages_query = Wage::where('id', '>', 0);

        if (!empty($request->start_date)) {
            $wages_query->whereDate('payment_date', '>=', $request->start_date);
        }
        if (!empty($request->end_date)) {
            $wages_query->whereDate('payment_date', '<=', $request->end_date);
        }
        if (!empty(request()->start_time)) {
            $wages_query->where('payment_date', '>=', request()->start_date . ' ' . Carbon::parse(request()->start_time)->format('H:i:s'));
        }
        if (!empty(request()->end_time)) {
            $wages_query->where('payment_date', '<=', request()->end_date . ' ' . Carbon::parse(request()->end_time)->format('H:i:s'));
        }
        if (!empty($request->employee_id)) {
            $wages_query->where('employee_id', $request->employee_id);
        }
        if (!empty($request->payment_type)) {
            $wages_query->where('payment_type', $request->payment_type);
        }

        $wages = $wages_query->select(
            'wages.payment_type',
            DB::raw('SUM(wages.net_amount) as total_amount')
        )->groupBy('wages.payment_type')->get();

        $stores = Store::getDropdown();
        $store_pos = StorePos::orderBy('name', 'asc')->pluck('name', 'id');
        $products = ModelsProduct::orderBy('name', 'asc')->pluck('name', 'id');
        $employees = Employee::pluck('employee_name', 'id');
        $customer_types = CustomerType::getDropdown();
        $wages_payment_types = Wage::getPaymentTypes();

        // TODO:: filter for all adjustments
        return view('reports.profit_loss_report')->with(compact(
            'sales_totals',
            'sales',
            'exchange_rate_currencies',
            'wages',
            'expenses',
            // 'purchases',
            // 'purchase_totals',
            'store_pos',
            'products',
            'employees',
            'stores',
            'customer_types',
            'wages_payment_types',
        ));
    }

    public function getDashboardData($start_date, $end_date, $store_id = [], $store_pos_id = null)
    {
        $exchange_rate_currencies = $this->commonUtil->getExchangeRateCurrencies(true);

        $data = [];
        $i = 0;
        // foreach ($exchange_rate_currencies as $currency) {
            // $data[$i]['currency'] = $currency;
            $data[$i]['data'] = $this->getDashboardDetails($start_date, $end_date, $store_id, $store_pos_id);

            $i++;
        // }

        return $data;
    }

    public function getDashboardDetails($start_date, $end_date, $store_id = [], $store_pos_id = null, $currency_id = null)
    {
        $default_currency_id = System::getProperty('currency');
        $dollarExchange = System::getProperty('dollar_exchange'); 

        if (!empty($store_id)) {
            $store_id = $store_id;
        } else {
            $store_id = request()->input('store_id') ? [request()->input('store_id')] : [];
        }

        if (!Auth::user()->is_superadmin && !auth()->user()->is_admin && !strtolower(session('user.job_title'))  =="Accountant" ) {
            $store_pos_id = null;
            if (!empty(session('user.pos_id'))) {
                $store_pos_id = session('user.pos_id');
            } else {
                $store_pos_id =  -1;
            }
        }

        // $total_sale_item_tax_inclusive = $this->getTotalSaleItemTaxAmount($start_date, $end_date, $store_id, $store_pos_id);
    //     $total_sale_general_tax_inclusive = $this->getTotalSaleGeneralTaxAmount($start_date, $end_date, $store_id, $store_pos_id);


        $transaction_query = TransactionSellLine::whereIn('type', ['sell', 'sell_return'])->whereIn('status', ['final', 'received']);
        $stock_transaction_query = StockTransaction::whereIn('type', ['initial_balance', 'add_stock'])->whereIn('status', ['final', 'received']);
        $expense_transaction_query = StockTransaction::whereIn('type', ['expense']);
        if (!empty($start_date)) {
            $transaction_query->whereDate('transaction_date', '>=', $start_date);
            $stock_transaction_query->whereDate('transaction_date', '>=', $start_date);
            $expense_transaction_query->whereDate('transaction_date', '>=', $start_date);
        }
        if (!empty($end_date)) {
            $transaction_query->whereDate('transaction_date', '<=', $end_date);
            $stock_transaction_query->whereDate('transaction_date', '<=', $end_date);
            $expense_transaction_query->whereDate('transaction_date', '<=', $end_date);
        }
        if (!empty(request()->start_time)) {
            $transaction_query->where('transaction_date', '>=', request()->start_date . ' ' . Carbon::parse(request()->start_time)->format('H:i:s'));
            $stock_transaction_query->where('transaction_date', '>=', request()->start_date . ' ' . Carbon::parse(request()->start_time)->format('H:i:s'));
            $expense_transaction_query->where('transaction_date', '>=', request()->start_date . ' ' . Carbon::parse(request()->start_time)->format('H:i:s'));
        }
        if (!empty(request()->end_time)) {
            $transaction_query->where('transaction_date', '<=', request()->end_date . ' ' . Carbon::parse(request()->end_time)->format('H:i:s'));
            $expense_transaction_query->where('transaction_date', '>=', request()->start_date . ' ' . Carbon::parse(request()->start_time)->format('H:i:s'));
        }
        if (!empty($store_id)) {
            $transaction_query->whereIn('store_id', $store_id);
            $stock_transaction_query->whereIn('store_id', $store_id);
            $expense_transaction_query->whereIn('store_id', $store_id);
        }
        if (!empty($store_pos_id)) {
            $transaction_query->where('store_pos_id', $store_pos_id);
            $stock_transaction_query->where('store_pos_id', $store_pos_id);
            $expense_transaction_query->where('store_pos_id', $store_pos_id);
        }
        $transaction_query->select(
            DB::raw('SUM(IF(transaction_sell_lines.type="sell_return", final_total, 0)) as total_sell_return'),
            DB::raw('SUM(IF(transaction_sell_lines.type="sell_return", dollar_final_total, 0)) as dollar_total_sell_return'),
            // DB::raw('SUM(IF(transaction_sell_lines.type="sell_return", gift_card_amount, 0)) as total_gift_card_amount'),
            // DB::raw('SUM(IF(transactions.type="purchase_return", final_total, 0)) as total_purchase_return'),
        
            DB::raw('SUM(IF(transaction_sell_lines.type="sell", final_total, 0)) as total_sell'),
            DB::raw('SUM(IF(transaction_sell_lines.type="sell", dollar_final_total, 0)) as dollar_total_sell'),
            // DB::raw('SUM(IF(transaction_sell_lines.type="sell" AND transaction_sell_lines.delivery_cost_given_to_deliveryman="1", delivery_cost, 0)) as total_delivery_cost_given_to_deliveryman'),
        );
        $expense_transaction_query->select(
            DB::raw('SUM(final_total) as total_expense'),
        );
        $stock_transaction_query->select(
            DB::raw('SUM(final_total) as total_purchases'),
            DB::raw('SUM(dollar_final_total) as dollar_total_purchases'),
        );
        
        $transaction_query = $transaction_query->first();
        $stock_transaction_query = $stock_transaction_query->first();
        $expense_transaction_query = $expense_transaction_query->first();

        // $gift_card_returned = $transaction_query->total_gift_card_amount ?? 0;


        $revenue = $transaction_query->total_sell ?? 0;
        $dollar_revenue = $transaction_query->dollar_total_sell ?? 0;
        // $total_delivery_cost_given_to_deliveryman = $transaction_query->total_delivery_cost_given_to_deliveryman ?? 0;
        // $revenue = $revenue - $total_delivery_cost_given_to_deliveryman;

        $sell_return  = $transaction_query->total_sell_return; // for gift card return no change in sell return
        $dollar_sell_return = $transaction_query->dollar_total_sell_return;
        // $purchase_return = $transaction_query->total_purchase_return ?? 0;

        $purchase = $stock_transaction_query->total_purchases ?? 0;
        $dollar_purchase = $stock_transaction_query->dollar_total_purchases;
        $purchase =  $purchase + ( $dollar_purchase * $dollarExchange);
        $total_tax = TransactionSellLine::where('type','sell')->sum('total_tax'); // total tax

        $revenue -= $sell_return;
        $dollar_revenue -= $dollar_sell_return ;
        $revenue = $revenue  + ( $dollar_revenue * $dollarExchange);
        $cost_query = TransactionSellLine::leftjoin('sell_lines', 'transaction_sell_lines.id', 'sell_lines.transaction_id')
            ->where('transaction_sell_lines.type', 'sell')
            ->where('transaction_sell_lines.status', 'final');

        if (!empty($start_date)) {
            $cost_query->whereDate('transaction_date', '>=', $start_date);
        }
        if (!empty($end_date)) {
            $cost_query->whereDate('transaction_date',  '<=', $end_date);
        }
        if (!empty(request()->start_time)) {
            $cost_query->where('transaction_date', '>=', request()->start_date . ' ' . Carbon::parse(request()->start_time)->format('H:i:s'));
        }
        if (!empty(request()->end_time)) {
            $cost_query->where('transaction_date', '<=', request()->end_date . ' ' . Carbon::parse(request()->end_time)->format('H:i:s'));
        }
        if (!empty($store_id)) {
            $cost_query->whereIn('store_id', $store_id);
        }
        if (!empty($store_pos_id)) {
            $cost_query->where('store_pos_id', $store_pos_id);
        }

        // if (!empty($currency_id)) {
        //     if ($currency_id == $default_currency_id) {
        //         $cost_query->where(function ($q) use ($currency_id) {
        //             $q->where('received_currency_id', $currency_id)
        //                 ->orWhereNull('received_currency_id');
        //         });
        //     } else {
        //         $cost_query->where(function ($q) use ($currency_id) {
        //             $q->where('received_currency_id', $currency_id);
        //         });
        //     }
        // }

        $cost_query = $cost_query->select(
            DB::raw("SUM(sell_lines.quantity * sell_lines.purchase_price) as cost_of_sold_products"),
            DB::raw("SUM(sell_lines.quantity_returned * sell_lines.purchase_price) as cost_of_sold_returned_products"),
            // DB::raw("SUM(sell_lines.quantity * sell_lines.cost_ratio_per_one) as other_stock_cost")
        )->first();

        $cost_sold_product = $cost_query->cost_of_sold_products ?? 0;
        $cost_sold_returned_product = $cost_query->cost_of_sold_returned_products ?? 0;
        // $other_stock_cost = $cost_query->other_stock_cost ?? 0;

        // if (!empty($currency_id)) {
        //     if ($currency_id == $default_currency_id) {
        //         $gift_card_sold = GiftCard::whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->sum('balance');
        //     } else {
        //         $gift_card_sold = 0;
        //     }
        // } else {
        //     $gift_card_sold = GiftCard::whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->sum('balance');
        // }
        $profit = $revenue - $cost_sold_product + $cost_sold_returned_product ;
        // $dollar_profit =  $dollar_revenue - ($cost_sold_product/$dollarExchange ) + ($cost_sold_returned_product / $dollarExchange ) ;
        //excluding taxes from profit as its not part of profit
        $expense_query = ExpenseTransaction::where('status', 'final');
        if (!empty($start_date)) {
            $expense_query->whereDate('transaction_date', '>=', $start_date);
        }
        if (!empty($end_date)) {
            $expense_query->whereDate('transaction_date', '<=', $end_date);
        }
        if (!empty(request()->start_time)) {
            $expense_query->where('transaction_date', '>=', request()->start_date . ' ' . Carbon::parse(request()->start_time)->format('H:i:s'));
        }
        if (!empty(request()->end_time)) {
            $expense_query->where('transaction_date', '<=', request()->end_date . ' ' . Carbon::parse(request()->end_time)->format('H:i:s'));
        }
        if (!empty($store_id)) {
            $expense_query->whereIn('store_id', $store_id);
        }
        if (!empty($store_pos_id)) {
            $expense_query->where('store_pos_id', $store_pos_id);
        }
        if (!empty($currency_id)) {
            if ($currency_id == $default_currency_id) {
                $expense = $expense_query->sum('final_total');
            } else {
                $expense = 0; //expense does not have currency
            }
        } else {
            $expense = $expense_query->sum('final_total');
        }

        //payment sent queries

        $payment_query = TransactionSellLine::
        leftjoin('payment_transaction_sell_lines', 'transaction_sell_lines.id', 'payment_transaction_sell_lines.transaction_id')
            ->whereIn('type', ['sell', 'purchase_return', 'add_stock', 'expense', 'sell_return'])
            ->where('status', 'final');

        $stock_payment_query = StockTransaction::
        leftjoin('stock_transaction_payments', 'stock_transactions.id', 'stock_transaction_payments.stock_transaction_id')
            // ->whereIn('type', ['sell', 'purchase_return', 'add_stock', 'expense', 'sell_return'])
            ->where('status', 'final');
        
        $expense_payment_query = ExpenseTransaction::
        leftjoin('expense_transaction_payments', 'expense_transactions.id', 'expense_transaction_payments.transaction_id')
            // ->whereIn('type', ['sell', 'purchase_return', 'add_stock', 'expense', 'sell_return'])
        ->where('status', 'final');
        if (!empty($start_date)) {
            $payment_query->whereDate('paid_on', '>=', $start_date);
            $stock_payment_query->whereDate('paid_on', '>=', $start_date);
            $expense_payment_query->whereDate('paid_on', '>=', $start_date);
        }
        if (!empty($end_date)) {
            $payment_query->whereDate('paid_on', '<=', $end_date);
            $stock_payment_query->whereDate('paid_on', '<=', $end_date);
            $expense_payment_query->whereDate('paid_on', '<=', $end_date);
        }
        if (!empty(request()->start_time)) {
            $payment_query->where('paid_on', '>=', request()->start_date . ' ' . Carbon::parse(request()->start_time)->format('H:i:s'));
            $stock_payment_query->where('paid_on', '>=', request()->start_date . ' ' . Carbon::parse(request()->start_time)->format('H:i:s'));
            $expense_payment_query->where('paid_on', '>=', request()->start_date . ' ' . Carbon::parse(request()->start_time)->format('H:i:s'));
        }
        if (!empty(request()->end_time)) {
            $payment_query->where('paid_on', '<=', request()->end_date . ' ' . Carbon::parse(request()->end_time)->format('H:i:s'));
            $stock_payment_query->where('paid_on', '<=', request()->end_date . ' ' . Carbon::parse(request()->end_time)->format('H:i:s'));
            $expense_payment_query->where('paid_on', '<=', request()->end_date . ' ' . Carbon::parse(request()->end_time)->format('H:i:s'));
        }
        if (!empty($store_id)) {
            $payment_query->whereIn('store_id', $store_id);
            $stock_payment_query->whereIn('store_id', $store_id);
            $expense_payment_query->whereIn('store_id', $store_id);
        }
        if (!empty($store_pos_id)) {
            $payment_query->where('store_pos_id', $store_pos_id);
            $stock_payment_query->where('store_pos_id', $store_pos_id);
            $expense_payment_query->where('store_pos_id', $store_pos_id);
        }
        // if (!empty($currency_id)) {
        //     if ($currency_id == $default_currency_id) {
        //         $payment_query->where(function ($q) use ($currency_id) {
        //             $q->where('received_currency_id', $currency_id)
        //                 ->orWhereNull('received_currency_id');
        //         });
        //     } else {
        //         $payment_query->where(function ($q) use ($currency_id) {
        //             $q->where('received_currency_id', $currency_id);
        //         });
        //     }
        // }

        $payment_query->select(
            DB::raw('SUM(IF(transaction_sell_lines.type="sell", payment_transaction_sell_lines.amount, 0)) as total_sell_paid'),
            DB::raw('SUM(IF(transaction_sell_lines.type="sell", payment_transaction_sell_lines.dollar_amount, 0)) as dollar_total_sell_paid'),
            DB::raw('SUM(IF(transaction_sell_lines.type="sell_return", payment_transaction_sell_lines.amount, 0)) as total_sell_return_paid'),
            DB::raw('SUM(IF(transaction_sell_lines.type="sell_return", payment_transaction_sell_lines.dollar_amount, 0)) as dollar_total_sell_return_paid'),
            // DB::raw('SUM(IF(transactions.type="purchase_return", transaction_payments.amount, 0)) as total_purchase_return_paid'),
        );

        $stock_payment_query->select(
            DB::raw('SUM(IF(stock_transactions.type="add_stock", stock_transaction_payments.amount, 0)) as total_add_stock_paid'),
            // DB::raw('SUM(IF(stock_transactions.type="add_stock", stock_transaction_payments.dollar_amount, 0)) as dollar_total_add_stock_paid'),
        );
        $expense_payment_query->select(
            DB::raw('SUM(expense_transaction_payments.amount) as total_expense_paid')

        );

        $payment_query = $payment_query->first();
        $stock_payment_query = $stock_payment_query->first();
        $expense_payment_query = $expense_payment_query->first();

        $payment_received = $payment_query->total_sell_paid ?? 0;
        $dollar_payment_received = $payment_query->dollar_total_sell_paid ?? 0;
        // $payment_purchase_return = $payment_query->total_purchase_return_paid ?? 0;
        $payment_received_total = $payment_received + ($dollar_payment_received * $dollarExchange);

        $payment_purchase = $stock_payment_query->total_add_stock_paid ?? 0;
        // $dollar_payment_purchase = $stock_payment_query->total_add_stock_paid ?? 0;
        // $payment_purchase = $payment_purchase + ( $dollar_payment_purchase  * $dollarExchange);
        $payment_expense = $expense_payment_query->total_expense_paid ?? 0;

        $sell_return_payment = $payment_query->total_sell_return_paid ?? 0;
        $dollar_sell_return_payment = $payment_query->dollar_total_sell_return_paid ?? 0;
        $sell_return_payment  = $sell_return_payment +( $dollar_sell_return_payment *  $dollar_sell_return_payment);
        $wages_query = Wage::where('id', '>', 0);
        if (!empty($start_date)) {
            $wages_query->where('payment_date', '>=', $start_date);
        }
        if (!empty($end_date)) {
            $wages_query->where('payment_date', '<=', $end_date);
        }
        if (!empty(request()->start_time)) {
            $wages_query->where('payment_date', '>=', request()->start_date . ' ' . Carbon::parse(request()->start_time)->format('H:i:s'));
        }
        if (!empty(request()->end_time)) {
            $wages_query->where('payment_date', '<=', request()->end_date . ' ' . Carbon::parse(request()->end_time)->format('H:i:s'));
        }
        // if (!empty($currency_id)) {
        //     if ($currency_id == $default_currency_id) {
        //         $wages_payment = $wages_query->sum('net_amount');
        //     } else {
        //         $wages_payment = 0; //expense does not have currency
        //     }
        // } else {
            $wages_payment = $wages_query->sum('net_amount');
        // }

        $payment_sent = $payment_purchase + $payment_expense + $wages_payment + $sell_return_payment;
        $net_profit = $revenue - $cost_sold_product + $cost_sold_returned_product   - $wages_payment - $expense;

        if (!empty($currency_id)) {
            if ($currency_id == $default_currency_id) {
                $current_stock_value = $this->productUtil->getCurrentStockValueByStore($store_id);
                // $current_stock_value_product = $this->productUtil->getCurrentStockValueProductByStore($store_id);
                // $current_stock_value_material = $this->productUtil->getCurrentStockValueMaterialByStore($store_id);
            } else {
                $current_stock_value = 0; //expense does not have currency
                // $current_stock_value_product = 0; //expense does not have
                // $current_stock_value_material = 0; //expense does not have currency
            }
        } else {
            $current_stock_value = $this->productUtil->getCurrentStockValueByStore($store_id);
            $current_stock_value_product = $this->productUtil->getCurrentStockValueProductByStore($store_id);
            $current_stock_value_material = $this->productUtil->getCurrentStockValueMaterialByStore($store_id);
        }

        $data['revenue'] =number_format($revenue,2); 
        $data['sell_return'] = number_format($sell_return,2);
        $data['profit'] = number_format($profit,2);
        $data['net_profit'] =number_format($net_profit,2);
        $data['purchase'] = number_format($purchase,2);
        $data['total_tax'] = number_format($total_tax,2);
        $data['expense'] = number_format($expense,2);
        // $data['purchase_return'] = number_format($purchase_return,2);
        $data['payment_received'] = number_format($payment_received_total,2);
        $data['payment_sent'] = number_format($payment_sent,2);
        $data['current_stock_value'] = number_format($current_stock_value,2);
        // $data['current_stock_value_product'] = number_format($current_stock_value_product,2);
        // $data['current_stock_value_material'] = number_format($current_stock_value_material,2);

        return $data;
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
