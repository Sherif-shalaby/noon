<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItems extends Model
{
    use HasFactory;
    protected $fillable=['invoice_id','product_id','name','quantity','price','total','tax','category_id','department_name','unit','code'];
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
