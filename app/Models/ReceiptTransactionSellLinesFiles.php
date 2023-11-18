<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptTransactionSellLinesFiles extends Model
{
    use HasFactory;
    protected $table = 'receipt_transaction_sell_lines_files';

    protected $fillable = array('transaction_sell_line_id','path');

    public function transaction()
    {
        return $this->belongsTo(TransactionSellLine::class,'transaction_sell_line_id');
    }

}
