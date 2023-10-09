<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerOfferPrice extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $guarded = [];

    public function transaction()
    {
        return $this->belongsTo(TransactionCustomerOfferPrice::class,'transaction_customer_offer_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function getDropdown()
    {
        $customers = Customer::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        return $customers;
    }
}
