<?php

namespace App\Utils;

use App\Models\ProductPrice;

class pos extends Util
{
    public function quantityAvailable($product){
        $quantity_available = $product->stock_lines->sum('quantity') - $product->stock_lines->sum('quantity_sold');
        return $quantity_available;
    }

    public function getProductDiscount($pid){
        $product  = ProductPrice::where('product_id', $pid);
        if(isset($product)){
            $product->where(function($query){
                $query->where('price_start_date','<=',date('Y-m-d'));
                $query->where('price_end_date','>=',date('Y-m-d'));
                $query->orWhere('is_price_permenant',"1");
            })->get();

        }
//            dd($product->get());
        return $product->get();
    }

    public function getCurrentStock($product){
        $product_stocklines = $product->stock_lines;
        foreach ($product_stocklines as $stockline){
            $quantity_available =  $stockline->quantity - $stockline->quantity_sold  + $stockline->quantity_returned;
            if($quantity_available > 0)
            {
                return $stockline;
            }
        }
        return null;

    }

    public function getProductExchangeRate($current_stock){
        $exchange_rate = $current_stock->transaction()->get()->first()->transaction_payments->last()->exchange_rate;
        return $exchange_rate;
    }

    public function getProductPrice($stock,$exchange_rate){
        if(!empty($stock->dollar_sell_price))
            $price = $stock->dollar_sell_price * $exchange_rate;
        else
            $price = $stock->sell_price;
        return number_format($price, 2);
    }
}
