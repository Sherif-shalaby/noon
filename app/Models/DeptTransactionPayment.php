<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DebtTransactionPayment extends Model
{
    protected $table = 'dept_transaction_payments';
    public $timestamps = true;
    use HasFactory ,SoftDeletes;
    protected $guarded = ['id'];
}
