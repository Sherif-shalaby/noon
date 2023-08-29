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
}
