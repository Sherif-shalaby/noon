<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;
use App\Models\System;
use App\Models\StorePos;
use App\Models\CashRegister;
use App\Utils\CashRegisterUtil;
use App\Utils\Util;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CashController extends Controller
{
    protected $commonUtil;
    protected $cashRegisterUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(Util $commonUtil, CashRegisterUtil $cashRegisterUtil)
    {
        $this->commonUtil = $commonUtil;
        $this->cashRegisterUtil = $cashRegisterUtil;
    }
    /* ++++++++++++++++++++++ index() ++++++++++++++++++++++ */
    public function index()
    {
        $default_currency_id = System::getProperty('currency');
        // Retrieve data for dropdowns
        $stores = Store::getDropdown();
        $store_pos = StorePos::orderBy('name', 'asc')->pluck('name', 'id');
        $users = User::Notview()->orderBy('name', 'asc')->pluck('name', 'id');

        // Retrieve cash registers with related transactions and cashier
        $query = CashRegister::with(['cashRegisterTransactions', 'cashier']);
        // +++++++ filters +++++++
        // 1- start_date filter
        if (!empty(request()->start_date))
        {
            $query->whereDate('created_at', '>=', request()->start_date);
        }
        // 2- end_date filter
        if (!empty(request()->end_date))
        {
            $query->whereDate('created_at', '<=', request()->end_date);
        }
        // 3- store_pos filter
        if (!empty(request()->store_pos_id))
        {
            $query->where('store_pos_id', request()->store_pos_id);
        }
        // 4- store filter
        if (!empty(request()->store_id))
        {
            $query->where('store_id', request()->store_id);
        }
        // 5- users filter
        if (!empty(request()->user_id))
        {
            $query->where('user_id', request()->user_id);
        }
        $cash_registers = $query->orderBy('created_at', 'desc')->get();
        // Iterate through each cash register
        foreach ($cash_registers as $register)
        {
            // Access the calculated attributes using accessor methods
            $totalSale = $register->totalSale;
            $totalDiningIn = $register->totalDiningIn;
            $totalDiningInCash = $register->totalDiningInCash;
            $totalCashSales = $register->totalCashSales;
            $totalRefundCash = $register->totalRefundCash;
            $totalCardSales = $register->totalCardSales;
            // Perform the manipulation within the controller
            $register->total_cash_sales -= $register->total_refund_cash;
            $register->total_card_sales -= $register->total_refund_card;
            // Store the manipulated values back in the cash register model
            $cr_data[$register->id]['cash_register'] = $register;
        }
        return view('cash.index', compact('cash_registers', 'stores', 'users', 'store_pos'));
    }
    /* ++++++++++++++++++++++ show() ++++++++++++++++++++++ */
    public function show($id)
    {
        $cash_register = CashRegister::withCount([
            'cashRegisterTransactions as total_dining_in' => function ($query) {
                $query->where('transaction_type', 'sell')
                    ->where('pay_method', 'cash')
                    ->where('type', 'credit')
                    ->select(DB::raw("SUM(amount)"));
            },
            'cashRegisterTransactions as total_sale' => function ($query) {
                $query->where('transaction_type', 'sell')
                    ->select(DB::raw("SUM(amount)"));
            },
            'cashRegisterTransactions as total_refund' => function ($query) {
                $query->where('transaction_type', 'refund')
                    ->select(DB::raw("SUM(amount)"));
            },
            'cashRegisterTransactions as total_cash_sales' => function ($query) {
                $query->where('transaction_type', 'sell')
                    ->where('pay_method', 'cash')
                    ->where('type', 'credit')
                    ->select(DB::raw("SUM(amount)"));
            },
            'cashRegisterTransactions as total_refund_cash' => function ($query) {
                $query->where('transaction_type', 'refund')
                    ->where('pay_method', 'cash')
                    ->where('type', 'debit')
                    ->select(DB::raw("SUM(amount)"));
            },
        ])->findOrFail($id);

        return view('cash.show', compact('cash_register'));
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
    public function addClosingCash($cash_register_id)
    {
        //Check if there is a open register, if yes then redirect to POS screen.
        if ($this->cashRegisterUtil->countOpenedRegister() == 0 && !auth()->user()->can('superadmin')) {
            return redirect()->action('CashRegisterController@create');
        }
        $exchange_rate_currencies = $this->commonUtil->getExchangeRateCurrencies(true);
        $type = request()->get('type');
        $query = CashRegister::leftjoin('cash_register_transactions', 'cash_registers.id', 'cash_register_transactions.cash_register_id')
            ->leftjoin('transactions', 'cash_register_transactions.transaction_id', 'transactions.id');
        $query->where('cash_registers.id', $cash_register_id);

        $cr_data = [];
        $total_cash = 0;
        foreach ($exchange_rate_currencies as $currency) {
            $cr_data[$currency['currency_id']]['currency'] = $currency;
            $cr_query = clone $query;

            if (!$currency['is_default']) {
                $cr_query->where('transactions.received_currency_id', $currency['currency_id']);
            } else {
                $cr_query->where(function ($q) use ($currency) {
                    $q->where('transactions.received_currency_id', $currency['currency_id'])
                        ->orWhereNull('transactions.received_currency_id');
                });
            }


            $cash_register = $cr_query->select(
                'cash_registers.*',
                DB::raw("SUM(IF(transaction_type = 'sell', amount, 0)) as total_sale"),
                DB::raw("SUM(IF(transaction_type = 'refund', amount, 0)) as total_refund"),
                DB::raw("SUM(IF(transaction_type = 'sell' AND cash_register_transactions.type = 'credit' AND dining_table_id IS NOT NULL, amount, 0)) as total_dining_in"),
                DB::raw("SUM(IF(transaction_type = 'sell' AND pay_method = 'cash' AND cash_register_transactions.type = 'credit' AND dining_table_id IS NOT NULL, amount, 0)) as total_dining_in_cash"),
                DB::raw("SUM(IF(transaction_type = 'sell' AND pay_method = 'cash' AND cash_register_transactions.type = 'credit', amount, 0)) as total_cash_sales"),
                DB::raw("SUM(IF(transaction_type = 'refund' AND pay_method = 'cash' AND cash_register_transactions.type = 'debit', amount, 0)) as total_refund_cash"),
                DB::raw("SUM(IF(transaction_type = 'sell' AND pay_method = 'card' AND cash_register_transactions.type = 'credit', amount, 0)) as total_card_sales"),
                DB::raw("SUM(IF(transaction_type = 'refund' AND pay_method = 'card' AND cash_register_transactions.type = 'debit', amount, 0)) as total_refund_card"),
                DB::raw("SUM(IF(transaction_type = 'sell' AND pay_method = 'bank_transfer' AND cash_register_transactions.type = 'credit', amount, 0)) as total_bank_transfer_sales"),
                DB::raw("SUM(IF(transaction_type = 'refund' AND pay_method = 'bank_transfer' AND cash_register_transactions.type = 'debit', amount, 0)) as total_refund_bank_transfer"),
                DB::raw("SUM(IF(transaction_type = 'sell' AND pay_method = 'gift_card' AND cash_register_transactions.type = 'credit', amount, 0)) as total_gift_card_sales"),
                DB::raw("SUM(IF(transaction_type = 'sell' AND pay_method = 'cheque' AND cash_register_transactions.type = 'credit', amount, 0)) as total_cheque_sales"),
                DB::raw("SUM(IF(transaction_type = 'refund' AND pay_method = 'cheque' AND cash_register_transactions.type = 'debit', amount, 0)) as total_refund_cheque"),
                DB::raw("SUM(IF(transaction_type = 'add_stock' AND pay_method = 'cash' AND cash_register_transactions.type = 'debit', amount, 0)) as total_purchases"),
                DB::raw("SUM(IF(transaction_type = 'expense' AND pay_method = 'cash' AND cash_register_transactions.type = 'debit', amount, 0)) as total_expenses"),
                DB::raw("SUM(IF(transaction_type = 'cash_in' AND pay_method = 'cash' AND cash_register_transactions.type = 'debit', amount, 0)) as total_cash_in"),
                DB::raw("SUM(IF(transaction_type = 'cash_out' AND pay_method = 'cash' AND cash_register_transactions.type = 'credit', amount, 0)) as total_cash_out"),
                DB::raw("SUM(IF(transaction_type = 'sell_return' AND pay_method = 'cash' AND cash_register_transactions.type = 'debit', amount, 0)) as total_sell_return"),
                DB::raw("SUM(IF(transaction_type = 'wages_and_compensation' AND pay_method = 'cash' AND cash_register_transactions.type = 'debit', amount, 0)) as total_wages_and_compensation"),
            )->first();
            $cash_register->total_cash_sales =  $cash_register->total_cash_sales - $cash_register->total_refund_cash;
            $cash_register->total_card_sales =  $cash_register->total_card_sales - $cash_register->total_refund_card;
            $cash_register->total_bank_transfer_sales =  $cash_register->total_bank_transfer_sales - $cash_register->total_refund_bank_transfer;
            $cash_register->total_cheque_sales =  $cash_register->total_cheque_sales - $cash_register->total_refund_cheque;
            $cr_data[$currency['currency_id']]['cash_register'] = $cash_register;

            if ($currency['is_default']) {
                $total_cash = $cash_register->total_cash_sales +
                    $cash_register->total_cash_in - $cash_register->total_cash_out -
                    $cash_register->total_purchases - $cash_register->total_expenses - $cash_register->total_wages_and_compensation - $cash_register->total_sell_return;
            }
        }
        $total_latest_payments= DB::table('cash_register_transactions')
            ->where('cash_register_id', $cash_register_id)
            ->where('transaction_type', 'sell')
            ->whereIn('transaction_id', function ($query) use ($cash_register) {
                $query->select('id')
                    ->from('transactions')
                    ->where(function ($query) use ($cash_register) {
                        $query->whereRaw('created_at <> updated_at');
                        $query->WhereRaw('updated_at >= (created_at + INTERVAL 1 MINUTE)');
                        $query->where('created_at', '<=',  Carbon::parse($cash_register->created_at));
                    })->
                    OrWhere(function ($query) use ($cash_register) {
                        $query->whereRaw('created_at <> updated_at');
                        $query->WhereRaw('updated_at >= (created_at + INTERVAL 1 MINUTE)');
                        $query->where('created_by', '!=', $cash_register->user_id)
                            ->where('created_at', '<=', Carbon::parse($cash_register->closed_at))
                            ->where('created_at', '>=',  Carbon::parse($cash_register->created_at));
                    });
            })
            ->sum('amount');
        $users = User::Notview()->orderBy('name', 'asc')->pluck('name', 'id');
        return view('cash.add_closing_cash')->with(compact(
            'total_latest_payments',
            'cash_register',
            'cr_data',
            'cash_register_id',
            'type',
            'total_cash',
            'users'
        ));
    }
}
