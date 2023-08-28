<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellLine extends Model
{
    use HasFactory;

    public function transaction()
    {
        return $this->belongsTo(TransactionSellLine::class,'transaction_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
