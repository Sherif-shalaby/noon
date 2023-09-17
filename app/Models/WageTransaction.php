<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WageTransaction extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function source()
    {
        return $this->belongsTo(User::class, 'source_id')->withDefault(['name' => '']);
    }
    // +++++++++++++++ Relationship : employees and wage_transactions
    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_col_id');
    }
    public function wages_relationship()
    {
        return $this->hasMany(Wage::class);
    }
    // ++++++++++++++++++ wages_transaction_payments +++++++++++++++
    public function transaction_payments()
    {
        return $this->hasMany(WageTransactionPayment::class,'transaction_id');
    }
}
