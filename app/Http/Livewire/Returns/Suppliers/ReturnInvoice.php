<?php

namespace App\Http\Livewire\Returns\Suppliers;

use Exception;
use App\Models\Store;
use App\Models\Branch;
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

class ReturnInvoice extends Component
{
    public $id, $stocklines = [], $quantity = [], $amount, $stock_return, $store,
            $branches,$branch_id,$store_pos,$return_quantity=[],$final_total = [],
            $method, $paid_on, $notes,$stock, $transaction_stock_line_id = [] ,
            $payment_status,$payment , $store_pos_id ;

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
        $this->branches =  Branch::where('type','branch')->orderBy('created_at', 'desc')->pluck('name','id');
        // $this->branch_id = Store::where('id', $this->sale->store_id)->pluck('branch_id');
        $this->branch_id = Store::where('id', $this->stock->store_id)->value('branch_id');
        $this->store_pos = StorePos::orderBy('name', 'asc')->pluck('name', 'id');
        // dd($this->stocklines);

        // +++++++++++ add stock lines table +++++++++++
        foreach ($this->stocklines as $key => $product)
        {
            $this->transaction_stock_line_id[$key] = $product->id;
            if(!empty($product->quantity_returned)){
                $this->quantity[$key] = number_format($product->quantity_returned,2);
            }
            else{
                $this->quantity[$key] = number_format(0,2);
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

        return view('livewire.returns.suppliers.return-invoice',
                    compact('payment_status_array','payment_type_array',
                'sellPriceTotal','finalPriceTotal'));
    }
    // ++++++++++++++++ store() ++++++++++++++++
    public function store()
    {
        DB::beginTransaction();
        try
        {
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
                'notes' => $this->notes ,
                'created_by' => Auth::user()->id
            ];
            // if "stock transaction" doesn't exist previously then create it now
            if (empty($stock_return))
            {
                $stock_return = StockTransaction::create($transaction_data);
            }
            else
            {
                $stock_return->final_total = $this->num_uf($this->amount);
                $stock_return->grand_total = $this->num_uf($this->amount);
                $stock_return->status = 'final';
                $stock_return->notes = $this->notes;
                $stock_return->save();
            }
            // dd("Before add_stock_line table ");
            // ++++++++++++++++++++ add_stock_line table ++++++++++++++++++++
            foreach ($this->stocklines as $key => $stock_line)
            {
                if (!empty($this->transaction_stock_line_id[$key]))
                {

                    $line = AddStockLine::find($this->transaction_stock_line_id[$key]);
                    $old_quantity = $line->quantity;
                    $line->quantity_returned = $this->return_quantity[$key];
                    $line->save();
                    $product = Product::find($line->product_id);
                    // if (!$product->is_service)
                    // {
                        $this->updateProductQuantityStore($line->product_id, $stock_return->store_id, $stock_line['quantity'], $old_quantity);
                        if(isset($line->stock_line_id))
                        {
                            $stock = AddStockLine::where('id',$line->stock_line_id)->first();
                            $stock->update([
                                'quantity' =>  $stock->quantity + $old_quantity,
                                'quantity_sold' =>  $stock->quantity - $old_quantity
                            ]);
                        }
                    // }
                }
            }
            // dd("After add_stock_line table ");
            DB::commit();

            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        }
        catch (Exception $e)
        {
            dd($e);
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }
        return redirect()->to('/stock/return/invoices')->with('status', $output);
    }
    // +++++++++ updateProductQuantityStore() : substitute "return_quantity" of "product" from "product_store" +++++++++
    public function updateProductQuantityStore($product_id, $variation_id, $store_id, $new_quantity, $old_quantity = 0)
    {
        $qty_difference = $new_quantity - $old_quantity;

        // if ($qty_difference != 0)
        // {
            $product_store = ProductStore::where('product_id', $product_id)
                                        ->where('store_id', $store_id)
                                        ->first();
            // dd($product_store);
            if (empty($product_store))
            {
                $product_store = new ProductStore();
                $product_store->product_id = $product_id;
                $product_store->store_id = $store_id;
                $product_store->quantity_available = 0;
            }

            $product_store->quantity_available += $qty_difference;
            $product_store->save();
        // }

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
        $formattedSellPriceTotal = number_format($sellPriceTotal, 4);

        return $formattedSellPriceTotal;
    }
    // +++++++++ finalPriceTotal() +++++++++
    public function finalPriceTotal()
    {
        // Calculate the total final price from the 'final_total' array
        $finalPriceTotal = array_sum($this->final_total);
        // If you want to format the total, use number_format
        $formattedFinalPriceTotal = number_format($finalPriceTotal, 4);
        return $formattedFinalPriceTotal;
    }

}
