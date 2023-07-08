<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model 
{

    protected $table = 'categories';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'description');

    public function class()
    {
        return $this->belongsTo('Class\Class', 'class_id');
    }

    public function products()
    {
        return $this->hasMany('Product\Product');
    }

}