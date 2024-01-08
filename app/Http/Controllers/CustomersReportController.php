<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AddStockLine;
use App\Models\CashRegisterTransaction;
use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\PaymentTransactionSellLine;
use App\Models\Product;
use App\Models\SellLine;
use App\Models\Store;
use App\Models\StorePos;
use App\Models\TransactionSellLine;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Utils\ProductUtil;
use App\Utils\TransactionUtil;
use App\Utils\Util;
use Illuminate\Support\Facades\Log;

class CustomersReportController extends Controller
{
    protected $commonUtil;
    protected $transactionUtil;
    protected $productUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(Util $commonUtil, ProductUtil $productUtil, TransactionUtil $transactionUtil)
    {
        $this->commonUtil = $commonUtil;
        $this->productUtil = $productUtil;
        $this->transactionUtil = $transactionUtil;
    }
    /* ++++++++++++++++++ index() +++++++++++++++++ */
    public function index()
    {

        $stores = Store::getDropdown();
        $store_pos = StorePos::orderBy('name', 'asc')->pluck('name', 'id');
        $products = Product::orderBy('name', 'asc')->pluck('name', 'id');
        $customer_types = CustomerType::orderBy('name', 'asc')->pluck('name', 'id');
        $customers = Customer::orderBy('name', 'asc')->pluck('name', 'id');
        $users = User::orderBy('name', 'asc')->pluck('name', 'id');
        $payment_status_array = $this->commonUtil->getPaymentStatusArray();
        $customer_transactions_sell_lines = TransactionSellLine::with('transaction_sell_lines.product', 'transaction_payments', 'customer')
        ->when(\request()->customer_id != null, function ($query) {
                $query->where('customer_id',\request()->customer_id);
        })
        ->when(\request()->store_id != null, function ($query) {
            $query->where('store_id',\request()->store_id);
        })
        ->when(\request()->pos_id != null, function ($query) {
            $query->where('store_pos_id',\request()->pos_id);
        })
        ->when(\request()->product_id != null, function ($query) {
            $query->whereHas('transaction_sell_lines', function ($query) {
                $query->where('product_id',\request()->product_id);
            });
        })
        ->when(\request()->created_by != null, function ($query) {
            $query->where('created_by',\request()->created_by);
        })
        ->when(\request()->payment_status != null, function ($query) {
            $query->where('payment_status',\request()->payment_status);
        })
        ->when(\request()->start_date != null, function ($query) {
            $query->whereDate('transaction_date', '>=', request()->start_date);
        })
        ->when(\request()->end_date != null, function ($query) {
            $query->whereDate('transaction_date', '>=', request()->start_date);
        })
        ->when(\request()->start_time != null, function ($query) {
            $query->whereDate('transaction_date', '>=', request()->start_date);
        })
        ->when(\request()->end_time != null, function ($query) {
            $query->whereDate('transaction_date', '<=', request()->start_date);
        })
        ->latest()->get();
        return view('reports.customers-report.index', compact('customer_transactions_sell_lines', 'store_pos',
        'products',
        'customers',
        'stores',
        'customer_types',
        'payment_status_array','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $transaction = TransactionSellLine::find($id);

            DB::beginTransaction();

            $transaction_sell_lines = SellLine::where('transaction_id', $id)->get();
            $transaction_sell_payments = PaymentTransactionSellLine::where('transaction_id', $id)->get();

            foreach ($transaction_sell_lines as $transaction_sell_line) {
                if ($transaction->status == 'final') {
                    $product = Product::find($transaction_sell_line->product_id);
                    if (!$product->is_service) {
                        $this->productUtil->updateProductQuantityStore($transaction_sell_line->product_id, $transaction_sell_line->variation_id, $transaction->store_id, $transaction_sell_line->quantity - $transaction_sell_line->quantity_returned);
                        if (isset($transaction_sell_line->stock_line_id)) {
                            $stock = AddStockLine::where('id', $transaction_sell_line->stock_line_id)->first();
                            $stock->update([
                                'quantity_sold' =>  $stock->quantity - $transaction_sell_line->quantity
                            ]);
                        }
                    }
                }
                $transaction_sell_line->delete();
            }

            $return_ids = TransactionSellLine::where('return_parent_id', $id)->pluck('id');



            TransactionSellLine::where('return_parent_id', $id)->delete();
            TransactionSellLine::where('parent_sale_id', $id)->delete();

            CashRegisterTransaction::wherein('transaction_id', $return_ids)->delete();

            $transaction->delete();
            CashRegisterTransaction::where('transaction_id', $id)->delete();

            DB::commit();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }

        return $output;
    }
}
