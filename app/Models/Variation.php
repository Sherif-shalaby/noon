<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variation extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];
    protected $table = 'variations';

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }
    public function variation_equals()
    {
        return $this->hasMany('App\Models\VariationEquals');
    }
    public function unit()
    {
        return $this->belongsTo('App\Models\Unit', 'unit_id');
    }
    public function basic_unit()
    {
        return $this->belongsTo('App\Models\Unit', 'basic_unit_id');
    }
    public function stock_lines()
    {
        return $this->hasMany(AddStockLine::class,'variation_id');
    }
    public function prices()
    {
        return $this->hasMany(VariationPrice::class,'variation_id');
    }
}
