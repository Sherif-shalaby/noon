<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransactionSellLine extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Get transaction
     */
    public function transaction()
    {
        return $this->belongsTo(TransactionSellLine::class, 'transaction_id', 'id');
    }
    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id')->withDefault(['name' => '']);
    }
    public function received_currency_relation()
    {
        return $this->belongsTo(Currency::class, 'received_currency');
    }

}
