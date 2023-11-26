<?php

namespace App\Utils;

use App\Models\Employee;
use App\Models\System;

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
}
