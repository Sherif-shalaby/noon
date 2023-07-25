<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockTransactionPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $casts = [
        'cashes_amount'=>'array'
    ];
    public function source()
    {
        return $this->belongsTo(User::class, 'source_id')->withDefault(['name' => '']);
    }

    public function transaction()
    {
        return $this->belongsTo(StockTransaction::class);
    }
    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by', 'id')
            ->withDefault(['name' => '']);
    }
}
