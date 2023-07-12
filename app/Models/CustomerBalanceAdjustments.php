<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerBalanceAdjustments extends Model 
{

    protected $table = 'customer_balance_adjustments';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('customer_id', 'store_id', 'current_balance', 'add_new_balance', 'new_balance', 'notes', 'date_and_time', 'created_by', 'deleted_by', 'updated_by');

    public function customers()
    {
        return $this->belongsTo('Customer\Customer', 'customer_id');
    }

    public function stores()
    {
        return $this->belongsTo('Store\Store', 'store_id');
    }

}