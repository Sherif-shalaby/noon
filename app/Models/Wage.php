<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wage extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];
    protected $table = 'wages';
    public static function getPaymentTypes()
    {
        return [
            'salary' => __('lang.salary'),
            'paid_leave' => __('lang.paid_leave'),
            'paid_annual_leave' => __('lang.paid_annual_leave'),
            'commission' => __('lang.commission'),
            'annual_bonus' => __('lang.annual_bonus'),
            'annual_incentive' => __('lang.annual_incentive'),
            'recognition' =>  __('lang.recognition'),
            'other_reward' =>  __('lang.other_reward')
        ];
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class)->withDefault(['employee', '']);
    }
    public function wage_transaction()
    {
        return $this->hasOne(WageTransaction::class);
    }
    public function createBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updateBy()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }
    // ++++++++++++++++++++++++ paymentCycle() ++++++++++++++++++++++++
    public static function paymentCycle()
    {
        return [
            '1' => 'daily',
            '2' => 'weekly',
            '3' => 'monthly'
        ];
    }
}
