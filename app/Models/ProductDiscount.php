<?php

namespace ProductDiscount;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductDiscount extends Model 
{

    protected $table = 'product_discounts';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('product_id', 'discount_type', 'discount', 'discount_start_date', 'discount_end_date', 'discount_customer_types', 'discount_customers', 'discount_category', 'is_discount_permenant', 'created_by', 'updated_by', 'deleted_by');
    protected $visible = array('created_by');

    public function product()
    {
        return $this->belongsTo('Product\Product', 'product_id');
    }

}