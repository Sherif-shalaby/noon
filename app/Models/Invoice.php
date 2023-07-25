<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\EmployeeTrait;
class Invoice extends Model
{
    use HasFactory,EmployeeTrait;
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
    public function createBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function updateBy()
    {
        return $this->belongsTo(User::class, 'last_update');
    }
}
