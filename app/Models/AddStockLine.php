<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddStockLine extends Model
{
    use HasFactory, SoftDeletes ;

    protected $guarded = ['id'];

    public function transaction()
    {
        // return $this->belongsTo(StockTransaction::class,'stock_transaction_id ','id');
        return $this->belongsTo(StockTransaction::class,'stock_transaction_id',);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function variation()
    {
        return $this->belongsTo(Variation::class,'variation_id');
    }
    public function prices()
    {
        return $this->hasMany(ProductPrice::class, 'stock_line_id', 'id');
    }
    public function variation_stocklines()
    {
        return $this->hasMany(VariationPrice::class, 'variation_price_id', 'id');
    }

}
