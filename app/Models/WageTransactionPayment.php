<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class WageTransactionPayment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // ++++++++++++++++++ wages_transaction_payments +++++++++++++++
    public function wages_transaction()
    {
        return $this->belongsTo(WageTransaction::class);
    }
}
