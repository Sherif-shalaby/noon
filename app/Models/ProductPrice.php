<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{

    protected $table = 'product_prices';
    public $timestamps = true;

    protected $dates = ['deleted_at'];
    protected $fillable = array('stock_line_id','price_type','bonus_quantity','quantity','price', 'price_customer_types', 'price_customers', 'price_category', 'created_by', 'updated_by', 'deleted_by');
    protected $casts =['price_customer_types'=>'array'];

    public function product()
    {
        return $this->belongsTo('Product\Product', 'product_id');
    }
    public function stock_lines()
    {
        return $this->hasMany(AddStockLine::class,'add_stock_line','id');
    }

}
