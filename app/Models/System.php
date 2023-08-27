<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class System extends Model
{
    use HasFactory;


    protected $table = 'systems';
    public $timestamps = true;


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
    public static function getLanguageDropdown()
    {
        $config_languages = config('constants.langs');
        $languages = [];
        foreach ($config_languages as $key => $value) {
            $languages[$key] = $value['full_name'];
        }

        return $languages;
    }


}
