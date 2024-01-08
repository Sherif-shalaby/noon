<?php

namespace App\Utils;

use App\Models\CashRegister;
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
}


