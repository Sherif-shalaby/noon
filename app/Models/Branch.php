<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = 'branches';
    public $timestamps = true;



    protected $dates = ['deleted_at'];
    protected $fillable = array('name','type','sell_car_id','deleted_by','edited_by','created_by');

    public function sell_car()
    {
        return $this->belongsTo(SellCar::class);
    }
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
    public function stores()
    {
        return $this->hasMany(Store::class);
    }
    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault(['name' => '']);
    }
    public function updated_by_user()
    {
        return $this->belongsTo(User::class, 'updated_by')->withDefault(['name' => '']);
    }

}
