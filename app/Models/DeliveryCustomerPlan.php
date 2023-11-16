<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryCustomerPlan extends Model
{
    protected $table = 'delivery_customer_plans';
    public $timestamps = true;
    use HasFactory ,SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = array('signed_at', 'submitted_at',
                                   'customers_id','delivery_location_id',
                                    'created_by', 'deleted_by', 'updated_by');

    public function customers()
    {
        return $this->hasOne(Customer::class, 'id','customers_id');
    }
    public function delivery_location(){
        return $this->belongsTo(DeliveryLocation::class);
    }
}
