<?php

namespace App\Http\Controllers;

use App\Models\AddStockLine;
use App\Models\CashRegisterTransaction;
use App\Models\Category;
use App\Models\MoneySafeTransaction;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductStore;
use App\Models\ProductTax;
use App\Models\StockTransaction;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\System;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Utils\MoneySafeUtil;
use App\Utils\ProductUtil;
use App\Utils\StockTransactionUtil;
use App\Utils\Util;
use Illuminate\Support\Facades\File;

class InitialBalanceController extends Controller
{
    protected $commonUtil;
    protected $moneysafeUtil;
    protected $productUtil;
    protected $stockTransactionUtil;


    public function __construct(Util $commonUtil,ProductUtil $productUtil,MoneySafeUtil $moneySafeUtil, StockTransactionUtil $stockTransactionUtil)
    {
        $this->commonUtil = $commonUtil;
        $this->moneysafeUtil = $moneySafeUtil;
        $this->productUtil = $productUtil;
        $this->stockTransactionUtil = $stockTransactionUtil;

    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('initial-balance.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {

        $exchange_rate=0;
        $exchange_rate =System::getProperty('dollar_exchange');
        return view('initial-balance.create',compact('exchange_rate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        $exchange_rate=0;
        $exchange_rate =System::getProperty('dollar_exchange');
        $stockId=$id;
        return view('initial-balance.edit',compact('exchange_rate','stockId'));
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
            $add_stock = StockTransaction::find($id);
            $add_stock_lines = $add_stock->add_stock_lines;

            $product=Product::find($add_stock_lines->first()->product_id);
            // return $product;
            if(isset($product->image)){
                $image_path = public_path() .'/uploads/products/'.$product->image;  // prev image path
                if(File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            if (!empty($product->variations())) {
            $product->variations()->update([
                'deleted_by'=>Auth::user()->id
            ]);
            $product->variations()->delete();
            }
            ProductTax::where('product_id', $add_stock_lines->first()->product_id)->delete();

            $product->deleted_by = Auth::user()->id;
            $product->save();
            $product->delete();

            DB::beginTransaction();

            if ($add_stock->status != 'received') {
                $add_stock_lines->delete();
            } else {
                $delete_add_stock_line_ids = [];
                foreach ($add_stock_lines as $line) {
                    $delete_add_stock_line_ids[] = $line->id;
                    ProductStore::where('product_id',$line->product_id)->delete();
                    // $this->productUtil->decreaseProductQuantity($line->product_id, $line->variation_id, $add_stock->store_id, $line->quantity);
                }

                if (!empty($delete_add_stock_line_ids)) {
                    AddStockLine::where('stock_transaction_id', $id)->whereIn('id', $delete_add_stock_line_ids)->delete();
                    ProductPrice::whereIn('stock_line_id',$delete_add_stock_line_ids)->delete();
                }
            }

            $add_stock->delete();
            CashRegisterTransaction::where('transaction_id', $id)
                ->where('type','add_stock')->delete();
            MoneySafeTransaction::where('transaction_id', $id)
                ->where('type','add_stock')->delete();

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
            dd($e);
        }

        return $output;
    }
    public function getRawUnit()
    {
        $row_id = request()->row_id ?? 0;
        $units = Unit::orderBy('created_at','desc')->pluck('name', 'id');

        return view('initial-balance.partial.raw_unit',compact(
            'row_id',
            'units',
        ));
    }
}
