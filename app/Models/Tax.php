<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tax extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "taxes";
    protected $guarded = [];
    public $timestamps = true;

    public function products()
    {
        return $this->belongsToMany('App\Models\Product','products');
    }
    // soft delete
    protected $dates = ['deleted_at'];
}
