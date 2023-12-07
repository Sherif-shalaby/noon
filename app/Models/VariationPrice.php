<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariationPrice extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'variation_prices';
}
