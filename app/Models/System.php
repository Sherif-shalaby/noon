<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use HasFactory;
    protected $table = 'systems';
    public $timestamps = true;
    protected $fillable = array('key', 'vale', 'date_and_time','created_by');

}
