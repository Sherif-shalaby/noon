<?php

namespace App\Utils;


use App\Models\System;
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

    // public function getCustomerBalanceExceptTransaction($customer_id,$transaction_id)
    // {
    //     $query = Customer::join('transactions as t', 'customers.id', 't.customer_id')
    //     ->leftjoin('customer_types', 'customers.customer_type_id', 'customer_types.id')
    //     ->where('customers.id', $customer_id);
    //     $query->where('t.id','!=',$transaction_id);
    // $query->select(
    //     'customers.total_rp',
    //     'customers.deposit_balance',
    //     'customers.added_balance',
    //     DB::raw("SUM(IF(t.type = 'sell_return' AND t.status = 'final', final_total, 0)) as total_return"),
    //     DB::raw("SUM(IF(t.type = 'sell_return' AND t.status = 'final', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as total_return_paid"),
    //     DB::raw("SUM(IF(t.type = 'sell' AND t.status = 'final', final_total, 0)) as total_invoice"),
    //     DB::raw("SUM(IF(t.type = 'sell' AND t.status = 'final', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as total_paid"),
    // );
    // $customer_details = $query->first();


    // $balance_adjustment = CustomerBalanceAdjustments::where('customer_id', $customer_id)->sum('add_new_balance');
    // $balance = ($customer_details->total_paid - $customer_details->total_invoice  + $customer_details->total_return - $customer_details->total_return_paid)+ $customer_details->deposit_balance + $customer_details->added_balance + $balance_adjustment;        // print_r( $customer_details->total_return); die();
    // return ['balance' => $balance, 'points' => $customer_details->total_rp];
    // }
}
