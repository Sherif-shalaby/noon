<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'customer_id', 'date', 'price', 'discount', 'tax', 'total',
    'payment_method', 'status', 'card', 'cash', 'refund', 'refund_status', 'rest'];
    public function scopeUnpaid($q)
    {
        return $q->where('status', 'unpaid');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function items()
    {
        return $this->hasMany(InvoiceItems::class);
    }
}
