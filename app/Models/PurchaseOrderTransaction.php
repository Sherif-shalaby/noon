<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseOrderTransaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    public $timestamps = true;
    // soft delete
    protected $dates = ['deleted_at'];

    // +++++++++++++++++ transaction_purchase_order_line() Relationship +++++++++++++++++
    public function transaction_purchase_order_lines()
    {
        return $this->hasMany(PurchaseOrderLine::class);
    }
    // +++++++++++++++++ customer() Relationship +++++++++++++++++
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id')->withDefault(['name' => '']);
    }
    // +++++++++++++++++ supplier() Relationship +++++++++++++++++
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id')->withDefault(['name' => '']);
    }
    // +++++++++++++++++ store() Relationship +++++++++++++++++
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id')->withDefault(['name' => '']);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
