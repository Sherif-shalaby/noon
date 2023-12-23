<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{

    protected $table = 'customers';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'email','image', 'address', 'phone','notes',
                                    'min_amount_in_dollar','max_amount_in_dollar','min_amount_in_dinar',
                                    'max_amount_in_dinar','balance_in_dollar','balance_in_dinar',
                                    'deposit_balance', 'added_balance','city_id','state_id','quarter_id',
                                    'created_by', 'deleted_by', 'updated_by', 'customer_type_id');

    // ++++++++++++++++ customer has one type ++++++++++++++++
    public function customer_type()
    {
        return $this->belongsTo('App\Models\CustomerType', 'customer_type_id');
    }

    public function customer_balance_adjustments()
    {
        return $this->hasMany('App\Models\CustomerBalanceAdjustments');
    }
    public function customer_important_dates()
    {
        return $this->hasMany(CustomerImportantDate::class);
    }
    public function createBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function wages()
    {
        return $this->hasMany('App\Models\wage');
    }
    public function updateBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function deleteBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
    public static function getCustomerArrayWithMobile()
    {
        $customers = Customer::select('id', 'name', 'phone')->get();
        $customer_array = [];
        foreach ($customers as $customer) {
            $customer_array[$customer->id] = $customer->name . ' ' . $customer->phone;
        }

        return $customer_array;
    }

    public function transactions()
    {
        return $this->hasMany(TransactionSellLine::class,'customer_id','id');
    }
}

