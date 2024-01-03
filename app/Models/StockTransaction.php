<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockTransaction extends Model
{
    use HasFactory, SoftDeletes;
    protected $appends = ['source_name'];
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'commissioned_employees' => 'array'
    ];


    public function add_stock_lines()
    {
        return $this->hasMany(AddStockLine::class);
    }
    public function add_stock_variations()
    {
        return $this->hasManyThrough(Product::class, AddStockLine::class, 'transaction_id', 'id', 'id', 'variation_id');
    }

    public function add_stock_products()
    {
        return $this->hasManyThrough(Product::class, AddStockLine::class, 'stock_transaction_id', 'id', 'id', 'product_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id')->withDefault(['name' => '']);
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }
    public function transaction_payments()
    {
        return $this->hasMany(StockTransactionPayment::class);
    }

    public function add_stock_parent()
    {
        return $this->hasOne(StockTransaction::class, 'add_stock_id');
    }


    public function source()
    {
        return $this->belongsTo(User::class, 'source_id')->withDefault(['name' => '']);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    public function created_by_relationship()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function paying_currency_relationship()
    {

        return $this->belongsTo(Currency::class, 'transaction_currency');
    }
    public function parentTransaction()
    {
        // Assuming the foreign key is 'return_parent_id'
        return $this->belongsTo(StockTransaction::class, 'parent_transction');
    }

    // Define a relationship to retrieve all child transactions
    public function childTransactions()
    {
        // Assuming the foreign key is 'return_parent_id'
        return $this->hasMany(StockTransaction::class, 'parent_transction');
    }
    public function getSourceNameAttribute()
    {

    }

    public function received_discount()
    {
        return $this->hasMany(ReceiveDiscount::class , 'stock_transaction_id');
    }

}
