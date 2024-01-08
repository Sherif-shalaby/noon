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
}


