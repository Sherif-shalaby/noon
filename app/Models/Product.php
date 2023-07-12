<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model 
{

    protected $table = 'products';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'sku', 'details', 'height', 'weight', 'length', 'width', 'active');

    public function class()
    {
        return $this->belongsTo('Class\Class', 'class_id');
    }

    public function category()
    {
        return $this->belongsTo('Category\Category', 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo('Category\Category', 'subategory_id');
    }

    public function brand()
    {
        return $this->belongsTo('Brand\Brand', 'brand_id');
    }

    public function stores()
    {
        return $this->belongsToMany('Store\Store', 'product_stores');
    }

}