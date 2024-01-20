<?php

use App\Models\System;
use Illuminate\Support\Facades\Storage;

function store_file($file,$path)
{
    $name = time().$file->getClientOriginalName();
    $value = $file->storeAs($path, $name, 'uploads');
    return $value;
}

function delete_file($file)
{
    if($file!='' and !is_null($file) and Storage::disk('uploads')->exists($file)){
        unlink('uploads/'.$file);
    }
}

function display_file($name)
{
    return asset('uploads').'/'.$name;
}

function num_uf($input_number, $currency_details = null){
    $thousand_separator  = ',';
    $decimal_separator  = '.';
    $num = str_replace($thousand_separator, '', $input_number);
    $num = str_replace($decimal_separator, '.', $num);
    return (float)$num;
}

function round_250($input_number){
    $number = round($input_number / 250) * 250;
    return  $number;

}
function num_of_digital_numbers(){
    $num_of_digits=(System::getProperty('num_of_digital_numbers'))??2;
    return (int)$num_of_digits;

}


