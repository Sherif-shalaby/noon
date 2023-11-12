<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryLocation extends Model
{
    protected $table = 'delivery_locations';
    public $timestamps = true;
    use HasFactory ,SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = array('date', 'signed_at', 'submitted_at','customers',
                                    'city_id','delivery_id',
                                    'created_by', 'deleted_by', 'updated_by');


    public function employee()
    {
        return $this->belongsTo(Employee::class, 'delivery_id','id');
    }

    public function city()
    {
        return $this->hasOne(City::class, 'id','city_id');
    }
    public function customers_plan(){
        return $this->hasMany(DeliveryCustomerPlan::class, 'delivery_location_id','id');
    }
}
