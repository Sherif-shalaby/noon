<?php

namespace App\Utils;

use App\Models\CashRegister;
use App\Models\CashRegisterTransaction;
use App\Models\StorePos;
use App\Models\Transaction;
use App\Notifications\PurchaseOrderToSupplierNotification;
use Notification;

class CashRegisterUtil extends Util
{
    public function countOpenedRegister()
    {
        $user_id = auth()->user()->id;
        $count =  CashRegister::where('user_id', $user_id)
            ->where('status', 'open')
            ->count();
        return $count;
    }

    public function createCashRegisterTransaction($register, $amount,$dollar_amount, $transaction_type, $type, $source_id, $notes, $referenced_id = null)
    {
        $cash_register_transaction = CashRegisterTransaction::create([
            'cash_register_id' => $register->id,
            'amount' => $amount,
            'dollar_amount' => $dollar_amount,
            'pay_method' => 'cash',
            'type' => $type,
            'transaction_type' => $transaction_type,
            'source_id' => $source_id,
            'referenced_id' => $referenced_id,
            'notes' => $notes,
        ]);

        return $cash_register_transaction;
    }
    public function getCurrentCashRegisterOrCreate($user_id)
    {
        $register =  CashRegister::where('user_id', $user_id)
            ->where('status', 'open')
            ->first();

        if (empty($register)) {
            $store_pos = StorePos::where('user_id', $user_id)->first();
            $register = CashRegister::create([
                'user_id' => $user_id,
                'status' => 'open',
                'store_id' => !empty($store_pos) ? $store_pos->store_id : null,
                'store_pos_id' => !empty($store_pos) ? $store_pos->id : null
            ]);
        }

        return $register;
    }
    public function getCurrentCashRegister($user_id)
    {
        $register =  CashRegister::where('user_id', $user_id)
            ->where('status', 'open')
            ->first();

        return $register;
    }
    public function addPayments($transaction, $payment, $type = 'credit', $user_id = null, $transaction_payment_id = null,$pay_off=null)
    {
        if (empty($user_id)) {
            $user_id = auth()->user()->id;
        }
        $register =  $this->getCurrentCashRegisterOrCreate($user_id);

        if ($transaction->type == 'sell_return') {
            $cr_transaction = CashRegisterTransaction::where('transaction_id', $transaction->id)->first();
            if (!empty($cr_transaction)) {
                $cr_transaction->update([
                    'amount' => $this->num_uf($payment['amount']),
                    'dollar_amount' => $this->num_uf($payment['dollar_amount']),
                    'pay_method' => $payment['method'],
                    'type' => $type,
                    'transaction_type' =>($pay_off==null)?$transaction->type:'pay_off',
                    'transaction_id' => $transaction->id,
                    'transaction_payment_id' => $transaction_payment_id
                ]);

                return true;
            } else {
                CashRegisterTransaction::create([
                    'cash_register_id' => $register->id,
                    'amount' => $this->num_uf($payment['amount']),
                    'dollar_amount' => $this->num_uf($payment['dollar_amount']),
                    'pay_method' =>  $payment['method'],
                    'type' => $type,
                    'transaction_type' => ($pay_off==null)?$transaction->type:'pay_off',
                    'transaction_id' => $transaction->id,
                    'transaction_payment_id' => $transaction_payment_id
                ]);
                return true;
            }
        } else {
            $payments_formatted[] = new CashRegisterTransaction([
                'amount' => $this->num_uf($payment['amount']),
                'dollar_amount' => $this->num_uf($payment['dollar_amount']),
                'pay_method' => $payment['method'],
                'type' => $type,
                'transaction_type' =>($pay_off==null)?$transaction->type:'pay_off',
                'transaction_id' => $transaction->id,
                'transaction_payment_id' => $transaction_payment_id
            ]);
        }


        //add to cash register pos return amount as sell amount
        if (!empty($pos_return_transactions)) {
            $payments_formatted[0]['amount'] = $payments_formatted[0]['amount'] + !empty($pos_return_transactions) ? $this->num_uf($pos_return_transactions->final_total) : 0;
            $payments_formatted[0]['dollar_amount'] = $payments_formatted[0]['dollar_amount'] + !empty($pos_return_transactions) ? $this->num_uf($pos_return_transactions->dollar_final_total) : 0;
        }

        if (!empty($payments_formatted) && !empty($register)) {
            $register->cash_register_transactions()->saveMany($payments_formatted);
        }

        return true;
    }
}


