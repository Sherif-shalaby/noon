<?php

namespace App\Utils;

use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\TransactionSellLine;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportsFilters extends Util
{
    public function productFilters(){
        $supplierIds = isset(request()->supplier_id) && is_array(request()->supplier_id)  ? array_filter(request()->supplier_id, fn ($value) => !is_null($value)) :[];
        $storeIds =  isset(request()->store_id) && is_array(request()->store_id)  ? array_filter(request()->store_id, fn ($value) => !is_null($value)) :[];
        $brand_ids = isset(request()->brand_id) && is_array(request()->brand_id) ? array_filter(request()->brand_id, fn ($value) => !is_null($value)) :[];
        $created_by_ids =  isset(request()->created_by) && is_array(request()->created_by) ? array_filter(request()->created_by, fn ($value) => !is_null($value)) :[];

        $products =  Product::
            when(\request()->stocks =="no_zero", function ($query) {
                $query->whereHas('product_stores', function ($query) {
                    $query->where('quantity_available', '>', 0);
                });
            })
            ->when(\request()->category_id != null, function ($query) {
                $query->where('category_id',\request()->category_id);
            })
            ->when(\request()->subcategory_id1 != null, function ($query) {
                $query->where('subcategory_id1',\request()->subcategory_id1);
            })
            ->when(\request()->subcategory_id2 != null, function ($query) {
                $query->where('subcategory_id2',\request()->subcategory_id2);
            })
            ->when(\request()->subcategory_id3 != null, function ($query) {
                $query->where('subcategory_id3',\request()->subcategory_id3);
            })
            ->when(\request()->branch_id != null, function ($query) {
                $branchId = \request()->branch_id;
                $query->whereHas('product_stores.store.branch', function ($storeQuery) use ($branchId) {
                    $storeQuery->where('id', $branchId);
                });
            })
            ->when(\request()->store_id != null && !empty($storeIds), function ($query) use ($storeIds) {
                $query->whereHas('product_stores', fn ($query) => $query->whereIn('store_id', $storeIds));
            })
           ->when(request()->supplier_id != null && !empty($supplierIds), function ($query) use ($supplierIds) {
               $query->whereHas('stock_lines.transaction', function ($query) use ($supplierIds) {
                   $query->whereIn('supplier_id', $supplierIds);
               });
           })
            ->when(\request()->brand_id != null && !empty($brand_ids), function ($query) {
                $query->whereIn('brand_id',\request()->brand_id);
            })
            ->when(\request()->created_by != null && !empty($created_by_ids), function ($query) {
                $query->whereIn('created_by',\request()->created_by);
            })
            ->when(request()->selling_filter != null && request()->selling_filter === 'best', function ($query) {
                $query->whereHas('sell_lines', function ($query) {
                })
                    ->withSum('sell_lines', 'quantity')
                    ->orderBy('sell_lines_sum_quantity','desc');
            })
            ->when(request()->selling_filter != null && request()->selling_filter === 'least', function ($query) {
                $query->whereHas('sell_lines', function ($query) {
                })
                    ->withSum('sell_lines', 'quantity')
                    ->orderBy('sell_lines_sum_quantity','asc');
            })
            ->when(request()->stock_filter != null && request()->stock_filter == "most", function ($query) {
                $query->whereHas('product_stores') // Add your specific condition inside whereHas if needed
                ->withSum('product_stores', 'quantity_available')
                    ->orderBy('product_stores_sum_quantity_available','desc');
            })
            ->when(request()->stock_filter != null && request()->stock_filter == "lowest", function ($query) {
                $query->whereHas('product_stores') // Add your specific condition inside whereHas if needed
                ->withSum('product_stores', 'quantity_available')
                    ->orderBy('product_stores_sum_quantity_available','asc');
            })
            ->when( request()->expiry == "nearest", function ($query) {
                $query->withCount(['stock_lines as expiry_date' => function ($subquery) {
                    $subquery->where(function ($q) {
                        $q->whereDate('expiry_date', '>', Carbon::now());
                    });
                }])->orderBy('expiry_date', 'asc');
            })
            ->when(request()->expiry == "expired", function ($query) {
                $query->withCount([
                    'stock_lines as expired_count' => function ($subquery) {
                        $subquery->whereDate('expiry_date', '<=', now());
                    }
                ])->having('expired_count', '>', 0)
                    ->orderBy('expired_count', 'desc');
            })
            ->when(request()->balance_return_request == "on", function ($query) {
                $query->whereHas('product_stores')
                    ->withSum('product_stores', 'quantity_available')
                    ->orderByRaw('(product_stores_sum_quantity_available < products.balance_return_request) DESC');
            })
            ->when(request()->stocks =="zero" , function ($query) {
                $query->whereHas('product_stores', function ($subQuery) {
                    $subQuery->selectRaw('product_id, COALESCE(SUM(quantity_available), 0) as quantity_available_sum')
                        ->groupBy('product_id')
                        ->having('quantity_available_sum', '=', 0);
                });
            })
            ->when( request()->expired == "on", function ($query) {
                $query->withCount(['stock_lines as expiry_date' => function ($subquery) {
                    $subquery->where(function ($q) {
                        $q->whereDate('expiry_date', '>', Carbon::now())
                            ->orderBy('expiry_date', 'asc');
                    });
                }]);
            })
            ->when(request()->sell_price_less_purchase_price == 'on', function ($query) {
                $query->whereHas('sell_lines', function ($subquery) {
                    $subquery->where(function ($q) {
                        $q->whereNotNull('stock_sell_price')->orWhereNotNull('stock_dollar_sell_price')
                        ->where('sell_price', '<', 'stock_sell_price')
                            ->orWhere('dollar_sell_price', '<', 'stock_dollar_sell_price');
                    });
                });
            })
            ->withCount([
                'stock_lines as total_purchase_amount' => function ($query) {
                    $query->select(DB::raw('SUM(purchase_price * quantity)'))
                        ->groupBy('product_id');
                },
            ])
            ->withCount([
                'sell_lines as total_sells_amount' => function ($query) {
                    $query->select(DB::raw('SUM(sell_price * (quantity - quantity_returned))'))
                        ->groupBy('product_id');
                },
            ])
            ->withCount([
                'stock_lines as total_dollar_purchase_amount' => function ($query) {
                    $query->select(DB::raw('SUM(dollar_purchase_price * quantity)'))
                        ->groupBy('product_id');
                },
            ])
            ->withCount([
                'sell_lines as total_dollar_sells_amount' => function ($query) {
                    $query->select(DB::raw('SUM(dollar_sell_price * (quantity - quantity_returned))'))
                        ->groupBy('product_id');
                },
            ])
            ->get();
        return $products;
    }

    public function initialBalanceFilters(){
        $stocks =  StockTransaction::whereIn('type',['initial_balance_payment','initial_balance'])
            ->when(\request()->dont_show_zero_stocks =="on", function ($query) {
                $query->whereHas('product_stores', function ($query) {
                    $query->where('quantity_available', '>', 0);
                });
            })
            ->when(\request()->category_id != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('category_id',\request()->category_id);
                });
            })
            ->when(\request()->subcategory_id1 != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('subcategory_id1',\request()->subcategory_id1);
                });
            })
            ->when(\request()->subcategory_id2 != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('subcategory_id2',\request()->subcategory_id2);
                });
            })
            ->when(\request()->subcategory_id3 != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('subcategory_id3',\request()->subcategory_id3);
                });
            })
            ->when(request()->supplier_id != null, function ($query) {
                $query->where('supplier_id',request()->supplier_id);
            })
            ->when(request()->created_by != null, function ($query) {
                $query->where('created_by',request()->created_by);
            })
            ->when(request()->product_name != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('name', 'like', '%' . request()->product_name . '%');
                });
            })
            ->when(request()->product_sku != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('sku', 'like', '%' . request()->product_sku . '%');
                });
            })
            ->when(request()->product_symbol != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('product_symbol', 'like', '%' . request()->product_symbol . '%');
                });
            })
            ->when(request()->brand_id != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('brand_id', request()->brand_id);
                });
            })
            ->when(request()->from != null, function ($query) {
                $query->whereRaw("STR_TO_DATE(transaction_date, '%Y-%m-%d') >= ?", [request()->from]);
            })
            ->when(request()->to != null, function ($query) {
                $query->whereRaw("STR_TO_DATE(transaction_date, '%Y-%m-%d') <= ?", [request()->to]);
            })
            ->orderBy('created_at', 'desc')->get();
        return $stocks;
    }

    public function addStockFilter(){
        $storeIds =  isset(request()->store_id) && is_array(request()->store_id)  ? array_filter(request()->store_id, fn ($value) => !is_null($value)) :[];

        $stocks =  StockTransaction::where('type','add_stock')
            ->when(\request()->dont_show_zero_stocks =="on", function ($query) {
                $query->whereHas('product_stores', function ($query) {
                    $query->where('quantity_available', '>', 0);
                });
            })
            ->when(\request()->category_id != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('category_id',\request()->category_id);
                });
            })
            ->when(\request()->subcategory_id1 != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('subcategory_id1',\request()->subcategory_id1);
                });
            })
            ->when(\request()->subcategory_id2 != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('subcategory_id2',\request()->subcategory_id2);
                });
            })
            ->when(\request()->subcategory_id3 != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('subcategory_id3',\request()->subcategory_id3);
                });
            })
            ->when(\request()->branch_id != null, function ($query) {
                $branchId = \request()->branch_id;
                $query->whereHas('store.branch', function ($storeQuery) use ($branchId) {
                    $storeQuery->where('id', $branchId);
                });
            })
            ->when(\request()->store_id != null && !empty($storeIds), function ($query) use ($storeIds) {
                $query->whereHas('store', fn ($query) => $query->whereIn('store_id', $storeIds));
            })
            ->when(request()->supplier_id != null, function ($query) {
                $query->where('supplier_id',request()->supplier_id);
            })
            ->when(request()->created_by != null, function ($query) {
                $query->where('created_by',request()->created_by);
            })
            ->when(request()->product_name != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('name', 'like', '%' . request()->product_name . '%');
                });
            })
            ->when(request()->product_sku != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('sku', 'like', '%' . request()->product_sku . '%');
                });
            })
            ->when(request()->product_symbol != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('product_symbol', 'like', '%' . request()->product_symbol . '%');
                });
            })
            ->when(request()->brand_id != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('brand_id', request()->brand_id);
                });
            })
            ->when(request()->purchase_type != null, function ($query) {
                $query->where('purchase_type', request()->purchase_type);
            })
            ->when(request()->payment_status != null, function ($query) {
                $query->where('payment_status', request()->payment_status);
            })
            ->when(request()->due_date != null, function ($query) {
                $query->whereRaw("STR_TO_DATE(due_date, '%Y-%m-%d') >= ?", [request()->due_date]);
            })
            ->when(request()->from != null, function ($query) {
                $query->whereRaw("STR_TO_DATE(transaction_date, '%Y-%m-%d') >= ?", [request()->from]);
            })
            ->when(request()->to != null, function ($query) {
                $query->whereRaw("STR_TO_DATE(transaction_date, '%Y-%m-%d') <= ?", [request()->to]);
            })
            ->when(request()->brand_id != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('brand_id', request()->brand_id);
                });
            })
            ->when(request()->discount == 'invoice_discount', function ($query) {
                $query->where('discount_amount', '>' ,0);
            })
            ->when(request()->discount == 'product_discount', function ($query) {
                $query->whereHas('add_stock_lines', function ($subquery) {
                    $subquery->havingRaw('SUM(discount) > 0');
                });
            })
            ->when(request()->discount == 'product_discount_percent', function ($query) {
                $query->whereHas('add_stock_lines', function ($subquery) {
                    $subquery->havingRaw('SUM(discount_percent) > 0');
                });
            })
            ->when(request()->discount == 'cash_discount', function ($query) {
                $query->whereHas('add_stock_lines', function ($subquery) {
                    $subquery->havingRaw('SUM(cash_discount) > 0');
                });
            })
            ->when(request()->discount == 'seasonal_discount', function ($query) {
                $query->whereHas('add_stock_lines', function ($subquery) {
                    $subquery->havingRaw('SUM(seasonal_discount) > 0');
                });
            })
            ->when(request()->discount == 'annual_discount', function ($query) {
                $query->whereHas('add_stock_lines', function ($subquery) {
                    $subquery->havingRaw('SUM(annual_discount) > 0');
                });
            })            
            ->orderBy('created_at', 'desc')->get();
        return $stocks;
    }

    public function bestSellerFilter(){
        $best_selling = TransactionSellLine::with('transaction_sell_lines')
            ->when(\request()->category_id != null, function ($query) {
                $query->whereHas('transaction_sell_lines.product', function ($subquery) {
                    $subquery->where('category_id',\request()->category_id);
                });
            })
            ->when(\request()->subcategory_id1 != null, function ($query) {
                $query->whereHas('transaction_sell_lines.product', function ($subquery) {
                    $subquery->where('subcategory_id1',\request()->subcategory_id1);
                });
            })
            ->when(\request()->subcategory_id2 != null, function ($query) {
                $query->whereHas('transaction_sell_lines.product', function ($subquery) {
                    $subquery->where('subcategory_id2',\request()->subcategory_id2);
                });
            })
            ->when(\request()->subcategory_id3 != null, function ($query) {
                $query->whereHas('transaction_sell_lines.product', function ($subquery) {
                    $subquery->where('subcategory_id3',\request()->subcategory_id3);
                });
            })
            ->when(\request()->branch_id != null, function ($query) {
                $branchId = \request()->branch_id;
                $query->whereHas('transaction_sell_lines.product.product_stores.store.branch', function ($storeQuery) use ($branchId) {
                    $storeQuery->where('id', $branchId);
                });
            })
            ->when(\request()->store_id != null, function ($query) {
                $query->whereHas('transaction_sell_lines.product.product_stores', function ($query) {
                    $query->where('store_id',\request()->store_id);
                });
            })
            ->when(request()->from != null, function ($query) {
                $query->whereRaw("STR_TO_DATE(transaction_date, '%Y-%m-%d') >= ?", [request()->from]);
            })
            ->when(request()->to != null, function ($query) {
                $query->whereRaw("STR_TO_DATE(transaction_date, '%Y-%m-%d') <= ?", [request()->to]);
            })
            ->when(request()->brand_id != null, function ($query) {
                $query->whereHas('transaction_sell_lines.product', function ($subquery) {
                    $subquery->where('brand_id', request()->brand_id);
                });
            })
//            ->when(request()->supplier_id != null, function ($query) {
//                $query->whereHas('transaction_sell_lines.product.stock_lines.transaction', function ($subquery) {
//                    $subquery->where('supplier_id', \request()->supplier_id);
//                });
//            })
            ->select(DB::raw('sell_lines.product_id, sum(sell_lines.quantity) as sold_qty'))
            ->join('sell_lines', 'sell_lines.transaction_id', '=', 'transaction_sell_lines.id')
            ->groupBy('sell_lines.product_id')
            ->orderBy('sold_qty', 'desc')
            ->first();
        return $best_selling;
    }
}
