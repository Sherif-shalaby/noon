<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequiredProduct extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    public $timestamps = true;

    // ++++++++++++++++++++ stores ++++++++++++++++++++
    public function stores()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
    // ++++++++++++++++++++ user ++++++++++++++++++++
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // ++++++++++++++++++++ branch ++++++++++++++++++++
    public function branch()
    {
        return $this->belongsTo(Branch::class,'branch_id');
    }
    // ++++++++++++++++++++ supplier ++++++++++++++++++++
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    // ++++++++++++++++++++ employees ++++++++++++++++++++
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    // ++++++++++++++++++++ product ++++++++++++++++++++
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    // ++++++++++++++++++++ createBy ++++++++++++++++++++
    public function createBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    // ++++++++++++++++++++ updateBy ++++++++++++++++++++
    public function updateBy()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }
    // ++++++++++++++++++++ deleteBy ++++++++++++++++++++
    public function deleteBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

}
