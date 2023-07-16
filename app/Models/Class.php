<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Class extends Model 
{

    protected $table = 'classes';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'description');

    public function categories()
    {
        return $this->hasMany('Category\Category');
    }


}