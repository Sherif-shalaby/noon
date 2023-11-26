<?php

namespace App\Http\Livewire\ProductOptions;

use App\Models\AddStockLine;
use App\Models\Product;
use App\Models\ProductExpiryDamage;
use App\Models\ProductStore;
use App\Models\Variation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RemoveExpiry extends Component
{
    public $productId = null, $rows = [], $addStockLines = [];
    public function render()
    {


        return view('livewire.product-options.remove-expiry');
    }
    public function mount($productId)
    {
        $this->productId = $productId;
        $this->addStockLines = AddStockLine::where("add_stock_lines.product_id", $this->productId)
            ->where("add_stock_lines.quantity", ">", 0)
            ->leftjoin('variations', function ($join) {
                $join->on('add_stock_lines.variation_id', 'variations.id')->whereNull('variations.deleted_at');
            });
        $store_query = '';
        $this->addStockLines = $this->addStockLines->select(
            'add_stock_lines.*',
            'add_stock_lines.expiry_date as exp_date',
            'add_stock_lines.created_at as date_of_purchase_of_the_expired_stock_removed',
            'add_stock_lines.purchase_price as add_stock_line_purchase_price',
            'add_stock_lines.purchase_price as add_stock_line_avg_purchase_price',
            'variations.sku',
            DB::raw('(SELECT SUM(add_stock_lines.quantity)  FROM add_stock_lines  JOIN variations as v ON add_stock_lines.variation_id=v.id WHERE v.id=variations.id ' . $store_query . '  ) as avail_current_stock'),
            DB::raw('(SELECT AVG(add_stock_lines.purchase_price) FROM add_stock_lines JOIN variations as v ON add_stock_lines.variation_id=v.id WHERE v.id=variations.id ' . $store_query . ') as avg_purchase_price'),
            DB::raw('(add_stock_lines.quantity - add_stock_lines.quantity_sold) as expired_current_stock'),
        )->get();
        $this->addRow($this->addStockLines);
    }
    public function addRow($addStockLines)
    {
        foreach ($addStockLines as $stockLine) {
            $new_row = [
                'variation_id' => $stockLine->variation_id,
                'stock_line_id' => $stockLine->id,
                'quantity_to_remove' => '',
                'status' => 'expiry',
            ];
            $this->rows[] = $new_row;
        }
    }
    public function save()
    {
        // dd($this->rows);
        foreach ($this->rows as $data) {
            $stockRow = AddStockLine::find($data["stock_line_id"]);
            $variation = Variation::find($data["variation_id"]);
            $stockRow->decrement("quantity", $data["quantity_to_remove"]);
            $store = ProductStore::where("variation_id", $variation->id)->where("product_id", $variation->product_id)->first();
            $this->decreaseProductQuantity($variation->product_id, $variation->id, $store->store_id, $data["quantity_to_remove"]);
            if ($data["quantity_to_remove"] > 0) {
                $productExpiry = ProductExpiryDamage::query()->create([
                    "status" => $data["status"],
                    "product_id" => $variation->product_id,
                    "variation_id" => $variation->id,
                    "quantity_of_expired_stock_removed" => $data["quantity_to_remove"],
                    "date_of_purchase_of_expired_stock_removed" => now(),
                    "value_of_removed_stocks" => $data["value_of_removed_stocks"],
                    "added_by" => auth()->id(),
                ]);
                //    $expenses_category = ExpenseCategory::where('name','Expiry')->orWhere('name','expiry')->first();
                //     if(!$expenses_category){
                //         $expenses_category = ExpenseCategory::create([
                //             'name' => 'Expiry',
                //             'created_by' => 1
                //         ]);
                //     }
                // $expenses_beneficiary = ExpenseBeneficiary::where('name','expiry products')->first();
                // if(!$expenses_beneficiary){
                //     $expenses_beneficiary = ExpenseBeneficiary::create([
                //         'name' => 'expiry products',
                //         'expense_category_id' => $expenses_category->id,
                //         'created_by' => 1,
                //     ]);
                // }

                // Transaction::create([
                //     'grand_total' => $this->commonUtil->num_uf($request->total_shortage_value),
                //     'final_total' => $this->commonUtil->num_uf($request->total_shortage_value),
                //     'store_id' => $store->store_id,
                //     'type' => 'expense',
                //     'status' => 'final',
                //     'invoice_no' => $this->productUtil->getNumberByType('expense'),
                //     'transaction_date' =>$productExpiry->created_at,
                //     'expense_category_id' => $expenses_category->id,
                //     'expense_beneficiary_id' => $expenses_beneficiary->id,
                //     'source_id' => 1,
                //     'source_type' => 'store',
                //     'created_by' => auth()->id(),
                // ]);
            }
        }
    }
    public function decreaseProductQuantity($product_id, $variation_id, $store_id, $new_quantity, $old_quantity = 0)
    {
        $qtyByUnit = Variation::find($variation_id)->number_vs_base_unit == 0 ? 1 : Variation::find($variation_id)->number_vs_base_unit;
        $qty_difference = ($qtyByUnit ? $qtyByUnit * $new_quantity : $new_quantity) - $old_quantity;
        $product = Product::find($product_id);

        //Check if stock is enabled or not.
        if ($product->is_service != 1) {
            //Decrement Quantity in variations store table
            $details = ProductStore::where('variation_id', $variation_id)
                ->where('product_id', $product_id)
                ->where('store_id', $store_id)
                ->first();

            //If store details not exists create new one
            if (empty($details)) {
                $details = ProductStore::create([
                    'product_id' => $product_id,
                    'store_id' => $store_id,
                    'variation_id' => $variation_id,
                    'quantity_available' => 0
                ]);
            }

            $details->decrement('quantity_available', $qty_difference);
        }

        return true;
    }
}
