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
    protected $fillable = array('name','translations','store_id' ,'deleted_by', 'created_by', 'updated_by');
    protected $casts = ['translations' => 'array'];
    public function getNameAttribute($value)
    {
        if (!is_null($this->translations)) {
            if (isset($this->translations['name'][app()->getLocale()])) {
                return $this->translations['name'][app()->getLocale()];
            }
            return $value;
        }
        return $value;
    }
    public function customer()
    {
        return $this->hasMany('Customer\Customer');
    }

    public function stores()
    {
        return $this->belongsTo('App\Models\Store', 'store_id');
    }
    public function createBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updateBy()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }
    public function deleteBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

}
