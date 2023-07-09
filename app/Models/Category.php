<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable=['name','parent_id'];
    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public static function parents()
    {
        return self::whereNull('parent_id')->get();
    }
    // public $timestamps = true;

    // use SoftDeletes;
    // protected $dates = ['deleted_at'];
    // protected $fillable = array('name', 'description');

    // public function class()
    // {
    //     return $this->belongsTo('Class\Class', 'class_id');
    // }

    // public function products()
    // {
    //     return $this->hasMany('Product\Product');
    // }

}
