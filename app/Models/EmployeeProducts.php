<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeProducts extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'employee_products';
    public $timestamps = true;
    public $guarded = [];
}
