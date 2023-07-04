<?php

namespace Store;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model 
{

    protected $table = 'stores';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'location', 'phone_number', 'email', 'manager_name', 'manager_mobile_number', 'details', 'created_by', 'deleted_by', 'updated_by');

    public function products()
    {
        return $this->belongsToMany('Product\Product', 'product_stores');
    }

    public function customer_balance_adjustments()
    {
        return $this->hasMany('CustomerBalanceAdjustments\CustomerBalanceAdjustments');
    }

    public function exchange_rate()
    {
        return $this->hasMany('ExchangeRates\ExchangeRates');
    }

}