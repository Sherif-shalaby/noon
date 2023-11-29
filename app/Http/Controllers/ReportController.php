<?php

namespace App\Http\Controllers;

use App\Models\StockTransaction;
use App\Models\Store;
use App\Models\TransactionSellLine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Utils\TransactionUtil;
class ReportController extends Controller
{
     /**
     * All Utils instance.
     *
     */
    protected $transactionUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct( TransactionUtil $transactionUtil)
    {
        $this->transactionUtil = $transactionUtil;
    }
    public function getMonthlySaleReport(Request $request)
    {
        // return $request->year;
        $store_id = $this->transactionUtil->getFilterOptionValues($request)['store_id'];

        $year = request()->year;

        if (empty($year)) {
            $year = Carbon::now()->year;
        }

        $start = strtotime($year . '-01-01');
        $end = strtotime($year . '-12-31');

        while ($start <= $end) {
            $start_date =  date("Y-m-d", $start);
            if(in_array(date('m', $start), [4, 6, 9, 11])){
                $end_date = $year . '-' . date('m', $start) . '-' . '30';
            } elseif (date('m', $start) == 2) {
                $end_date = $year . '-' . date('m', $start) . '-' . '29';
            } else {
                $end_date = $year . '-' . date('m', $start) . '-' . '31';
            }
            $total_sell_query = TransactionSellLine::where('type', 'sell')->where('status', 'final')->whereDate('transaction_date', '>=', $start_date)->whereDate('transaction_date', '<=', $end_date);
            if (!empty($store_id)) {
                $total_sell_query->where('store_id', $store_id);
            }
            $total_discount_sell[] = $total_sell_query->sum('discount_amount');
            //
            $total_addstock_query = StockTransaction::where('type', 'add_stock')->where('status', 'received')->whereDate('transaction_date', '>=', $start_date)->whereDate('transaction_date', '<=', $end_date)
            ->with('add_stock_lines');

            if (!empty($store_id)) {
                $total_addstock_query->where('store_id', $store_id);
            }
            $total_discount_addstock[] = $total_addstock_query->sum('discount_amount');
        
            $total_tax_sell[] = $total_sell_query->sum('total_tax');
            ///

            // $total_tax_addstock[] = $total_addstock_query->sum('total_tax');
            //
            $shipping_cost_sell[] = $total_sell_query->sum('delivery_cost');
            //
            // $shipping_cost_addstock[] = $total_addstock_query->sum('delivery_cost');
            ///

            $total_sell[] = $total_sell_query->sum('final_total');

            //
            $total_addstock[] = $total_addstock_query->sum('final_total');
            $term=$total_sell_query->with('transaction_sell_lines');
                $total_net_profit[] = $term->get()
                ->sum(function ($transaction) {
                    return $transaction->transaction_sell_lines->sum(function ($line) {
                        return $line->sell_price * ($line->quantity - $line->quantity_returned);
                    });
                })- ($term->get()
                ->sum(function ($transaction) {
                    return $transaction->transaction_sell_lines->sum(function ($line) {
                        return $line->purchase_price * ($line->quantity - $line->quantity_returned);
                    });
                }));
            $start = strtotime("+1 month", $start);
        }
        $stores = Store::getDropdown();
        ///////

        return view('reports.sales-report.monthly_sale_report', compact(
            'year',
            'total_discount_sell',
            'total_tax_sell',
            'shipping_cost_sell',
            'total_sell',
            'stores',
            'total_discount_addstock',
            // 'total_tax_addstock',
            // 'shipping_cost_addstock',
            'total_addstock',
            'total_net_profit',
            // 'total_p'
        ));
    }
}
