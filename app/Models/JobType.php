<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobType extends Model
{

    protected $table = 'job_types';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('title', 'date_of_creation', 'created_by', 'deleted_by', 'updated_by');

    public function employess()
    {
        return $this->hasMany('Employee\Employee');
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
