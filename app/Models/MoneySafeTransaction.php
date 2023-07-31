<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MoneySafeTransaction extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];
    protected $table = 'money_safe_transactions';


    public function currency()
    {
        return $this->belongsTo(Currency::class,'currency_id');
    }
    public function store()
    {
        return $this->belongsTo(Store::class,'store_id');
    }
    public function source()
    {
        return $this->belongsTo(User::class, 'source_id')->withDefault(['name' => '']);
    }
    public function createBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updateBy()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }
     public function moneysafe()
    {
        return $this->belongsTo(MoneySafe::class,'money_safe_id');
    }
    public function job_type()
    {
        return $this->belongsTo(JobType::class, 'job_type_id');
    }
}
