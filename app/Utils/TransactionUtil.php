<?php

namespace App\Utils;

use App\Models\Customer;
use App\Models\CustomerBalanceAdjustments;
use App\Models\Employee;
use App\Models\PaymentTransactionSellLine;
use App\Models\SellLine;
use App\Models\System;
use App\Models\TransactionSellLine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionUtil extends Util
{
    public function getInvoicePrint($transaction, $payment_types, $transaction_invoice_lang = null)
    {
        $print_gift_invoice = request()->print_gift_invoice;

        if (!empty($transaction_invoice_lang)) {
            $invoice_lang = $transaction_invoice_lang;
        } else {
            $invoice_lang = System::getProperty('invoice_lang');
            if (empty($invoice_lang)) {
                $invoice_lang = request()->session()->get('language');
            }
        }
        //        $total_due= $this->getCustomerBalance($transaction->customer_id)['balance'];

        if ($invoice_lang == 'ar_and_en') {
            $html_content = view('sale_pos.partials.invoice_ar_and_end')->with(compact(
                'transaction',
                'payment_types',
                'print_gift_invoice',
            //                'total_due',
            ))->render();
        } else {
            $html_content = view('invoices.partials.invoice')->with(compact(
                'transaction',
                'payment_types',
                'invoice_lang',
                //                'total_due',
                'print_gift_invoice'
            ))->render();
        }

        if ($transaction->is_direct_sale == 1) {
            $sale = $transaction;
            $payment_type_array = $payment_types;
            $html_content = view('sale_pos.partials.commercial_invoice')->with(compact(
                'sale',
                'payment_type_array',
                'invoice_lang',
                //                'total_due',
                'print_gift_invoice',
            ))->render();
        }

        if ($transaction->is_quotation == 1 && $transaction->status == 'draft') {
            $sale = $transaction;
            $payment_type_array = $payment_types;
            $html_content = view('sale_pos.partials.commercial_invoice')->with(compact(
                'sale',
                'payment_type_array',
                'invoice_lang'
            ))->render();
        }

        return $html_content;
    }
    public function getFilterOptionValues($request)
    {

        $data['store_id'] = null;
        $data['pos_id'] = null;
        if (!empty($request->store_id)) {
            $data['store_id'] = $request->store_id;
        }
        if (!empty($request->pos_id)) {
            $data['pos_id'] = $request->pos_id;
        }
        // if (!session('user.is_superadmin')) {
        //     $employee = Employee::where('user_id', auth()->user()->id)->first();
        //     if(in_array($data['store_id'],(array) $employee->store_id)){
        //         $data['store_id'] =$data['store_id'];
        //     }
            // $data['pos_id'] = session('user.pos_id');
        // }

        return $data;
    }
    public function getCustomerDollarBalanceExceptTransaction($customer_id,$transaction_id)
    {
        $total_paid=TransactionSellLine::where('customer_id',$customer_id)->where('type','sell')->where('status','final')->with('transaction_payments') // Ensure the relationship is eager-loaded
    ->get()
    ->flatMap(function ($sellLine) {
        return $sellLine->transaction_payments;
    })->sum('dollar_amount');
        $total_return_paid=TransactionSellLine::where('customer_id',$customer_id)->where('type','sell_return')->where('status','final')->with('transaction_payments') // Ensure the relationship is eager-loaded
    ->get()
    ->flatMap(function ($sellLine) {
        return $sellLine->transaction_payments;
    })->sum('amount');
        $total_invoice=TransactionSellLine::where('customer_id',$customer_id)->where('type','sell')->where('status','final')->sum('dollar_final_total');
        $total_return=TransactionSellLine::where('customer_id',$customer_id)->where('type','sell_return')->where('status','final')->sum('dollar_final_total');
        $deposit_balance=Customer::find($customer_id)->deposit_balance??0;
        $added_balance=Customer::find($customer_id)->dollar_balance??0;

        // $balance_adjustment = CustomerBalanceAdjustments::where('customer_id', $customer_id)->sum('add_new_balance');
        $balance = ($total_paid - $total_invoice  + $total_return - $total_return_paid)+ $deposit_balance + $added_balance ;
    }
    public function getCustomerBalanceExceptTransaction($customer_id,$transaction_id)
    {
        $total_paid=TransactionSellLine::where('customer_id',$customer_id)->where('type','sell')->where('status','final')->with('transaction_payments') // Ensure the relationship is eager-loaded
    ->get()
    ->flatMap(function ($sellLine) {
        return $sellLine->transaction_payments;
    })->sum('amount');
        $total_return_paid=TransactionSellLine::where('customer_id',$customer_id)->where('type','sell_return')->where('status','final')->with('transaction_payments') // Ensure the relationship is eager-loaded
    ->get()
    ->flatMap(function ($sellLine) {
        return $sellLine->transaction_payments;
    })->sum('amount');
        $total_invoice=TransactionSellLine::where('customer_id',$customer_id)->where('type','sell')->where('status','final')->sum('final_total');
        $total_return=TransactionSellLine::where('customer_id',$customer_id)->where('type','sell_return')->where('status','final')->sum('final_total');
        $deposit_balance=Customer::find($customer_id)->deposit_balance??0;
        $added_balance=Customer::find($customer_id)->added_balance??0;

        $balance_adjustment = CustomerBalanceAdjustments::where('customer_id', $customer_id)->sum('add_new_balance');
        $balance = ($total_paid - $total_invoice  + $total_return - $total_return_paid)+ $deposit_balance + $added_balance + $balance_adjustment;        // print_r( $customer_details->total_return); die();
        return ['balance' => $balance];
    }
    public function updateTransactionPaymentStatus($transaction_id)
    {
        $transaction_payments =PaymentTransactionSellLine::where('transaction_id', $transaction_id)->get();

        $total_paid = $transaction_payments->sum('amount');

        $transaction = TransactionSellLine::find($transaction_id);
        $returned_transaction = TransactionSellLine::where('return_parent_id',$transaction_id)->sum('final_total');
        if($returned_transaction){
            $final_amount = $transaction->final_total - $transaction->used_deposit_balance -  $returned_transaction;
        }else{
            $final_amount = $transaction->final_total - $transaction->used_deposit_balance;
        }
        
        $payment_status = 'pending';
        if ($final_amount <= $total_paid) {
            $payment_status = 'paid';
        } elseif ($total_paid > 0 && $final_amount > $total_paid) {
            $payment_status = 'partial';
        }
        $transaction->payment_status = $payment_status;
        $transaction->save();

        return $transaction;
    }
    public function createOrUpdateTransactionPayment($transaction, $payment_data)
    {
        if (!empty($payment_data['transaction_payment_id'])) {
            $transaction_payment = PaymentTransactionSellLine::find($payment_data['transaction_payment_id']);
            $transaction_payment->amount = $payment_data['amount'];
            $transaction_payment->dollar_amount = $payment_data['dollar_amount'];
            $transaction_payment->method = $payment_data['method'];
            $transaction_payment->payment_for = !empty($payment_data['payment_for']) ? $payment_data['payment_for'] : $transaction->customer_id;
            $transaction_payment->ref_number = !empty($payment_data['ref_number']) ? $payment_data['ref_number'] : null;
            $transaction_payment->exchange_rate = !empty($payment_data['exchange_rate']) ? $payment_data['exchange_rate'] : System::getProperty('exchange_rate');
            $transaction_payment->source_type = !empty($payment_data['source_type']) ? $payment_data['source_type'] : null;
            $transaction_payment->source_id = !empty($payment_data['source_id']) ? $payment_data['source_id'] : null;
            $transaction_payment->bank_deposit_date = !empty($payment_data['bank_deposit_date']) ? $payment_data['bank_deposit_date'] : null;
            $transaction_payment->bank_name = !empty($payment_data['bank_name']) ?  $payment_data['bank_name'] : null;
            $transaction_payment->card_number = !empty($payment_data['card_number']) ?  $payment_data['card_number'] : null;
            $transaction_payment->card_security = !empty($payment_data['card_security']) ?  $payment_data['card_security'] : null;
            $transaction_payment->card_month = !empty($payment_data['card_month']) ?  $payment_data['card_month'] : null;
            $transaction_payment->card_year = !empty($payment_data['card_year']) ?  $payment_data['card_year'] : null;
            $transaction_payment->cheque_number = !empty($payment_data['cheque_number']) ?  $payment_data['cheque_number'] : null;
            $transaction_payment->gift_card_number = !empty($payment_data['gift_card_number']) ?  $payment_data['gift_card_number'] : null;
            $transaction_payment->amount_to_be_used = !empty($payment_data['amount_to_be_used']) ?  $this->num_uf($payment_data['amount_to_be_used']) : 0;
            $transaction_payment->payment_note = !empty($payment_data['payment_note']) ?  $payment_data['payment_note'] : null;
            $transaction_payment->created_by = !empty($payment_data['created_by']) ? $payment_data['created_by'] : Auth::user()->id;
            $transaction_payment->is_return = !empty($payment_data['is_return']) ? 1 : 0;
            $transaction_payment->paid_on = $payment_data['paid_on'];

            $transaction_payment->save();
        } else {
            $transaction_payment = null;
            if (!empty($payment_data['amount'])) {
                $payment_data['created_by'] = Auth::user()->id;
                $payment_data['payment_for'] = !empty($payment_data['payment_for']) ? $payment_data['payment_for'] : $transaction->customer_id;
                $payment_data['exchange_rate'] = !empty($payment_data['exchange_rate']) ? $payment_data['exchange_rate'] : System::getProperty('dollar_exchange');
                
                $transaction_payment = PaymentTransactionSellLine::create($payment_data);
                //     if($transaction->type == 'sell'){
                //         if($payment_data['method'] != 'deposit'){
                //             if($payment_data['amount'] > $transaction->final_total)
                //             $payment_data['amount'] = $transaction->final_total;
                //         }else{

                //         }
                //     }
            }
        }

        return $transaction_payment;
    }
}
