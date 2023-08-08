<?php

namespace App\Utils;

use App\Models\Employee;
use App\Models\MoneySafe;
use App\Models\MoneySafeTransaction;
use App\Models\System;

class MoneySafeUtil extends Util
{
    public function updatePayment($transaction, $payment_data, $type, $transaction_payment_id = null, $old_tp = null, $money_safe  = null)
    {
        if (empty($money_safe)) {
            $money_safe = MoneySafe::where('store_id', $transaction->store_id)->where('type', 'bank')->first();
            if (empty($money_safe)) {
                $money_safe = MoneySafe::where('is_default', 1)->first();
            }
        }

        if (!empty($old_tp)) {
            if (($old_tp->method == 'card' || $old_tp->method == 'bank_transfer') && $payment_data['method'] == 'cash') {
                MoneySafeTransaction::where('transaction_payment_id', $transaction_payment_id)->delete();
            }
        }

        if ($transaction->type == 'sell') {

            if ($payment_data['method'] == 'bank_transfer' || $payment_data['method'] == 'card') {
                $money_safe_transaction = MoneySafeTransaction::where('transaction_payment_id', $transaction_payment_id)->first();
                if (empty($money_safe_transaction)) {
                    $money_safe_transaction = new MoneySafeTransaction();

                    $employee = Employee::where('user_id', auth()->user()->id)->first();

                    if (!empty($employee)) {
                        $money_safe_transaction->source_id = $employee->id;
                        $money_safe_transaction->job_type_id = $employee->job_type_id;
                        $money_safe_transaction->source_type = 'employee';
                    }
                }

                if (!empty($money_safe)) {
                    $money_safe_transaction->money_safe_id = $money_safe->id;
                    $money_safe_transaction->transaction_date = $transaction->transaction_date;
                    $money_safe_transaction->transaction_id = $transaction->id;
                    $money_safe_transaction->transaction_payment_id = $transaction_payment_id;
                    $money_safe_transaction->currency_id = $transaction->received_currency_id;
                    $money_safe_transaction->type = $type;
                    $money_safe_transaction->store_id = $transaction->store_id;
                    $money_safe_transaction->amount = $this->num_uf($payment_data['amount']);
                    $money_safe_transaction->created_by = $transaction->created_by;

                    $money_safe_transaction->save();
                }
            }
        }

        if ($transaction->type == 'add_stock' || $transaction->type == 'expense' || $transaction->type == 'wages_and_compensation') {
            $old_ms_transaction = MoneySafeTransaction::where('transaction_id', $transaction->id)->first();
            if($old_ms_transaction){
                if ($old_ms_transaction->money_safe_id != $money_safe->id) {
                    MoneySafeTransaction::where('transaction_id', $transaction->id)->delete();
                }
            }


            $default_currency_id = (int) System::getProperty('currency');
            $money_safe_transactions = MoneySafeTransaction::where('transaction_payment_id', $transaction_payment_id)->get();
            $total_paid_amount_base = 0;
            foreach ($money_safe_transactions as $mst) {
                $coverted_amount_base = $this->convertCurrencyAmount($mst->amount, $mst->currency_id, $default_currency_id, $transaction->store_id);
                $total_paid_amount_base += $coverted_amount_base;
            }
            $total_amount_base = $this->convertCurrencyAmount($transaction->final_total, $transaction->paying_currency_id, $default_currency_id, $transaction->store_id);
            $remaing_amount_base = $total_amount_base - $total_paid_amount_base;
            $remaing_amount = $this->convertCurrencyAmount($remaing_amount_base, $default_currency_id, $transaction->paying_currency_id, $transaction->store_id);

            $exchange_rate_currencies =  $this->getCurrenciesExchangeRateArray(true);


            if ($remaing_amount > 0) {
                if ($transaction->type == 'add_stock') {
                    $currency_id = $transaction->paying_currency_id;
                    $data['comments'] = __('lang.add_stock');
                }
                if ($transaction->type == 'expense') {
                    $currency_id = $payment_data['currency_id'];
                    $data['comments'] = __('lang.expense');
                }
                if ($transaction->type == 'wages_and_compensation') {
                    $currency_id = $payment_data['currency_id'];
                    $data['comments'] = __('lang.wages_and_compensation');
                }
                $amount = $this->num_uf($remaing_amount);
                $data['money_safe_id'] = $money_safe->id;
                $data['transaction_date'] = $transaction->transaction_date;
                $data['transaction_id'] = $transaction->id;
                $data['transaction_payment_id'] = $transaction_payment_id;
                $data['currency_id'] = $currency_id;
                $data['type'] = $type;
                $data['store_id'] = $transaction->store_id;
                $data['amount'] = $amount;
                $data['created_by'] = $transaction->created_by;
                $data['source_id'] = null;


                $safe_balance = $this->getSafeBalance($money_safe->id, $currency_id);
                if ($safe_balance > $amount) {
                    $data['amount'] = $amount;
                    $amount = 0;
                    MoneySafeTransaction::create($data);
                } elseif ($safe_balance < $amount && $safe_balance > 0) {
                    $data['amount'] = $safe_balance;
                    $amount -= $safe_balance;
                    MoneySafeTransaction::create($data);
                }
                unset($exchange_rate_currencies[$currency_id]); // remove from array if balance is zero
                foreach ($exchange_rate_currencies as $key => $currency) {
                    $amount_to_debit = 0;
                    if ($amount > 0) {
                        $safe_balance = $this->getSafeBalance($money_safe->id, $key);
                        $converted_amount = $this->convertCurrencyAmount($amount, $currency_id, $key, $transaction->store_id);
                        if ($safe_balance >= $converted_amount) {
                            $amount_to_debit = $converted_amount;
                            $amount = 0;
                        } else {
                            $amount_to_debit = $safe_balance;
                            $revert_amount = $this->convertCurrencyAmount($safe_balance, $key, $currency_id, $transaction->store_id);
                            $amount = $amount - $revert_amount;
                        }

                        $data['currency_id'] = $key;
                        $data['amount'] = $amount_to_debit;
                        if ($data['amount'] > 0) {
                            MoneySafeTransaction::create($data);
                        }
                    }
                }
            } else {
                $amount = abs($remaing_amount);

                foreach ($money_safe_transactions as $money_safe_transaction) {
                    if ($amount > 0) {
                        $amount_to_base = $this->convertCurrencyAmount($amount, $transaction->paying_currency_id, $default_currency_id, $transaction->store_id);
                        $mst_amount_base = $this->convertCurrencyAmount($money_safe_transaction->amount, $money_safe_transaction->currency_id, $default_currency_id, $transaction->store_id);
                        if ($mst_amount_base <= $amount_to_base) {
                            $money_safe_transaction->delete();

                            $remaing_base = $amount_to_base - $mst_amount_base;
                            $remaing = $this->convertCurrencyAmount($remaing_base, $default_currency_id, $transaction->paying_currency_id, $transaction->store_id);
                            $amount = $remaing;
                        } else {
                            $money_safe_transaction->amount -= $this->convertCurrencyAmount($amount_to_base, $default_currency_id, $money_safe_transaction->currency_id, $transaction->store_id);
                            $money_safe_transaction->save();
                            $amount = 0;
                        }
                    }
                }
            }
        }



        return true;
    }

}
