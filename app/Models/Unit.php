<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\EmployeeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
class Unit extends Model
{
    use HasFactory, EmployeeTrait, SoftDeletes;
    protected $table = 'units';
    protected $guarded = [];
    protected $casts = ['translation' => 'array'];

    //attr ********************************************************************************************************
    public function getNameAttribute($value)
    {
        if (!is_null($this->translation)) {
            if (isset($this->translation['name'][app()->getLocale()])) {
                return $this->translation['name'][app()->getLocale()];
            }
            return $value;
        }
        return $value;
    }
    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
    public function createBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function updateBy()
    {
        return $this->belongsTo(User::class, 'last_update');
    }
}
