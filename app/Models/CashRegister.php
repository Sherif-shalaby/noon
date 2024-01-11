<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashRegister extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Get the Cash registers transactions.
     */
    public function cash_register_transactions()
    {
        return $this->hasMany(CashRegisterTransaction::class);
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cash_given()
    {
        if ($this->source_type == 'safe') {
            return $this->belongsTo(MoneySafe::class, 'cash_given_to')->withDefault(['name' => '']);
        }
        return $this->belongsTo(User::class, 'cash_given_to')->withDefault(['name' => '']);
    }
    public function store_pos()
    {
        return $this->belongsTo(StorePos::class, 'store_pos_id')->withDefault(['name' => '']);
    }
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id')->withDefault(['name' => '']);
    }
    // ++++++++++++++++++++++++++++++++++ Task : Cash Relationships ++++++++++++++++++++++++++++++++++
    /* ======== cashRegisterTransactions() : Get the Cash registers transactions ======== */
    public function cashRegisterTransactions()
    {
        return $this->hasMany(CashRegisterTransaction::class);
    }
    /* ======== getTotalSaleAttribute() : Get the total sale for the cash register ======== */
    public function getTotalSaleAttribute()
    {
        return $this->cashRegisterTransactions()
            ->where('transaction_type', 'sell')
            ->sum('amount');
    }
    /* ======== getTotalDiningInAttribute() : Get the total dining in for the cash register ======== */
    public function getTotalDiningInAttribute()
    {
        return $this->cashRegisterTransactions()
            ->where('transaction_type', 'sell')
            ->where('type', 'credit')
            // ->whereNotNull('dining_table_id')
            ->sum('amount');
    }
    /* ======== getTotalDiningInCashAttribute() : Get the total dining in cash for the cash register. ======== */
    public function getTotalDiningInCashAttribute()
    {
        return $this->cashRegisterTransactions()
            ->where('transaction_type', 'sell')
            ->where('type', 'credit')
            // ->whereNotNull('dining_table_id')
            ->where('pay_method', 'cash')
            ->sum('amount');
    }
    /* ======== getTotalCashSalesAttribute() : Get the total cash sales for the cash register. ======== */
    public function getTotalCashSalesAttribute()
    {
        return $this->cashRegisterTransactions()
            ->where('transaction_type', 'sell')
            ->where('type', 'credit')
            ->where('pay_method', 'cash')
            ->sum('amount');
    }
    /* ======== getTotalRefundCashAttribute() : Get the total refund cash for the cash register. ======== */
    public function getTotalRefundCashAttribute()
    {
        return $this->cashRegisterTransactions()
            ->where('transaction_type', 'refund')
            ->where('type', 'debit')
            ->where('pay_method', 'cash')
            ->sum('amount');
    }
    /* ======== getTotalCardSalesAttribute() : Get the total card sales for the cash register ======== */
    public function getTotalCardSalesAttribute()
    {
        return $this->cashRegisterTransactions()
            ->where('transaction_type', 'sell')
            ->where('type', 'credit')
            ->where('pay_method', 'card')
            ->sum('amount');
    }
    /* ======== getTotalWagesAndCompensationAttribute() : Get the total wages and compensation for the cash register. */
    public function getTotalWagesAndCompensationAttribute()
    {
        return $this->cashRegisterTransactions()
            ->where('transaction_type', 'wages_and_compensation')
            ->where('type', 'debit')
            ->where('pay_method', 'cash')
            ->sum('amount');
    }

}
