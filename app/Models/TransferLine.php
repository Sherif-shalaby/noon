<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferLine extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function transaction()
    {
        return $this->belongsTo(TransferTransaction::class,'transaction_id ','id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }
}
