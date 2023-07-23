<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddStockLine extends Model
{
    use HasFactory, SoftDeletes ;

    protected $guarded = ['id'];

    public function transaction()
    {
        return $this->belongsTo(StockTransaction::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
