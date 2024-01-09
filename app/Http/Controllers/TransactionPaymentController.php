<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DebtTransactionPayment;
use App\Models\DeptPayment;
use App\Models\MoneySafe;
use App\Models\StorePos;
use App\Models\TransactionSellLine;
use App\Models\User;
use App\Utils\MoneySafeUtil;
use App\Utils\TransactionUtil;
use App\Utils\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionPaymentController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $commonUtil;
    protected $transactionUtil;
    protected $cashRegisterUtil;
    protected $moneysafeUtil;


    /**
     * Constructor
     *
     * @param Util $commonUtil
     * @param TransactionUtil $transactionUtil
     * @param CashRegisterUtil $cashRegisterUtil
     * @param MoneySafeUtil $moneysafeUtil
     * @return void
     */
    public function __construct(Util $commonUtil, TransactionUtil $transactionUtil, MoneySafeUtil $moneysafeUtil)
    {
        $this->commonUtil = $commonUtil;
        $this->transactionUtil = $transactionUtil;
        $this->moneysafeUtil = $moneysafeUtil;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        try {
            $data = $request->except('_token');
            $payment_data = [
                'transaction_payment_id' =>  !empty($request->transaction_payment_id) ? $request->transaction_payment_id : null,
                'transaction_id' =>  $request->transaction_id,
                'amount' => $this->commonUtil->num_uf($request->amount)??0,
                'dollar_amount' => $this->commonUtil->num_uf($request->dollar_amount)??0,
                'method' => $request->method,
                'paid_on' => $this->commonUtil->uf_date($data['paid_on']) . ' ' . date('H:i:s'),
                'ref_number' => $request->ref_number,
                'bank_deposit_date' => !empty($data['bank_deposit_date']) ? $this->commonUtil->uf_date($data['bank_deposit_date']) : null,
                'bank_name' => $request->bank_name,
                'card_number' => $request->card_number,
                'card_month' => $request->card_month,
                'card_year' => $request->card_year,
            ];
            DB::beginTransaction();
            $transaction = TransactionSellLine::find($request->transaction_id);
            $debt_data = [
                'amount' => $this->commonUtil->num_uf($request->amount),
                'dollar_amount' => $this->commonUtil->num_uf($request->dollar_amount),
                'dinar_remaining' =>$transaction->dinar_remaining>0?($transaction->dinar_remaining - $this->commonUtil->num_uf($request->amount)):0,
                'dollar_remaining' =>$transaction->dollar_remaining>0?($transaction->dollar_remaining - $this->commonUtil->num_uf($request->dollar_amount)):0,
                'type' => 'Debt',
                'customer_id' => !empty( $transaction->customer_id) ?  $transaction->customer_id :  auth()->id(),
                'method' => $request->method,
                'paid_on' => $this->commonUtil->uf_date($request->paid_on),
                'ref_number' => $request->ref_number,
                'bank_deposit_date' => !empty($request->bank_deposit_date) ? $this->commonUtil->uf_date($request->bank_deposit_date) : null,
                'bank_name' => $request->bank_name,
                'created_by' => auth()->id(),
            ];
            // $debt_payment=  DeptPayment::create($debt_data);
            // $customer = Customer::find($transaction->customer_id);
            // if($request->add_to_customer_balance > 0){
            //     $customer->added_balance = $customer->added_balance + $request->add_to_customer_balance;
            //     $customer->save();
            // }
           
            // if ($request->upload_documents) {
            //     foreach ($request->file('upload_documents', []) as $key => $doc) {
            //         $debt_payment->addMedia($doc)->toMediaCollection('debt_payment');
            //     }
            // }
            $transaction_payment = $this->transactionUtil->createOrUpdateTransactionPayment($transaction, $payment_data);
            // DebtTransactionPayment::create([
            //     'debt_payment_id'=>$debt_payment->id,
            //     'transaction_payment_id'=>$transaction_payment->id,
            //     'amount'=>$this->commonUtil->num_uf($request->amount),
            // ]);
            if ($request->upload_documents) {
                foreach ($request->file('upload_documents', []) as $key => $doc) {
                    $transaction_payment->addMedia($doc)->toMediaCollection('transaction_payment');
                }
            }

            if ($transaction->type == 'add_stock' && $payment_data['method'] == 'cash') {
                $user_id = null;
                if (!empty($request->source_id)) {
                    if ($request->source_type == 'pos') {
                        $user_id = StorePos::where('id', $request->source_id)->first()->user_id;
                    }
                    if ($request->source_type == 'user') {
                        $user_id = $request->source_id;
                    }
                    if (!empty($user_id)) {
                        $this->cashRegisterUtil->addPayments($transaction, $payment_data, 'debit', $user_id);
                    }

                    if ($request->source_type == 'safe') {
                        $money_safe = MoneySafe::find($request->source_id);
                        $payment_data['currency_id'] = $transaction->paying_currency_id;
                        $this->moneysafeUtil->updatePayment($transaction, $payment_data, 'debit', $transaction_payment->id, null, $money_safe);
                    }
                }
            }


            $this->transactionUtil->updateTransactionPaymentStatus($transaction->id);
            if ($transaction->type == 'sell') {
                $this->cashRegisterUtil->addPayments($transaction, $payment_data, 'credit', null, $transaction_payment->id,'pay_off');

                if ($payment_data['method'] == 'bank_transfer' || $payment_data['method'] == 'card') {
                    $this->moneysafeUtil->addPayments($transaction, $payment_data, 'credit', $transaction_payment->id);
                }
            }
            DB::commit();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }

        if (request()->ajax()) {
            return $output;
        }

        return redirect()->back()->with('status', $output);
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
    public function addPayment($transaction_id)
    {
        
        $payment_type_array = $this->commonUtil->getPaymentTypeArray();
        $transaction = TransactionSellLine::find($transaction_id);
        $users = User::Notview()->pluck('name', 'id');
        $balance = Customer::find($transaction->customer_id)->balance??0;
        $dollar_balance = Customer::find($transaction->customer_id)->dollar_balance??0;

        return view('transaction_payment.add_payment')->with(compact(
            'payment_type_array',
            'transaction_id',
            'transaction',
            'users',
            'balance','dollar_balance'
        ));
    }
}
