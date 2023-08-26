<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionSellLine extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function transaction_sell_lines()
    {
        return $this->hasMany(SellLine::class);
    }

    public function transaction_sell_line()
    {
        return $this->hasOne(SellLine::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id')->withDefault(['name' => '']);
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id')->withDefault(['name' => '']);
    }

    public function transaction_payments()
    {
        return $this->hasMany(PaymentTransactionSellLine::class);
    }

    public function transaction_currency()
    {

        return $this->belongsTo(Currency::class, 'transaction_currency');
    }
}
