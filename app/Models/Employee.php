<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employees';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('user_id', 'store_id', 'updated_by', 'pass_string', 'employee_name', 'date_of_start_working', 'job_type_id', 'mobile', 'date_of_birth', 'annual_leave_per_year', 'sick_leave_per_year', 'payment_cycle', 'commission', 'commission_value', 'commission_type', 'commision_calculation_period', 'deleted_by', 'comissioned_products', 'comission_customer_types', 'comission_stores', 'comission_cashier', 'working_day_per_weak', 'check_in', 'check_out');

    public function job_type()
    {
        return $this->belongsTo(JobType::class, 'job_type_id');
    }

    public function stores()
    {
        return $this->belongsToMany(Store::class, 'employee_stores');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getWeekDays(){
        return [
            'sunday' => __('lang.sunday'),
            'monday' => __('lang.monday'),
            'tuesday' => __('lang.tuesday'),
            'wednesday' => __('lang.wednesday'),
            'thursday' => __('lang.thursday'),
            'friday' => __('lang.friday'),
            'saturday' => __('lang.saturday'),
        ];
    }
    public static function paymentCycle()
    {
        return [
            'daily' => 'Daily',
            'weekly' => 'Weekly',
            'monthly' => 'Monthly'
        ];
    }
    public static function commissionType()
    {
        return [
            'sales' => 'Sales',
            'profit' => 'Profit'
        ];
    }
    public static function commissionCalculationPeriod()
    {
        return [
            'daily' => 'Daily',
            'weekly' => 'Weekly',
            'one_month' => 'One Month',
            'three_month' => 'Three Month',
            'six_month' => 'Six Month',
            'one_year' => 'One Year',
        ];
    }
    public static function getDropdownByJobType($job_type, $include_superadmin = false, $return_user_id = false)
    {
        $query = Employee::with('job_type', 'user')
            ->whereHas('job_type', function ($query) use ($job_type) {
                $query->where('title', $job_type);
            })->get();
        if ($include_superadmin) {
            $query->Where('is_superadmin', 1);
        }
        if ($return_user_id) {
            $employees = $query->pluck('user.name', 'user.id');
        } else {
            $employees = $query->pluck('user.name', 'id');
        }
        return $employees->toArray();
    }
}
