<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductStore extends Model
{

    protected $table = 'product_stores';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('product_id', 'store_id', 'quantity_available', 'quantity_expired', 'deleted_by', 'block_quantity', 'variation_id', 'created_by', 'updated_by');

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variations()
    {
        return $this->belongsTo(Variation::class, 'variation_id', 'id');
    }

    public function Store()
    {
        return $this->belongsTo(Store::class);
    }
}
