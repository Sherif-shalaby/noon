<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseTransaction extends Model
{
    use HasFactory;
    public function expense_category()
    {
        return $this->belongsTo(ExpenseCategory::class)->withDefault(['name' => '']);
    }
    public function expense_beneficiary()
    {
        return $this->belongsTo(ExpenseBeneficiary::class)->withDefault(['name' => '']);
    }
}
