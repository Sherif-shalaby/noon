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
    protected $fillable = array('name', 'email', 'address', 'phone', 'deposit_balance', 'added_balance', 'created_by', 'deleted_by', 'updated_by', 'customer_type_id');

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

    public function updateBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function deleteBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}