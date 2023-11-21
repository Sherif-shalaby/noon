<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobType extends Model
{
    use HasRoles;
    protected $guard_name = 'web'; // Specify the guard here
    protected $table = 'job_types';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('title', 'date_of_creation', 'created_by', 'deleted_by', 'updated_by');

    public function employess()
    {
        return $this->hasMany('App\Models\Employee');
    }
    public function money_safe_transaction()
    {
        return $this->hasMany('App\Models\MoneySafeTransaction');
    }
    public function created_by()
    {
        return $this->belongsTo(User::class,'created_by');
    }
    public function updated_by()
    {
        return $this->belongsTo(User::class,'updated_by');
    }
    public function deleted_by()
    {
        return $this->belongsTo(User::class,'deleted_by');
    }
}
