<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExchangeRates extends Model 
{

    protected $table = 'exchange_rates';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('store_id', 'receved_currency_id', 'conversion_rate', 'default_currency_id', 'expiery_date', 'created_by', 'updated_by', 'deleted_by');

    public function receved_currency()
    {
        return $this->belongsTo('Currency\Currency', 'receved_curruncy_id');
    }

    public function store()
    {
        return $this->belongsTo('Store\Store', 'store_id');
    }

    public function default_currency()
    {
        return $this->belongsTo('Currency\Currency', 'default_currency_id');
    }

}