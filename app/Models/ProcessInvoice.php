<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessInvoice extends Model
{
    use HasFactory;
    protected $table = 'process_invoices';
    protected $guarded = [];

    public function transaction()
    {
        return $this->belongsTo(TransactionSellLine::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
