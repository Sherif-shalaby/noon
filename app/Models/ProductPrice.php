<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model 
{

    protected $table = 'product_prices';
    public $timestamps = true;

    protected $dates = ['deleted_at'];
    protected $fillable = array('product_id','price_type','bonus_quantity','quantity','price','price_start_date', 'price_end_date', 'price_customer_types', 'price_customers', 'price_category', 'is_price_permenant', 'created_by', 'updated_by', 'deleted_by');
    // protected $visible = array('created_by');
    protected $casts =['price_customer_types'=>'array'];
    public function product()
    {
        return $this->belongsTo('Product\Product', 'product_id');
    }

}