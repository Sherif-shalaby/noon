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
}
