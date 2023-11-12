<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\JobType;
use App\Models\PaymentTransactionSellLine;
use App\Models\SellCar;
use App\Models\SellLine;
use App\Models\Store;
use App\Models\System;
use App\Models\TransactionSellLine;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RepresentativeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $job_type=JobType::where('title','Representative')->first();
        // $employees=Employee::where('job_type_id',$job_type->id)->get();
        $employees_id=Employee::where('job_type_id',$job_type->id)->pluck('id')->toArray();
        $transactions=TransactionSellLine::where('employee_id',$employees_id)
        ->when(\request()->store_id != null, function ($query) {
                $query->where('store_id',\request()->store_id);
        })
        ->when(\request()->customer_id != null, function ($query) {
            $query->where('customer_id',\request()->customer_id);
        })
        ->when(\request()->representative_id != null, function ($query) {
            $query->where('employee_id',\request()->representative_id);
        })
        ->get();
        $stores=Store::orderBy('created_at', 'desc')->pluck('name','id');
        $users=User::join('employees', 'users.id', '=', 'employees.user_id')
            ->where('employees.job_type_id', $job_type->id)
            ->orderBy('users.created_at', 'desc')
            ->pluck('users.name', 'users.id');
        $customers=Customer::orderBy('created_at', 'desc')->pluck('name','id');
        return view('employees.representatives.requests',compact('transactions','stores','users','customers'));
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
        try {
            $transaction=TransactionSellLine::find($id);
            $sell_lines=SellLine::where('transaction_id',$transaction->id)->delete();
            $transaction->deleted_by = Auth::user()->id;
            $transaction->save();
            $transaction->delete();
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
          return $output;
    }
    public function printRepresentativeInvoice(Request $request,$transaction_id){
        $transaction=TransactionSellLine::find($transaction_id);
        if (!empty($request->transaction_invoice_lang)) {
            $invoice_lang = $request->transaction_invoice_lang;
        } else {
            $invoice_lang = System::getProperty('invoice_lang');
            if (empty($invoice_lang)) {
                $invoice_lang = request()->session()->get('language');
            }
        }
        $payment_types = $this->getPaymentTypeArrayForPos();
        $print_gift_invoice=null;
        return $html_content = view('invoices.partials.invoice')->with(compact(
            'transaction',
            'payment_types',
            'invoice_lang',
            //                'total_due',
            'print_gift_invoice'
        ))->render();
    }
    public function getPaymentTypeArrayForPos()
    {
        return [
            'cash' => __('lang.cash'),
            //            'cheque' => __('lang.cheque'),
            //            'deposit' => __('lang.use_the_balance'),
            //            'paypal' => __('lang.paypal'),
        ];
    }
    public function pay($transaction_id){
        try {
            $transaction=TransactionSellLine::find($transaction_id);
            $transaction->status="final";
            $transaction->save();
            $transaction_payment = PaymentTransactionSellLine::where('transaction_id', $transaction_id)->first();
            if(!empty($transaction_payment )){
                $transaction_payment->amount=$transaction->final_total;
                $transaction_payment->final_amount=$transaction->dollar_final_total;
                $transaction_payment->save();
            }else{
                PaymentTransactionSellLine::create([
                    'transaction_id'=> $transaction_id,
                    'amount'=>$transaction->final_total,
                    'dollar_amount'=>$transaction->dollar_final_total,
                    'method'=>'cash',
                    'paid_on' => Carbon::now(),
                    'created_by' => Auth::user()->id,
                    'payment_for' =>  $transaction->customer_id,
                    'exchange_rate' => isset($transaction->exchange_rate)?$transaction->exchange_rate:System::getProperty('dollar_exchange'),
                ]);
            }
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
        return redirect()->back()->with('status', $output);
    }
}
