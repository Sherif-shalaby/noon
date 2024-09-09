<?php

namespace App\Http\Livewire\Returns\Suppliers;

use Exception;
use App\Models\Store;
use App\Models\Branch;
use App\Models\System;
use App\Models\Product;
use Livewire\Component;
use App\Models\StorePos;
use App\Models\AddStockLine;
use App\Models\ProductStore;
use Illuminate\Support\Carbon;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\StockTransactionPayment;

class ReturnInvoice extends Component
{
    public $id, $stocklines = [], $quantity = [], $amount, $stock_return, $store,
        $branches, $branch_id, $store_pos, $return_quantity = [], $final_total = [],
        $method, $paid_on, $notes, $stock, $transaction_stock_line_id = [],
        $payment_status, $payment, $store_pos_id, $notify_before_days, $bank_name, $bank_deposit_date,
        $ref_number, $upload_documents, $payment_date,
        $paymentStatus, $partial_paid_flag = 0, $paid_flag = 0, $paid_later_flag = 0;

    protected $rules = [
        'return_quantity.*' => 'required|numeric',
        'stocklines.*.sell_price' => 'required|numeric',
        // Add more validation rules as needed
    ];
    // +++++++++ __construct() +++++++++
    public function __construct($id)
    {
        $this->id = $id;
    }
    // +++++++++ mount() +++++++++
    public function mount()
    {
        $this->stock = StockTransaction::find($this->id);
        $this->stocklines = $this->stock->add_stock_lines;
        $this->store = $this->stock->store_id;
        $this->branches =  Branch::where('type', 'branch')->orderBy('created_at', 'desc')->pluck('name', 'id');
        // $this->branch_id = Store::where('id', $this->sale->store_id)->pluck('branch_id');
        $this->branch_id = Store::where('id', $this->stock->store_id)->value('branch_id');
        $this->store_pos = StorePos::orderBy('name', 'asc')->pluck('name', 'id');
        // dd($this->stocklines);

        // +++++++++++ add stock lines table +++++++++++
        foreach ($this->stocklines as $key => $product) {
            $this->transaction_stock_line_id[$key] = $product->id;
            if (!empty($product->quantity_returned)) {
                $this->quantity[$key] = number_format($product->quantity_returned, num_of_digital_numbers());
            } else {
                $this->quantity[$key] = number_format(0, num_of_digital_numbers());
            }
        }
        // dd($this->transaction_stock_line_id);

    }
    // +++++++++ render() +++++++++
    public function render()
    {
        $payment_status_array =  [
            'partial' => __('lang.partially_paid'),
            'paid' => __('lang.paid'),
            'pending' => __('lang.pay_later'),
        ];
        $payment_type_array = [
            'cash' => __('lang.cash'),
        ];
        // calculate the total of "sell price"
        $sellPriceTotal = $this->sellPriceTotal();
        // calculate the total of "final price"
        $finalPriceTotal = $this->finalPriceTotal();

        $this->dispatchBrowserEvent('componentRefreshed');

        return view(
            'livewire.returns.suppliers.return-invoice',
            compact(
                'payment_status_array',
                'payment_type_array',
                'sellPriceTotal',
                'finalPriceTotal'
            )
        );
    }
    // +++++++++++++++++++++ store() +++++++++++++++++++++
    public function store()
    {
        DB::beginTransaction();
        try {
            // =================== stock_transaction table ========================
            $stock_return = StockTransaction::where('type', 'sell_return')
                ->where('id', $this->id)
                ->first();
            $transaction_data =
                [
                    'store_id' => $this->store,
                    'customer_id' => $this->stock->customer_id,
                    'id' => $this->stock->id, // no
                    'type' => 'sell_return',
                    // 'transaction_currency' => $this->sale->transaction_currency,
                    'final_total' => $this->num_uf($this->final_total),
                    'grand_total' => $this->num_uf($this->final_total),
                    'transaction_date' => Carbon::now(),
                    'invoice_no' => $this->createReturnTransactionInvoiceNoFromInvoice($this->stock->invoice_no),
                    // 'status' => 'final',
                    'payment_status' => 'pending',
                    'is_return' => 1,
                    'notify_before_days' => !empty($this->notify_before_days) ? $this->notify_before_days : 0,
                    'due_date' => !empty($this->due_date) ? $this->due_date : null,
                    'notes' => !empty($this->notes) ? $this->notes : null,
                    'created_by' => !empty(Auth::user()->id) ? Auth::user()->id : null
                ];
            // if "stock transaction" doesn't exist previously then create it now
            if (empty($stock_return)) {
                $stock_return = StockTransaction::create($transaction_data);
            } else {
                $stock_return->final_total = $this->num_uf($this->amount);
                $stock_return->grand_total = $this->num_uf($this->amount);
                $stock_return->status = 'final';
                $stock_return->notes = $this->notes;
                $stock_return->save();
            }
            // dd("Before add_stock_line table ");
            // =================== add_stock_line table ========================
            foreach ($this->stocklines as $key => $stock_line) {
                if (!empty($this->transaction_stock_line_id[$key])) {
                    $line = AddStockLine::find($this->transaction_stock_line_id[$key]);
                    $old_quantity = $line->quantity;
                    $line->quantity_returned = $this->return_quantity[$key];
                    $line->save();
                    $this->updateProductQuantityStore($line->product_id, $stock_return->store_id, $line->quantity_returned, $old_quantity);
                    if (isset($line->stock_line_id)) {
                        $stock = AddStockLine::where('id', $line->stock_line_id)->first();
                        $stock->update([
                            'quantity' => $old_quantity - $line->quantity_returned,
                            'quantity_returned' => $line->quantity_returned,
                        ]);
                    }
                }
            }
            // =================== stock_transaction_payment table ===================
            if ($this->payment_status == 'partial') {
                $payment_data = [
                    'stock_transaction_id' => !empty($stock_return->id) ? $stock_return->id : '',
                    'amount' => $this->amount,
                    'method' => $this->method,
                    'paid_on' => $this->paid_on,
                    'ref_number' => $this->ref_number,
                    // 'exchange_rate' => '132',
                    'exchange_rate' => System::getProperty('dollar_exchange'),
                    'due_date' => !empty($this->due_date) ? $this->due_date : null,
                    'notify_before_days' => !empty($this->notify_before_days) ? $this->notify_before_days : null,
                    'created_by' => !empty(Auth::user()->id) ? Auth::user()->id : null
                ];
                $transaction_payment = StockTransactionPayment::create($payment_data);
                $transaction_payment->save();
            }
            // ++++++++++++++++++++ payment_status ++++++++++++++++++++
            elseif ($this->payment_status == 'paid') {
                $payment_data = [
                    'stock_transaction_id' => !empty($stock_return->id) ? $stock_return->id : '',
                    'amount' => $this->amount,
                    'method' => $this->method,
                    // 'exchange_rate' => '132',
                    'exchange_rate' => System::getProperty('dollar_exchange'),
                    'paid_on' => $this->paid_on,
                    'created_by' => !empty(Auth::user()->id) ? Auth::user()->id : null
                ];
                $transaction_payment = StockTransactionPayment::create($payment_data);
                $transaction_payment->save();
            }
            // ++++++++++++++++++++ payment_status ++++++++++++++++++++
            elseif ($this->payment_status == 'pending') {
                $payment_data = [
                    'stock_transaction_id' => !empty($stock_return->id) ? $stock_return->id : '',
                    // 'exchange_rate' => '132',
                    'exchange_rate' => System::getProperty('dollar_exchange'),
                    'due_date' => !empty($this->due_date) ? $this->due_date : null,
                    'notify_before_days' => !empty($this->notify_before_days) ? $this->notify_before_days : null,
                    'created_by' => !empty(Auth::user()->id) ? Auth::user()->id : null
                ];
                $transaction_payment = StockTransactionPayment::create($payment_data);
                $transaction_payment->save();
            }
            DB::commit();

            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (Exception $e) {
            dd($e);
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }
        return redirect()->to('/stock/return/invoices')->with('status', $output);
    }
    // +++++++++++++++++++++ "updatePaymentStatus" +++++++++++++++++++++
    public function updatePaymentStatus()
    {
        if ($this->paymentStatus === "paid" || $this->paymentStatus === "partial") {
            $this->emit('togglePaymentFields', true);
            $this->emit('toggleDueFields', true);
        } elseif ($this->paymentStatus === "pending" || $this->paymentStatus === "partial") {
            $this->emit('togglePaymentFields', false);
            $this->emit('toggleDueFields', true);
        }

        if ($this->paymentStatus === "pending") {
            $this->emit('updateRequiredAttributes', false);
        }
        if ($this->paymentStatus === "paid") {
            $this->emit('toggleDueFields', false);
        }
    }
    // +++++++++ updateProductQuantityStore() : substitute "return_quantity" of "product" from "product_store" +++++++++
    public function updateProductQuantityStore($product_id, $store_id, $new_quantity, $old_quantity = 0)
    {

        $qty_difference = $new_quantity - $old_quantity;
        $product_store = ProductStore::where('product_id', $product_id)
            ->where('store_id', $store_id)
            ->first();
        if (empty($product_store)) {
            $product_store                      = new ProductStore();
            $product_store->product_id          = $product_id;
            $product_store->store_id            = $store_id;
            $product_store->quantity_available  = 0;
        }
        $product_store->quantity_available += $qty_difference;
        $product_store->save();
    }
    // +++++++++ num_uf() +++++++++
    public function num_uf($input_number, $currency_details = null)
    {
        $thousand_separator  = ',';
        $decimal_separator  = '.';

        $num = str_replace($thousand_separator, '', $input_number);
        $num = str_replace($decimal_separator, '.', $num);

        return (float)$num;
    }
    // +++++++++ createReturnTransactionInvoiceNoFromInvoice() +++++++++
    public function createReturnTransactionInvoiceNoFromInvoice($transaction_invoice_number)
    {
        $number_only = substr($transaction_invoice_number, 3);

        return 'RetsInv' . $number_only;
    }
    // +++++++++ calculateTotals() +++++++++
    public function calculateTotals($index)
    {
        // if (isset($this->return_quantity[$index]))
        // {
        $quantity = (float)($this->return_quantity[$index]);
        $sellPrice = (float)($this->stocklines[$index]['sell_price']) ?? 0;
        $amount = $quantity * $sellPrice;
        $this->final_total[$index] = sprintf('%.4f', $amount);
        // }
    }
    // +++++++++ sellPriceTotal() +++++++++
    public function sellPriceTotal()
    {
        // Calculate the total sell price from the 'stocklines' array
        $sellPriceTotal = collect($this->stocklines)->pluck('sell_price')->sum();

        // If you want to format the total, use number_format
        $formattedSellPriceTotal = number_format($sellPriceTotal, num_of_digital_numbers());

        return $formattedSellPriceTotal;
    }
    // +++++++++ finalPriceTotal() +++++++++
    public function finalPriceTotal()
    {
        // Calculate the total final price from the 'final_total' array
        $finalPriceTotal = array_sum($this->final_total);
        // If you want to format the total, use number_format
        $formattedFinalPriceTotal = number_format($finalPriceTotal, num_of_digital_numbers());
        return $formattedFinalPriceTotal;
    }
}
