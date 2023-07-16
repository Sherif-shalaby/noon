<?php 

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Store;
use App\Models\System;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PhpParser\Builder\Class_;

class ProductController extends Controller 
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $products=Product::latest()->get();
    return view('products.index',compact('products'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
      $units=Unit::orderBy('created_at', 'desc')->pluck('name','id');
      $categories=Category::orderBy('created_at', 'desc')->pluck('name','id');
      $brands=Brand::orderBy('created_at', 'desc')->pluck('name','id');
      $stores=Store::orderBy('created_at', 'desc')->pluck('name','id');
      return view('products.create',compact('categories','brands','units','stores'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(ProductRequest $request)
  {
    // return $request->all();
    // try{
      $product_data = [
        'name' => $request->name,
        'translations' => !empty($request->translations) ? $request->translations : [],
        'category_id' => $request->category_id,
        // 'store_id' =>  !empty($request->subcategory_id) ?$request->subcategory_id: [],
        'brand_id' => $request->brand_id,
        'sku' => !empty($request->sku) ? $request->sku : $this->generateSku($request->name),
        'height' => $request->height,
        'length' => $request->length,
        'width' => $request->width,
        'size' => $request->size,
        'weight' => $request->weight,
        'details' => $request->details,
        'details_translations' => !empty($request->details_translations) ? $request->details_translations : [],
        'active' => !empty($request->active) ? 1 : 0,
        'created_by' => Auth::user()->id,
    ];
    $product = Product::create($product_data);
    if(!empty($request->subcategory_id)){
        $product->subcategories()->attach($request->subcategory_id);
    }
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



    $index_prices=[];
    if($request->has('price_category')){
        if(count($request->price_category)>0){
            $index_prices=array_keys($request->price_category);
        }
    }


    foreach ($index_prices as $index_price){
        $price_customers = $this->getPriceCustomerFromType($request->get('price_customer_types_'.$index_price));
        $data_des=[
            'product_id' => $product->id,
            'price_category' => $request->price_category[$index_price],
            'is_price_permenant'=>!empty($request->is_price_permenant[$index_price])? 1 : 0,
            'price_customer_types' => $request->get('price_customer_types_'.$index_price),
            // 'price_customers' => $price_customers,
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
    //  } catch (\Exception $e) {
    //         Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
    //         $output = [
    //             'success' => false,
    //             'msg' => __('lang.something_went_wrong')
    //         ];
    // }
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
    
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    
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
  
}

?>