<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class)->withDefault(['name' => '']);
    }
    // public function transaction()
    // {
    //     return $this->belongsTo(Transaction::class);
    // }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id')->withDefault(['name' => '']);
    }
}
