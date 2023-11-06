<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferTransaction extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function transaction_transfer_lines()
    {

        return $this->hasMany(TransferLine::class,'transaction_id','id');
    }

    public function sender_store()
    {
        return $this->belongsTo(Store::class, 'sender_store_id', 'id')->withDefault(['name' => '']);
    }
    public function receiver_store()
    {
        return $this->belongsTo(Store::class, 'receiver_store_id', 'id')->withDefault(['name' => '']);
    }

    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault(['name' => '']);
    }
}
