<?php

namespace Employee;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model 
{

    protected $table = 'employees';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('user_id', 'store_id', 'updated_by', 'pass_string', 'employee_name', 'date_of_start_working', 'job_type_id', 'mobile', 'date_of_birth', 'annual_leave_per_year', 'sick_leave_per_year', 'payment_cycle', 'commission', 'commission_value', 'commission_type', 'commision_calculation_period', 'deleted_by', 'comissioned_products', 'comission_customer_types', 'comission_stores', 'comission_cashier', 'working_day_per_weak', 'check_in', 'check_out');

    public function job_type()
    {
        return $this->belongsTo('JobType', 'job_type_id');
    }

    public function store()
    {
        return $this->belongsTo('Store\Store', 'store_id');
    }

}