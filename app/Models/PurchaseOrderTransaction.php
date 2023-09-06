<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderTransaction extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = true;
    // soft delete
    protected $dates = ['deleted_at'];

    // +++++++++++++++++ transaction_purchase_order_lines() Relationship +++++++++++++++++
    public function transaction_purchase_order_lines()
    {
        return $this->hasMany(PurchaseOrderLine::class,'transaction_id','id');
    }
    // +++++++++++++++++ transaction_purchase_order_line() Relationship +++++++++++++++++
    public function transaction_purchase_order_line()
    {
        return $this->hasOne(PurchaseOrderLine::class);
    }
    // +++++++++++++++++ customer() Relationship +++++++++++++++++
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id')->withDefault(['name' => '']);
    }
    // +++++++++++++++++ store() Relationship +++++++++++++++++
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id')->withDefault(['name' => '']);
    }
}
