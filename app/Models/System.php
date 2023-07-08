<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class System extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'systems';
    public $timestamps = true;


    protected $dates = ['deleted_at'];
    protected $fillable = array('key', 'value', 'date_and_time', 'created_by', 'deleted_by', 'updated_by');


    public static function getProperty($key = null)
    {
        $row = System::where('key', $key)
            ->first();

        if (isset($row->value)) {
            return $row->value;
        } else {
            return null;
        }
    }


}
