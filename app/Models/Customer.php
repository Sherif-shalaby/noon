<?php

namespace Customer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model 
{

    protected $table = 'customers';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'email', 'address', 'phone', 'deposit_balance', 'added_balance', 'created_by', 'deleted_by', 'updated_by', 'customer_type_id');

    public function customer_type()
    {
        return $this->belongsTo('CustomerType\CustomerType', 'customer_type_id');
    }

    public function customer_balance_adjustments()
    {
        return $this->hasMany('CustomerBalanceAdjustments\CustomerBalanceAdjustments');
    }

}