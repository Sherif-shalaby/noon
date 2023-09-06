<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderLine extends Model
{
    use HasFactory;
    protected $table = "purchase_order_lines";
    protected $guarded = ['id'];
    public $timestamps = true;
    // soft delete
    protected $dates = ['deleted_at'];

    public function transaction()
    {
        return $this->belongsTo(PurchaseOrderTransaction::class,'purchase_transaction_id',);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
