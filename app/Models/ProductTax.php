<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductTax extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "product_taxes";
    protected $fillable = ['name', 'rate','status','details', 'created_by', 'deleted_by', 'updated_by'];
    public $timestamps = true;
    // soft delete
    protected $dates = ['deleted_at'];
}
