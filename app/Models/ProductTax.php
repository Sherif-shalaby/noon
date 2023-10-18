<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductTax extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $table = "products_taxes";
    protected $guarded = [];
    public $timestamps = true;
}
