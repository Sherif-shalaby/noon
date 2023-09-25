<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductTax;
use App\Models\Store;
use App\Models\System;
use App\Models\Unit;
use App\Models\User;
use App\Models\Variation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PhpParser\Builder\Class_;
use App\Utils\Util;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $Util;

    /**
     * Constructor
     *
     * @param Utils $product
     * @return void
     */
    public function __construct(Util $Util)
    {
        $this->Util = $Util;
    }
  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index(Request $request)
  {
    $products=Product::
        when(\request()->category_id != null, function ($query) {
            $query->where('category_id',\request()->category_id);
        })
        ->when(\request()->unit_id != null, function ($query) {
            $query->where('unit_id',\request()->unit_id);
        })
        ->when(\request()->store_id != null, function ($query) {
            $query->where('store_id',\request()->store_id);
        })
        ->when(\request()->brand_id != null, function ($query) {
            $query->where('brand_id',\request()->brand_id);
        })
        ->when(\request()->created_by != null, function ($query) {
            $query->where('created_by',\request()->created_by);
        })
        ->latest()->get();
    $units=Unit::orderBy('created_at', 'desc')->pluck('name','id');
    $categories=Category::orderBy('created_at', 'desc')->pluck('name','id');
    $brands=Brand::orderBy('created_at', 'desc')->pluck('name','id');
    $stores=Store::orderBy('created_at', 'desc')->pluck('name','id');
    $users=User::orderBy('created_at', 'desc')->pluck('name','id');
    return view('products.index',compact('products','categories','brands','units','stores','users'));
  }
  /* ++++++++++++++++++++++ create() ++++++++++++++++++++++ */
  public function create()
  {
        $units=Unit::orderBy('created_at', 'desc')->pluck('name','id');
        $categories=Category::orderBy('created_at', 'desc')->pluck('name','id');
        $brands=Brand::orderBy('created_at', 'desc')->pluck('name','id');
        $stores=Store::orderBy('created_at', 'desc')->pluck('name','id');
        // product_tax
        $product_tax = ProductTax::select('name','id','status')->get();
        $quick_add = 1;
        $unitArray = Unit::orderBy('created_at','desc')->pluck('name', 'id');
        return view('products.create',
        compact('categories','brands','units','stores','product_tax','quick_add','unitArray'));
  }
  /* ++++++++++++++++++++++ store() ++++++++++++++++++++++ */
  public function store(ProductRequest $request)
  {
    // return $request->all();
    try
    {
      $product_data = [
        'name' => $request->name,
        'translations' => !empty($request->translations) ? $request->translations : [],
        'category_id' => $request->category_id,
        'subcategory_id1' => $request->subcategory_id1,
        'subcategory_id2' => $request->subcategory_id2,
        'subcategory_id3' => $request->subcategory_id3,
        'unit_id' => $request->unit_id,
        'brand_id' => $request->brand_id,
        'sku' => !empty($request->product_sku) ? $request->product_sku : $this->generateSku($request->name),
        'height' => $request->height,
        'length' => $request->length,
        'width' => $request->width,
        'size' => $request->size,
        'weight' => $request->weight,
        'details' => $request->details,
        'details_translations' => !empty($request->details_translations) ? $request->details_translations : [],
        'active' => !empty($request->active) ? 1 : 0,
        'created_by' => Auth::user()->id,
        'method' => !empty($request->method) ? $request->method :null,
    ];
    $product = Product::create($product_data);

    // ++++++++++ Store "product_id" And "product_tax_id" in "product_tax_pivot" table ++++++++++
    if(!empty($request->product_tax_id))
    {
        $product->product_taxes()->attach($request->product_tax_id) ;
    }

    // if(!empty($request->subcategory_id)){
    //     $product->subcategories()->attach($request->subcategory_id);
    // }
    if(!empty($request->store_id)){
        $product->stores()->attach($request->store_id);
    }

    if ($request->has('image') && !is_null('image')) {
        $imageData = $this->getCroppedImage($request->image);
        $extention = explode(";", explode("/", $imageData)[1])[0];
        $image = rand(1, 1500) . "_image." . $extention;
        $filePath = public_path('uploads/products/' . $image);
        $image = $image;
        $fp = file_put_contents($filePath, base64_decode(explode(",", $imageData)[1]));
        $product->image=$image;
        $product->save();
    }

    $index_units=[];
    if($request->has('new_unit_id')){
        if(count($request->new_unit_id)>0){
            $index_units=array_keys($request->new_unit_id);
        }
    }
    foreach ($index_units as $index){
        $var_data=[
            'product_id'=>$product->id,
            'unit_id'=>$request->new_unit_id[$index],
            'equal'=>$request->equal[$index],
            'sku' => !empty($request->sku[$index]) ? $request->sku[$index] : $this->generateSku($request->name),
            'created_by'=>Auth::user()->id
        ];
        Variation::create($var_data);
    }

    $index_prices=[];
    if($request->has('price_category')){
        if(count($request->price_category)>0){
            $index_prices=array_keys($request->price_category);
        }
    }
    foreach ($index_prices as $index_price){
    // $price_customers = $this->getPriceCustomerFromType($request->get('price_customer_types_'.$index_price));
        $data_des=[
            'product_id' => $product->id,
            'price_type' => $request->price_type[$index_price],
            'price' => $request->price[$index_price],
            'quantity' => $request->quantity[$index_price],
            'bonus_quantity' => $request->bonus_quantity[$index_price],
            'price_category' => $request->price_category[$index_price],
            'is_price_permenant'=>!empty($request->is_price_permenant[$index_price])? 1 : 0,
            'price_customer_types' => $request->get('price_customer_types'.$index_price),
            'price_start_date' => !empty($request->price_start_date[$index_price]) ? $this->uf_date($request->price_start_date[$index_price]) : null,
            'price_end_date' => !empty($request->price_end_date[$index_price]) ? $this->uf_date($request->price_end_date[$index_price]) : null,
            'created_by' => Auth::user()->id,
        ];
        ProductPrice::create($data_des);
    }



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
    return redirect()->back()->with('status', $output);
  }
  public function getPriceCustomerFromType($customer_types)
    {

        $discount_customers = [];
        if (!empty($customer_types)) {
            $customers = Customer::whereIn('customer_type_id', $customer_types)->get();
            foreach ($customers as $customer) {
                $discount_customers[] = $customer->id;
            }
        }

        return $discount_customers;
    }
  public function generateSku($name, $number = 1)
  {
      $name_array = explode(" ", $name);
      $sku = '';
      foreach ($name_array as $w) {
          if (!empty($w)) {
              if (!preg_match('/[^A-Za-z0-9]/', $w)) {
                  $sku .= $w[0];
              }
          }
      }
      // $sku = $sku . '-' . $number;
      $sku = $sku . $number;
      $sku_exist = Product::where('sku', $sku)->exists();

      if ($sku_exist) {
          return $this->generateSku($name, $number + 1);
      } else {
          return $sku;
      }
  }
  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {

  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
      $units=Unit::orderBy('created_at', 'desc')->pluck('name','id');
      $categories=Category::orderBy('created_at', 'desc')->pluck('name','id');
      $brands=Brand::orderBy('created_at', 'desc')->pluck('name','id');
      $stores=Store::orderBy('created_at', 'desc')->pluck('name','id');
      $quick_add=1;
      $product=Product::with('product_taxes')->findOrFail($id);
      $customer_types = CustomerType::pluck('name', 'id');
      $product_tax = ProductTax::all();
      $unitArray = Unit::orderBy('created_at','desc')->pluck('name', 'id');
      return view('products.edit',compact('unitArray','categories','brands','units','stores','quick_add','product','customer_types','product_tax'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id,Request $request)
  {
    // return $request->all();
    try{
      $product_data = [
        'name' => $request->name,
        'translations' => !empty($request->translations) ? $request->translations : [],
        'category_id' => $request->category_id,
        'subcategory_id1' => $request->subcategory_id1,
        'subcategory_id2' => $request->subcategory_id2,
        'subcategory_id3' => $request->subcategory_id3,
        'brand_id' => $request->brand_id,
        'unit_id' => $request->unit_id,
        'sku' => !empty($request->product_sku) ? $request->product_sku : $this->generateSku($request->name),
        'height' => $request->height,
        'length' => $request->length,
        'width' => $request->width,
        'size' => $request->size,
        'weight' => $request->weight,
        'details' => $request->details,
        'details_translations' => !empty($request->details_translations) ? $request->details_translations : [],
        'active' => !empty($request->active) ? 1 : 0,
        'edited_by' => Auth::user()->id,
        // method column
        'method' => $request->method,
    ];
    $product = Product::find($id);
    $product->update($product_data);
    // ++++++++++++++++++++ product_tax : update pivot Table ++++++++++++++++++++
    // When Change "product_tax" update "products_taxes" table
    $product->product_taxes()->sync($request->product_tax_id);

    if(!empty($request->store_id)){
        $product->stores()->sync($request->store_id);
    }

    if ($request->has('image') && !is_null('image')) {
        $image_path = public_path() .'/uploads/products/'.$product->image;  // prev image path
        if(File::exists($image_path)) {
            File::delete($image_path);
        }

        $imageData = $this->getCroppedImage($request->image);
        $extention = explode(";", explode("/", $imageData)[1])[0];
        $image = rand(1, 1500) . "_image." . $extention;
        $filePath = public_path('uploads/products/' . $image);
        $image = $image;
        $fp = file_put_contents($filePath, base64_decode(explode(",", $imageData)[1]));
        $product->image=$image;
        $product->save();
    }


    $index_units=[];
    $product->variations()->delete();

    if($request->has('new_unit_id')){
        if(count($request->new_unit_id)>0){
            $index_units=array_keys($request->new_unit_id);
        }
    }
    foreach ($index_units as $index){
        $var_data=[
            'product_id'=>$product->id,
            'unit_id'=>$request->new_unit_id[$index],
            'equal'=>$request->equal[$index],
            'sku' => !empty($request->sku[$index]) ? $request->sku[$index] : $this->generateSku($request->name),
            'edited_by'=>Auth::user()->id
        ];
        Variation::create($var_data);
    }



    $index_prices=[];
    $product->product_prices()->delete();
    $index_prices=[];
    if($request->has('price_category')){
        if(count($request->price_category)>0){
            $index_prices=array_keys($request->price_category);
        }
    }
    foreach ($index_prices as $index_price){
        $data_des=[
            'product_id' => $product->id,
            'price_type' => $request->price_type[$index_price],
            'price_category' => $request->price_category[$index_price],
            'price' => $request->price[$index_price],
            'quantity' => $request->quantity[$index_price],
            'bonus_quantity' => $request->bonus_quantity[$index_price],
            'is_price_permenant'=>!empty($request->is_price_permenant[$index_price])? 1 : 0,
            'price_customer_types' => $request->get('price_customer_types'.$index_price),
            'price_start_date' => !empty($request->price_start_date[$index_price]) ? $this->uf_date($request->price_start_date[$index_price]) : null,
            'price_end_date' => !empty($request->price_end_date[$index_price]) ? $this->uf_date($request->price_end_date[$index_price]) : null,
            'created_by' => Auth::user()->id,
        ];
        ProductPrice::create($data_des);
    }
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
    return redirect()->back()->with('status', $output);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    try {
        $product=Product::find($id);
        $image_path = public_path() .'/uploads/products/'.$product->image;  // prev image path
        if(File::exists($image_path)) {
            File::delete($image_path);
        }
        $product->variations()->update([
            'deleted_by'=>Auth::user()->id
        ]);
        $product->variations()->delete();
        $product->deleted_by = Auth::user()->id;
        $product->save();
        $product->delete();
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
  public function getRawPrice()
  {
      $row_id = request()->row_id ?? 0;
      $customer_types = CustomerType::pluck('name', 'id');

      return view('products.product_raw_price',compact(
          'row_id',
          'customer_types',
      ));
  }
  public function getRawProduct()
  {
      $index= request()->row_id ?? 0;
    $units=Unit::orderBy('created_at', 'desc')->get();
      return view('add-stock.partials.add_product_row',compact(
          'index',
          'units',
      ));
  }

  function getCroppedImage($img)
  {
      if (strlen($img) < 200) {
          return $this->getBase64Image($img);
      } else {
          return $img;
      }
  }
  function getBase64Image($Image)
  {
      $image_path = str_replace(env("APP_URL") . "/", "", $Image);
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $image_path);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $image_content = curl_exec($ch);
      curl_close($ch);
//    $image_content = file_get_contents($image_path);
      $base64_image = base64_encode($image_content);
      $b64image = "data:image/jpeg;base64," . $base64_image;
      return $b64image;
  }
  public function uf_date($date, $time = false)
  {
      $date_format = 'm/d/Y';
      $mysql_format = 'Y-m-d';
      if ($time) {
          if (System::getProperty('time_format') == 12) {
              $date_format = $date_format . ' h:i A';
          } else {
              $date_format = $date_format . ' H:i';
          }
          $mysql_format = 'Y-m-d H:i:s';
      }

      return !empty($date_format) ? Carbon::createFromFormat($date_format, $date)->format($mysql_format) : null;
  }
  public function getRawUnit()
    {
        $index = request()->row_id ?? 0;
        $units = Unit::orderBy('created_at','desc')->pluck('name', 'id');
  
        return view('products.product_unit_raw',compact(
            'index',
            'units',
        ));
    }
}

?>
