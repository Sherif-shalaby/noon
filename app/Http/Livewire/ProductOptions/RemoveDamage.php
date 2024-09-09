<?php

namespace App\Http\Livewire\ProductOptions;

use App\Models\AddStockLine;
use App\Models\Product;
use App\Models\ProductExpiryDamage;
use App\Models\ProductStore;
use App\Models\Variation;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RemoveDamage extends Component
{
    public $productId = null, $rows = [], $addStockLines = [], $quantity_of_damaged_stock_removed = 0;
    public function render()
    {
        $this->dispatchBrowserEvent('componentRefreshed');


        return view('livewire.product-options.remove-damage');
    }
    public function changeStockRemovedValue($i)
    {
        $this->rows[$i]['quantity_of_damaged_stock_removed'] = (float)$this->rows[$i]['quantity_to_remove'] * (float)$this->rows[$i]['avg_purchase_price'];
    }
    public function mount($productId)
    {
        $this->addStockLines = AddStockLine::where("add_stock_lines.product_id", $this->productId)
            ->where("add_stock_lines.quantity", ">", 0)
            ->leftjoin('variations', function ($join) {
                $join->on('add_stock_lines.variation_id', 'variations.id')->whereNull('variations.deleted_at');
            });
        $store_query = '';
        $this->addStockLines = $this->addStockLines->select(
            'add_stock_lines.*',
            'add_stock_lines.expiry_date as exp_date',
            'add_stock_lines.created_at as date_of_purchase_of_the_damaged_stock_removed',
            'add_stock_lines.purchase_price as add_stock_line_purchase_price',
            'add_stock_lines.purchase_price as add_stock_line_avg_purchase_price',
            'variations.sku',
            DB::raw('(SELECT SUM(add_stock_lines.quantity)  FROM add_stock_lines  JOIN variations as v ON add_stock_lines.variation_id=v.id WHERE v.id=variations.id ' . $store_query . '  ) as avail_current_stock'),
            DB::raw('(SELECT AVG(add_stock_lines.purchase_price) FROM add_stock_lines JOIN variations as v ON add_stock_lines.variation_id=v.id WHERE v.id=variations.id ' . $store_query . ') as avg_purchase_price'),
            DB::raw('(add_stock_lines.quantity - add_stock_lines.quantity_sold) as damaged_current_stock'),
        )->get();
        // dd($this->addStockLines);
        $this->productId = $productId;
        $this->addRow($this->addStockLines);
    }
    public function addRow($addStockLines)
    {
        foreach ($addStockLines as $stockLine) {
            $new_row = [
                'variation_id' => $stockLine->variation_id,
                'stock_line_id' => $stockLine->id,
                'quantity_to_remove' => '',
                'status' => 'damage',
                'avg_purchase_price' => $stockLine->avg_purchase_price ?? 0,
                'quantity_of_damaged_stock_removed' => 0,
            ];
            $this->rows[] = $new_row;
        }
        // dd($this->rows);
    }
    public function save()
    {
        try {
            foreach ($this->rows as $data) {
                $stockRow = AddStockLine::find($data["stock_line_id"]);
                $variation = Variation::find($data["variation_id"]);
                $stockRow->decrement("quantity", (float)$data["quantity_to_remove"]);
                $store = ProductStore::where("variation_id", $variation->id)->where("product_id", $variation->product_id)->first();
                $this->decreaseProductQuantity($variation->product_id, $variation->id, $store->store_id ?? 0, $data["quantity_to_remove"]);
                if ($data["quantity_to_remove"] > 0) {
                    $productExpiry = ProductExpiryDamage::query()->create([
                        "status" => $data["status"],
                        "product_id" => $variation->product_id,
                        "variation_id" => $variation->id,
                        "quantity_of_expired_stock_removed" => $data["quantity_to_remove"],
                        "date_of_purchase_of_expired_stock_removed" => now()->toDateString(),
                        "value_of_removed_stocks" => $data["quantity_to_remove"],
                        "added_by" => auth()->id(),
                    ]);
                }
            }
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'success', 'message' => __('lang.success'),]);
            return redirect()->back();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error', 'message' => __('lang.something_went_wrongs'),]);
            dd($e);
        }
    }
    public function decreaseProductQuantity($product_id, $variation_id, $store_id, $new_quantity, $old_quantity = 0)
    {
        $qtyByUnit = Variation::find($variation_id)->number_vs_base_unit == 0 ? 1 : Variation::find($variation_id)->number_vs_base_unit;
        $qty_difference = ($qtyByUnit ? (float)$qtyByUnit * (float)$new_quantity : $new_quantity) - $old_quantity;
        $product = Product::find($product_id);

        //Check if stock is enabled or not.
        if ($product->is_service != 1) {
            //Decrement Quantity in variations store table
            $details = ProductStore::where('variation_id', $variation_id)
                ->where('product_id', $product_id)
                ->where('store_id', $store_id)
                ->first();
            return $details;
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
