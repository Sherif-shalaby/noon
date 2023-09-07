<?php

namespace App\Models;

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
        return $this->belongsToMany('App\Models\Product', 'product_stores');
    }
    public function customer_balance_adjustments()
    {
        return $this->hasMany('App\Models\CustomerBalanceAdjustments');
    }

    public function exchange_rate()
    {
        return $this->hasMany('App\Models\ExchangeRates');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_stores');
    }


    public static function getDropdown()
    {
        $user = auth()->user();
        if ($user->is_superadmin || $user->is_admin) {
            $stores = Store::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        } else {
            $employee = $user->employee;
            $stores = $employee->stores()->orderBy('name','asc')->pluck('name','id')->toArray();
        }
        return $stores;
    }


    public function customer_types()
    {
        return $this->hasMany('App\Models\CustomerType');
    }
    public function moneysafe()
    {
        return $this->hasMany('App\Models\MoneySafe');
    }
    // ############ Relationships ############
    // M:M relationship Between "stores" , "general_taxes" table
    // 'stores' can has on many 'general_taxes'
    public function general_taxes()
    {
        return $this->belongsToMany('App\Models\GeneralTax','store_tax');
    }
}
