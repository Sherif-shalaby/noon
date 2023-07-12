<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerType extends Model 
{

    protected $table = 'customer_types';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'deleted_by', 'created_by', 'updated_by');

    public function customer()
    {
        return $this->hasMany('Customer\Customer');
    }

}