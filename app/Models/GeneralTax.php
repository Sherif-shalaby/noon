<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeneralTax extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "general_taxes";
    protected $fillable = ['name', 'rate', 'method', 'store_id' , 'details', 'created_by', 'deleted_by', 'updated_by'];
    public $timestamps = true;
    // soft delete
    protected $dates = ['deleted_at'];

    // ############ Relationships ############
    // M:M relationship Between "stores" , "general_taxes" table
    // 'general_taxes' can applied on many 'stores'
    public function stores()
    {
        return $this->belongsToMany('App\Models\Store','store_tax','');
    }

}
