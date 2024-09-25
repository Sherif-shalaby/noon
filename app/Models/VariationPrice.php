<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariationPrice extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'variation_prices';

    public function customer_type()
    {
        return $this->belongsTo('App\Models\CustomerType', 'customer_type_id');
    }
}
