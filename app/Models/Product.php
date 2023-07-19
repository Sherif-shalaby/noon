<?php

namespace App\Models;

use App\Traits\EmployeeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model 
{

    protected $table = 'products';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name','translations', 'sku','store_id','brand_id','unit_id','category_id', 'details','details_translations','image','height', 'weight', 'length', 'width','size', 'active','created_by','edited_by','deleted_by');
    protected $casts = ['translations' => 'array',
                        'details_translations'=>'array',
                        
                        // 'store_id'=>'array',
    ];
    public function getNameAttribute($value)
    {
        if (!is_null($this->translations)) {
            if (isset($this->translations['name'][app()->getLocale()])) {
                return $this->translations['name'][app()->getLocale()];
            }
            return $value;
        }
        return $value;
    }
    public function getDetailsAttribute($value)
    {
        if (!is_null($this->details_translations)) {
            if (isset($this->details_translations['details'][app()->getLocale()])) {
                return $this->details_translations['details'][app()->getLocale()];
            }
            return $value;
        }
        return $value;
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo('App\Models\Category', 'subategory_id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand', 'brand_id');
    }
    public function unit()
    {
        return $this->belongsTo('App\Models\Unit', 'unit_id');
    }

    public function stores()
    {
        return $this->belongsToMany('App\Models\Store', 'product_stores');
    }
    public function subcategories()
    {
        return $this->belongsToMany('App\Models\Category', 'product_subcategories');
    }
    public function product_prices()
    {
        return $this->hasMany('App\Models\ProductPrice');
    }
    public function createBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updateBy()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }
    public function deleteBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}