<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceiveDiscount extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = array('stock_transaction_id','discount_type','amount','amount_dollar','change','change_dollar','received_amount','received_amount_dollar','created_by');
}
