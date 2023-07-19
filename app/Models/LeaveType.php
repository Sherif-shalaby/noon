<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveType extends Model
{
    use HasFactory;
    protected $table = 'leave_types';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'number_of_days_per_year', 'date_of_creation', 'created_by', 'deleted_by', 'updated_by');

    public function created_by()
    {
        return $this->hasMany(User::class,'id');
    }
    public function updated_by()
    {
        return $this->belongsTo(User::class,'id');
    }
    public function deleted_by()
    {
        return $this->belongsTo(User::class,'id');
    }
}
