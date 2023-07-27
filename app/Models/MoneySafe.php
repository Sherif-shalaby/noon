<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MoneySafe extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];
    protected $table = 'money_safes';


    public function getLatestBalanceAttribute()
    {
        $latestTransaction = $this->transactions()->latest()->first();

        if ($latestTransaction) {
            return $latestTransaction->balance;
        }

        return 0;
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class,'currency_id');
    }
    public function store()
    {
        return $this->belongsTo(Store::class,'store_id');
    }
    public function createBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updateBy()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }
    public function transactions()
    {
        return $this->hasMany('App\Models\MoneySafeTransaction');
    }
}
