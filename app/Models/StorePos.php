<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StorePos extends Model
{
    use HasFactory; use SoftDeletes;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault(['name' => '']);
    }

    public function store()
    {
        return $this->belongsTo(Store::class)->withDefault(['name' => '']);
    }
}
