<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDimension extends Model
{
    use HasFactory;
    protected $table = 'product_dimensions';
    protected $guarded = ['id'];
 
    public function product()
    {
        return $this->belongsTo('Product\Product', 'product_id');
    }

    public function variations()
    {
        return $this->belongsTo(Variation::class,'variation_id','id');
    }
}
