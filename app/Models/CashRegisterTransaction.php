<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashRegisterTransaction extends Model
{
    use HasFactory; use SoftDeletes;

    protected $guarded = ['id'];

    public function source()
    {
        return $this->belongsTo(User::class, 'source_id');
    }
    public function cash_register()
    {
        return $this->belongsTo(CashRegister::class, 'cash_register_id');
    }
}
