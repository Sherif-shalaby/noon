<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class productTransacrionReport extends Controller
{
    public function index(Request $request)
    {
        return view('reports.productTransacrionReport.index');
    }




    public function getProductReport(Request $request)
    {

        $store = $request->input('store');
        $product = $request->input('product');
        $start_at =$request->input('start_at');
        $end_at =$request->input('end_at');
        
     

        $results = DB::table(DB::raw('(SELECT 
        sell_lines.product_id,
        sell_lines.quantity,
        products.name AS name,
        stores.name AS store_name,
        transaction_sell_lines.store_id AS store_id,
        sell_lines.created_at AS created_at,
        SUM(CASE WHEN type = "بيع" THEN -sell_lines.quantity ELSE sell_lines.quantity END) OVER (ORDER BY sell_lines.product_id, sell_lines.created_at) AS Balance,
        "بيع" AS type
                    FROM 
                        sell_lines
                    JOIN 
                        transaction_sell_lines ON sell_lines.transaction_id = transaction_sell_lines.id
                    JOIN 
                        stores ON transaction_sell_lines.store_id = stores.id
                    JOIN 
                        products ON sell_lines.product_id = products.id
                    WHERE 
                        sell_lines.product_id = ?
                        AND transaction_sell_lines.store_id = ?

                    UNION ALL

                    SELECT 
                        product_id,
                        quantity,
                        products.name,
                        stores.name AS store_name,
                        stock_transactions.store_id,
                        add_stock_lines.created_at,
                        SUM(quantity) OVER (ORDER BY product_id, add_stock_lines.created_at) AS Balance,
                        "شراء" AS type
                    FROM 
                        add_stock_lines
                    JOIN 
                        stock_transactions ON add_stock_lines.stock_transaction_id = stock_transactions.id
                    JOIN 
                        products ON add_stock_lines.product_id = products.id
                    JOIN 
                        stores ON stock_transactions.store_id = stores.id
                    WHERE 
                        product_id = ?
                        AND stock_transactions.store_id = 1) AS combined_data'))
                ->setBindings([$product, $store, $product])
                ->select('product_id', 'quantity', 'name', 'store_name', 'store_id', 'created_at', 'type')
                ->selectRaw('SUM(CASE WHEN type = "شراء" THEN quantity WHEN type = "بيع" THEN -quantity ELSE 0 END) OVER (ORDER BY created_at) AS Final_balance')
                ->orderBy('created_at')
                ->get();

//   dd($results);


                                // if ($store) {
                                // $query->where('store_id', $store);
                                // }
                                // if ($start_at || $end_at) {
                                // $query->whereBetween('created_at', [$start_at, $end_at]);
                                // }

                                // $results = $query->get();

                                return view('reports.productTransacrionReport.index', compact('results'));



  

    }

}
