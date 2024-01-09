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
use App\Models\CashRegisterTransaction;
use App\Models\MoneySafe;
use App\Models\MoneySafeTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        $query = CashRegister::leftjoin('cash_register_transactions', 'cash_registers.id', 'cash_register_transactions.cash_register_id');
            // ->leftjoin('transaction_sell_lines', 'cash_register_transactions.sell_transaction_id', 'transaction_sell_lines.id')
            // ->leftjoin('stock_transactions', 'cash_register_transactions.stock_transaction_id', 'stock_transactions.id');
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
        $cash_registers = $query->select(
                'cash_registers.id',
                'cash_registers.created_at',
                'cash_registers.user_id',
                'cash_registers.store_pos_id',
                'cash_registers.notes',
                'cash_registers.status',
            DB::raw("SUM(IF(transaction_type = 'sell', amount, 0)) as dinar_total_sale"),
            DB::raw("SUM(IF(transaction_type = 'sell', dollar_amount, 0)) as dollar_total_sale"),
            DB::raw("SUM(IF(transaction_type = 'refund', amount, 0)) as total_refund"),
            DB::raw("SUM(IF(transaction_type = 'refund', dollar_amount, 0)) as dollar_total_refund"),
            DB::raw("SUM(IF(transaction_type = 'pay_off', amount, 0)) as total_latest_payments"),
            DB::raw("SUM(IF(transaction_type = 'pay_off', dollar_amount, 0)) as dollar_total_latest_payments"),
            DB::raw("SUM(IF(transaction_type = 'sell' AND pay_method = 'cash' AND cash_register_transactions.type = 'credit', amount, 0)) as dinar_total_cash_sales"),
            DB::raw("SUM(IF(transaction_type = 'sell' AND pay_method = 'cash' AND cash_register_transactions.type = 'credit', dollar_amount, 0)) as dollar_total_cash_sales"),
            DB::raw("SUM(IF(transaction_type = 'refund' AND pay_method = 'cash' AND cash_register_transactions.type = 'debit', amount, 0)) as dinar_total_refund_cash"),
            DB::raw("SUM(IF(transaction_type = 'refund' AND pay_method = 'cash' AND cash_register_transactions.type = 'debit', dollar_amount, 0)) as dollar_total_refund_cash"),
            DB::raw("SUM(IF(transaction_type = 'sell' AND pay_method = 'card' AND cash_register_transactions.type = 'credit', amount, 0)) as dinar_total_card_sales"),
            DB::raw("SUM(IF(transaction_type = 'sell' AND pay_method = 'card' AND cash_register_transactions.type = 'credit', dollar_amount, 0)) as dollar_total_card_sales"),
            DB::raw("SUM(IF(transaction_type = 'refund' AND pay_method = 'card' AND cash_register_transactions.type = 'debit', amount, 0)) as dinar_total_refund_card"),
            DB::raw("SUM(IF(transaction_type = 'refund' AND pay_method = 'card' AND cash_register_transactions.type = 'debit', dollar_amount, 0)) as dollar_total_refund_card"),
            DB::raw("SUM(IF(transaction_type = 'sell' AND pay_method = 'bank_transfer' AND cash_register_transactions.type = 'credit', amount, 0)) as dinar_total_bank_transfer_sales"),
            DB::raw("SUM(IF(transaction_type = 'sell' AND pay_method = 'bank_transfer' AND cash_register_transactions.type = 'credit', dollar_amount, 0)) as dollar_total_bank_transfer_sales"),
            DB::raw("SUM(IF(transaction_type = 'refund' AND pay_method = 'bank_transfer' AND cash_register_transactions.type = 'debit', amount, 0)) as dinar_total_refund_bank_transfer"),
            DB::raw("SUM(IF(transaction_type = 'refund' AND pay_method = 'bank_transfer' AND cash_register_transactions.type = 'debit', dollar_amount, 0)) as dollar_total_refund_bank_transfer"),
            DB::raw("SUM(IF(transaction_type = 'sell' AND pay_method = 'gift_card' AND cash_register_transactions.type = 'credit', amount, 0)) as dinar_total_gift_card_sales"),
            DB::raw("SUM(IF(transaction_type = 'sell' AND pay_method = 'gift_card' AND cash_register_transactions.type = 'credit', dollar_amount, 0)) as dollar_total_gift_card_sales"),
            DB::raw("SUM(IF(transaction_type = 'sell' AND pay_method = 'cheque' AND cash_register_transactions.type = 'credit', amount, 0)) as dinar_total_cheque_sales"),
            DB::raw("SUM(IF(transaction_type = 'sell' AND pay_method = 'cheque' AND cash_register_transactions.type = 'credit', dollar_amount, 0)) as dollar_total_cheque_sales"),
            DB::raw("SUM(IF(transaction_type = 'refund' AND pay_method = 'cheque' AND cash_register_transactions.type = 'debit', amount, 0)) as dinar_total_refund_cheque"),
            DB::raw("SUM(IF(transaction_type = 'refund' AND pay_method = 'cheque' AND cash_register_transactions.type = 'debit', dollar_amount, 0)) as dollar_total_refund_cheque"),
            DB::raw("SUM(IF(transaction_type = 'add_stock' AND pay_method = 'cash' AND cash_register_transactions.type = 'debit', amount, 0)) as dinar_total_purchases"),
            DB::raw("SUM(IF(transaction_type = 'add_stock' AND pay_method = 'cash' AND cash_register_transactions.type = 'debit', dollar_amount, 0)) as dollar_total_purchases"),
            DB::raw("SUM(IF(transaction_type = 'expense' AND pay_method = 'cash' AND cash_register_transactions.type = 'debit', amount, 0)) as dinar_total_expenses"),
            DB::raw("SUM(IF(transaction_type = 'expense' AND pay_method = 'cash' AND cash_register_transactions.type = 'debit', dollar_amount, 0)) as dollar_total_expenses"),
            DB::raw("SUM(IF(transaction_type = 'cash_in' AND pay_method = 'cash' AND cash_register_transactions.type = 'debit', amount, 0)) as dinar_total_cash_in"),
            DB::raw("SUM(IF(transaction_type = 'cash_in' AND pay_method = 'cash' AND cash_register_transactions.type = 'debit', dollar_amount, 0)) as dollar_total_cash_in"),
            DB::raw("SUM(IF(transaction_type = 'cash_out' AND pay_method = 'cash' AND cash_register_transactions.type = 'credit', amount, 0)) as dinar_total_cash_out"),
            DB::raw("SUM(IF(transaction_type = 'cash_out' AND pay_method = 'cash' AND cash_register_transactions.type = 'credit', dollar_amount, 0)) as dollar_total_cash_out"),
            DB::raw("SUM(IF(transaction_type = 'sell_return' AND pay_method = 'cash' AND cash_register_transactions.type = 'debit', amount, 0)) as dinar_total_sell_return"),
            DB::raw("SUM(IF(transaction_type = 'sell_return' AND pay_method = 'cash' AND cash_register_transactions.type = 'debit', dollar_amount, 0)) as dollar_total_sell_return"),
        )->groupBy('cash_registers.id', 'cash_registers.created_at', 'cash_registers.user_id', 'cash_registers.notes', 'cash_registers.store_pos_id', 'cash_registers.status') // Add other columns as needed
        ->orderBy('cash_registers.created_at', 'desc')
            ->get();
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
//        dd($cash_register_id);
        //Check if there is a open register, if yes then redirect to POS screen.
        if ($this->cashRegisterUtil->countOpenedRegister() == 0 && !auth()->user()->can('superadmin')) {
            return redirect()->action('CashRegisterController@create');
        }
        $type = request()->get('type');
        $query = CashRegister::leftjoin('cash_register_transactions', 'cash_registers.id', 'cash_register_transactions.cash_register_id')
            ->leftjoin('transaction_sell_lines', 'cash_register_transactions.sell_transaction_id', 'transaction_sell_lines.id')
            ->leftjoin('stock_transactions', 'cash_register_transactions.stock_transaction_id', 'stock_transactions.id');
        $query->where('cash_registers.id', $cash_register_id);

        $cr_data = [];
        $total_cash = 0;
        $dollar_total_cash = 0;
            $cash_register = $query->select(
//                'cash_registers.*',
                DB::raw("SUM(IF(transaction_type = 'sell', amount, 0)) as dinar_total_sale"),
                DB::raw("SUM(IF(transaction_type = 'sell', dollar_amount, 0)) as dollar_total_sale"),
                DB::raw("SUM(IF(transaction_type = 'refund', amount, 0)) as total_refund"),
                DB::raw("SUM(IF(transaction_type = 'refund', dollar_amount, 0)) as dollar_total_refund"),
                DB::raw("SUM(IF(transaction_type = 'pay_off', amount, 0)) as total_latest_payments"),
                DB::raw("SUM(IF(transaction_type = 'pay_off', dollar_amount, 0)) as dollar_total_latest_payments"),
                DB::raw("SUM(IF(transaction_type = 'sell' AND pay_method = 'cash' AND cash_register_transactions.type = 'credit', amount, 0)) as dinar_total_cash_sales"),
                DB::raw("SUM(IF(transaction_type = 'sell' AND pay_method = 'cash' AND cash_register_transactions.type = 'credit', dollar_amount, 0)) as dollar_total_cash_sales"),
                DB::raw("SUM(IF(transaction_type = 'refund' AND pay_method = 'cash' AND cash_register_transactions.type = 'debit', amount, 0)) as dinar_total_refund_cash"),
                DB::raw("SUM(IF(transaction_type = 'refund' AND pay_method = 'cash' AND cash_register_transactions.type = 'debit', dollar_amount, 0)) as dollar_total_refund_cash"),
                DB::raw("SUM(IF(transaction_type = 'sell' AND pay_method = 'card' AND cash_register_transactions.type = 'credit', amount, 0)) as dinar_total_card_sales"),
                DB::raw("SUM(IF(transaction_type = 'sell' AND pay_method = 'card' AND cash_register_transactions.type = 'credit', dollar_amount, 0)) as dollar_total_card_sales"),
                DB::raw("SUM(IF(transaction_type = 'refund' AND pay_method = 'card' AND cash_register_transactions.type = 'debit', amount, 0)) as dinar_total_refund_card"),
                DB::raw("SUM(IF(transaction_type = 'refund' AND pay_method = 'card' AND cash_register_transactions.type = 'debit', dollar_amount, 0)) as dollar_total_refund_card"),
                DB::raw("SUM(IF(transaction_type = 'sell' AND pay_method = 'bank_transfer' AND cash_register_transactions.type = 'credit', amount, 0)) as dinar_total_bank_transfer_sales"),
                DB::raw("SUM(IF(transaction_type = 'sell' AND pay_method = 'bank_transfer' AND cash_register_transactions.type = 'credit', dollar_amount, 0)) as dollar_total_bank_transfer_sales"),
                DB::raw("SUM(IF(transaction_type = 'refund' AND pay_method = 'bank_transfer' AND cash_register_transactions.type = 'debit', amount, 0)) as dinar_total_refund_bank_transfer"),
                DB::raw("SUM(IF(transaction_type = 'refund' AND pay_method = 'bank_transfer' AND cash_register_transactions.type = 'debit', dollar_amount, 0)) as dollar_total_refund_bank_transfer"),
                DB::raw("SUM(IF(transaction_type = 'sell' AND pay_method = 'gift_card' AND cash_register_transactions.type = 'credit', amount, 0)) as dinar_total_gift_card_sales"),
                DB::raw("SUM(IF(transaction_type = 'sell' AND pay_method = 'gift_card' AND cash_register_transactions.type = 'credit', dollar_amount, 0)) as dollar_total_gift_card_sales"),
                DB::raw("SUM(IF(transaction_type = 'sell' AND pay_method = 'cheque' AND cash_register_transactions.type = 'credit', amount, 0)) as dinar_total_cheque_sales"),
                DB::raw("SUM(IF(transaction_type = 'sell' AND pay_method = 'cheque' AND cash_register_transactions.type = 'credit', dollar_amount, 0)) as dollar_total_cheque_sales"),
                DB::raw("SUM(IF(transaction_type = 'refund' AND pay_method = 'cheque' AND cash_register_transactions.type = 'debit', amount, 0)) as dinar_total_refund_cheque"),
                DB::raw("SUM(IF(transaction_type = 'refund' AND pay_method = 'cheque' AND cash_register_transactions.type = 'debit', dollar_amount, 0)) as dollar_total_refund_cheque"),
                DB::raw("SUM(IF(transaction_type = 'add_stock' AND pay_method = 'cash' AND cash_register_transactions.type = 'debit', amount, 0)) as dinar_total_purchases"),
                DB::raw("SUM(IF(transaction_type = 'add_stock' AND pay_method = 'cash' AND cash_register_transactions.type = 'debit', dollar_amount, 0)) as dollar_total_purchases"),
                DB::raw("SUM(IF(transaction_type = 'expense' AND pay_method = 'cash' AND cash_register_transactions.type = 'debit', amount, 0)) as dinar_total_expenses"),
                DB::raw("SUM(IF(transaction_type = 'expense' AND pay_method = 'cash' AND cash_register_transactions.type = 'debit', dollar_amount, 0)) as dollar_total_expenses"),
                DB::raw("SUM(IF(transaction_type = 'cash_in' AND pay_method = 'cash' AND cash_register_transactions.type = 'debit', amount, 0)) as dinar_total_cash_in"),
                DB::raw("SUM(IF(transaction_type = 'cash_in' AND pay_method = 'cash' AND cash_register_transactions.type = 'debit', dollar_amount, 0)) as dollar_total_cash_in"),
                DB::raw("SUM(IF(transaction_type = 'cash_out' AND pay_method = 'cash' AND cash_register_transactions.type = 'credit', amount, 0)) as dinar_total_cash_out"),
                DB::raw("SUM(IF(transaction_type = 'cash_out' AND pay_method = 'cash' AND cash_register_transactions.type = 'credit', dollar_amount, 0)) as dollar_total_cash_out"),
                DB::raw("SUM(IF(transaction_type = 'sell_return' AND pay_method = 'cash' AND cash_register_transactions.type = 'debit', amount, 0)) as dinar_total_sell_return"),
                DB::raw("SUM(IF(transaction_type = 'sell_return' AND pay_method = 'cash' AND cash_register_transactions.type = 'debit', dollar_amount, 0)) as dollar_total_sell_return"),
            )->first();
//            dd($cash_register);
            $cash_register->dinar_total_cash_sales =  $cash_register->dinar_total_cash_sales - $cash_register->dinar_total_refund_cash;
            $cash_register->dollar_total_cash_sales =  $cash_register->dollar_total_cash_sales - $cash_register->dollar_total_refund_cash;
            $cash_register->dinar_total_card_sales =  $cash_register->dinar_total_card_sales - $cash_register->dinar_total_refund_card;
            $cash_register->dollar_total_card_sales =  $cash_register->dollar_total_card_sales - $cash_register->dollar_total_refund_card;
            $cash_register->dinar_total_bank_transfer_sales =  $cash_register->dinar_total_bank_transfer_sales - $cash_register->dinar_total_refund_bank_transfer;
            $cash_register->dinar_dollar_total_bank_transfer_sales =  $cash_register->dollar_total_bank_transfer_sales - $cash_register->dollar_total_refund_bank_transfer;
            $cash_register->dinar_total_cheque_sales =  $cash_register->dinar_total_cheque_sales - $cash_register->dinar_total_refund_cheque;
            $cash_register->dollar_total_cheque_sales =  $cash_register->dollar_total_cheque_sales - $cash_register->dollar_total_refund_cheque;

            $total_cash = $cash_register->dinar_total_cash_sales +
                $cash_register->dinar_total_cash_in - $cash_register->dinar_total_cash_out -
                $cash_register->dinar_total_purchases - $cash_register->dinar_total_expenses - $cash_register->dinar_total_wages_and_compensation - $cash_register->dinar_total_sell_return;
            $dollar_total_cash = $cash_register->dollar_total_cash_sales +
                $cash_register->dollar_total_cash_in - $cash_register->dollar_total_cash_out -
                $cash_register->dollar_total_purchases - $cash_register->dollar_total_expenses - $cash_register->dollar_total_wages_and_compensation - $cash_register->dollar_total_sell_return;

//        }

        $users = User::Notview()->orderBy('name', 'asc')->pluck('name', 'id');

        return view('cash.add_closing_cash')->with(compact(
            'cash_register',
            'cr_data',
            'cash_register_id',
            'type',
            'total_cash',
            'dollar_total_cash',
            'users'
        ));
    }

        /**
     * add closing cash save to storage
     *
     * @param int $cash_register_id
     * @return void
     */
    public function saveAddClosingCash(Request $request)
    {
        try {
            $cash_given_to=User::find($request->cash_given_to)->name;
            if($request->source_type == 'user' && $cash_given_to=='Admin' && request()->user()->name=="Admin"){
                $output = [
                    'success' => false,
                    'msg' => __('lang.not_allowed')
                ];
            }else{

            DB::beginTransaction();
            $data = $request->except('_token');

            $amount = $this->commonUtil->num_uf($request->input('amount'));
            $dollar_amount = $this->commonUtil->num_uf($request->input('dollar_amount'));
            $register = CashRegister::find($request->cash_register_id);
            $register->source_type = $request->source_type;
            $register->cash_given_to = $request->cash_given_to;
            $register->closing_amount = $amount;
            $register->closing_dollar_amount = $dollar_amount;
            $register->closed_at = Carbon::now();
            $register->status = 'close';
            $register->notes = $request->notes;
            $register->save();
            // if ($request->submit == 'adjustment') {
            //     $data['store_id'] = $register->store_id;
            //     $data['user_id'] = $register->user_id;
            //     $data['cash_register_id'] = $register->id;
            //     $data['amount'] = $amount;
            //     $data['current_cash'] = $this->commonUtil->num_uf($data['current_cash']);
            //     $data['discrepancy'] = $this->commonUtil->num_uf($data['discrepancy']);
            //     $data['date_and_time'] = Carbon::now();
            //     $data['created_by'] = Auth::user()->id;

            //     CashInAdjustment::create($data);
            // }

            $cash_register_transaction = $this->cashRegisterUtil->createCashRegisterTransaction($register, $amount,$dollar_amount, 'closing_cash', 'credit', $request->source_id, $request->notes);

            $user_id = $register->user_id;

            if (!empty($request->cash_given_to)) {
                if ($request->source_type == 'user') {
                    $register = $this->cashRegisterUtil->getCurrentCashRegisterOrCreate($request->cash_given_to);
                    $cash_register_transaction_in = $this->cashRegisterUtil->createCashRegisterTransaction($register, $amount,$dollar_amount, 'cash_in', 'debit', $user_id, $request->notes, $cash_register_transaction->id);
                    $cash_register_transaction->referenced_id = $cash_register_transaction_in->id;
                    $cash_register_transaction->save();
                }
                if ($request->source_type == 'safe') {
                    $default_currency_id = System::getProperty('currency');
                    $money_safe = MoneySafe::find($request->cash_given_to);

                    $money_safe_data['money_safe_id'] = $money_safe->id;
                    $money_safe_data['transaction_date'] = Carbon::now();
                    $money_safe_data['transaction_id'] = null;
                    $money_safe_data['transaction_payment_id'] = null;
                    $money_safe_data['currency_id'] = $default_currency_id;
                    $money_safe_data['type'] = 'credit';
                    $money_safe_data['store_id'] = $register->store_id ?? 0;
                    $money_safe_data['amount'] = $amount;
                    $money_safe_data['dollar_amount'] = $dollar_amount;
                    $money_safe_data['created_by'] = Auth::user()->id;
                    $money_safe_data['comments'] = __('lang.closing_cash');
                    MoneySafeTransaction::create($money_safe_data);
                }
                if ($request->source_type == 'pos') {
                    $cash_register_transaction_in = $this->cashRegisterUtil->createCashRegisterTransaction($register, $amount,$dollar_amount, 'closing_cash', 'credit', $user_id, $request->notes, $cash_register_transaction->id);
                    $cash_register_transaction->referenced_id = $cash_register_transaction_in->id;
                    $cash_register_transaction->save();
                }
            }

            DB::commit();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        }

        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            dd($e);
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }
        if ($request->ajax()) {
            return $output;
        }
        return redirect()->back()->with('status', $output);
    }

}
