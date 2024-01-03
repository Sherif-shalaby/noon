<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tax;
use App\Utils\Util;
use App\Models\Unit;
use App\Models\User;
use App\Models\Brand;
use App\Models\Store;
use App\Models\Branch;
use App\Models\System;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Variation;
use App\Models\AddStockLine;
use App\Models\CustomerType;
use Illuminate\Support\Facades\Notification;
use App\Models\ProductPrice;
use Illuminate\Http\Request;
use PhpParser\Builder\Class_;
use App\Utils\TransactionUtil;
use App\Models\ProductDimension;
use App\Models\StockTransaction;
use App\Models\ProductExpiryDamage;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProductRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Storage;
use App\Notifications\AddProductNotification;
use Illuminate\Contracts\Foundation\Application;
use App\Models\ProductStore;
use App\Models\ProductTax;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    protected $Util;
    protected $transactionUtil;
    /**
     * Constructor
     *
     * @param Utils $product
     * @param transactionUtil $transactionUtil
     * @return void
     */
    public function __construct(Util $Util, TransactionUtil $transactionUtil)
    {
        $this->Util = $Util;
        $this->transactionUtil = $transactionUtil;
    }
  /**
   * Display a listing of the resource.
   *
   * @return Application|Factory|View
   */

  public function index(Request $request)
  {
    $categories1 = Category::orderBy('name', 'asc')->where('parent_id',1)->pluck('name', 'id')->toArray();
    $categories2 = Category::orderBy('name', 'asc')->where('parent_id',2)->pluck('name', 'id')->toArray();
    $categories3 = Category::orderBy('name', 'asc')->where('parent_id',3)->pluck('name', 'id')->toArray();
    $categories4 = Category::orderBy('name', 'asc')->where('parent_id',4)->pluck('name', 'id')->toArray();
    $stock_transaction_ids=StockTransaction::where('supplier_id',request()->supplier_id)->pluck('id');
    $products=Product::
        when(\request()->dont_show_zero_stocks =="on", function ($query) {
            $query->whereHas('product_stores', function ($query) {
                $query->where('quantity_available', '>', 0);
            });
        })
        ->when(\request()->category_id != null, function ($query) {
            $query->where('category_id',\request()->category_id);
        })
        ->when(\request()->subcategory_id1 != null, function ($query) {
            $query->where('subcategory_id1',\request()->subcategory_id1);
        })
        ->when(\request()->subcategory_id2 != null, function ($query) {
            $query->where('subcategory_id2',\request()->subcategory_id2);
        })
        ->when(\request()->subcategory_id3 != null, function ($query) {
            $query->where('subcategory_id3',\request()->subcategory_id3);
        })
        ->when(\request()->store_id != null, function ($query) {
            $query->whereHas('product_stores', function ($query) {
                $query->whereIn('store_id',\request()->store_id);
            });
        })
        ->when(\request()->supplier_id != null, function ($query) use ($stock_transaction_ids) {
            $query->whereHas('stock_lines', function ($query) use ($stock_transaction_ids) {
                $query->whereIn('stock_transaction_id', $stock_transaction_ids);
            });
        })
        ->when(\request()->brand_id != null, function ($query) {
            $query->whereIn('brand_id',\request()->brand_id);
        })
        ->when(\request()->created_by != null, function ($query) {
            $query->where('created_by',\request()->created_by);
        })
        ->latest()->get();
    $units=Unit::orderBy('created_at', 'desc')->pluck('name','id');
    $categories= Category::whereNull('parent_id')->orderBy('created_at', 'desc')->pluck('name','id');
    $subcategories= Category::whereNotNull('parent_id')->orderBy('created_at', 'desc')->pluck('name','id');
    $brands=Brand::orderBy('created_at', 'desc')->pluck('name','id');
    $stores=Store::orderBy('created_at', 'desc')->pluck('name','id');
    $users=User::orderBy('created_at', 'desc')->pluck('name','id');
    $suppliers=Supplier::orderBy('created_at', 'desc')->pluck('name','id');
    $branches = Branch::orderBy('created_at', 'desc')->pluck('name','id');
    $subcategories = Category::orderBy('name', 'asc')->pluck('name', 'id')->toArray();

    return view('products.index',compact('products','categories','branches','suppliers','brands','units','stores','users','subcategories','categories1','categories2','categories3','categories4'));
  }
  /* ++++++++++++++++++++++ create() ++++++++++++++++++++++ */
  public function create()
  {
    $clear_all_input_form = System::getProperty('clear_all_input_stock_form');
    $recent_product=[];
    if(isset($clear_all_input_form) && $clear_all_input_form == '1') {
         $recent_product = Product::orderBy('created_at', 'desc')->first();
     }
    $units=Unit::orderBy('created_at', 'desc')->get();
    $categories1 = Category::orderBy('name', 'asc')->where('parent_id',1)->pluck('name', 'id')->toArray();
    $categories2 = Category::orderBy('name', 'asc')->where('parent_id',2)->pluck('name', 'id')->toArray();
    $categories3 = Category::orderBy('name', 'asc')->where('parent_id',3)->pluck('name', 'id')->toArray();
    $categories4 = Category::orderBy('name', 'asc')->where('parent_id',4)->pluck('name', 'id')->toArray();
    $brands=Brand::orderBy('created_at', 'desc')->pluck('name','id');
    $stores=Store::orderBy('created_at', 'desc')->get();
    // product_tax
    $product_tax = Tax::where('status','active')->get();
    $quick_add = 1;
    $unitArray = Unit::orderBy('created_at','desc')->pluck('name', 'id');
    $branches = Branch::where('type', 'branch')->orderBy('created_by','desc')->pluck('name','id');

      return view('products.create',
    compact('categories1','categories2','categories3','categories4','brands','units','stores','branches',
        'product_tax','quick_add','unitArray',
        'clear_all_input_form','recent_product'));
  }
    /* ++++++++++++++++++++++ store() ++++++++++++++++++++++ */
    public function store(ProductRequest $request)
    {
        try
        {
                DB::beginTransaction();
                foreach ($request->products as $re_product) {
                    if ($re_product['name'] != null) {
                        $product_data = [
                            'name' => $re_product['name'],
                            'translations' => !empty($re_product['translations']) ? $re_product['translations'] : [],
                            'category_id' => $re_product['category_id'],
                            'subcategory_id1' => $re_product['subcategory_id1'] ?? null,
                            'subcategory_id2' => $re_product['subcategory_id2'] ?? null,
                            'subcategory_id3' => $re_product['subcategory_id3'] ?? null,
                            'brand_id' => $re_product['brand_id'],
                            'sku' => !empty($re_product['product_sku']) ? $re_product['product_sku'] : $this->generateSku(),
                            'details' => !empty($re_product['details']) ? $re_product['details'] : null,
                            'details_translations' => !empty($re_product['details_translations']) ? $re_product['details_translations'] : [],
                            'active' => !empty($re_product['active']) ? 1 : 0,
                            'created_by' => Auth::user()->id,
                            'method' => !empty($re_product['method']) ? $re_product['method'] : null,
                            'product_symbol' => !empty($re_product['product_symbol']) ? $re_product['product_symbol'] : null,
                            'balance_return_request' => !empty($re_product['balance_return_request']) ? $re_product['balance_return_request'] : null,
                        ];
                        $product = Product::create($product_data);
                        // ++++++++++ Store "product_id" And "product_tax_id" in "product_tax_pivot" table ++++++++++
                        if (!empty($re_product['product_tax_id'])) {
                            ProductTax::create([
                                'product_tax_id' => $re_product['product_tax_id'],
                                'product_id' => $product->id,
                            ]);
                        }
                        if (!empty($request->store_id)) {
                            $product->stores()->attach($request->store_id);
                        }
                        if (isset($re_product['image']) && !is_null($re_product['image'])) {
                            $imageData = $this->getCroppedImage($re_product['image']);
                            $extention = explode(";", explode("/", $imageData)[1])[0];
                            $image = rand(1, 1500) . "_image." . $extention;
                            $filePath = public_path('uploads/products/' . $image);
                            $image = $image;
                            $fp = file_put_contents($filePath, base64_decode(explode(",", $imageData)[1]));
                            $product->image = $image;
                            $product->save();
                        }
                        if (!empty($re_product['variations'])) {
                            $variations = $re_product['variations'];
                            if (!empty($variations)) {
                                foreach ($variations as $key => $variant) {
                                    if (isset($variant['new_unit_id'])) {
                                        $var_data = [
                                            'product_id' => $product->id,
                                            'unit_id' => $variant['new_unit_id'],
                                            'basic_unit_id' => !empty($variations[$key + 1]) ? $variations[$key + 1]['new_unit_id'] : null,
                                            'equal' => !empty($variations[$key + 1]) ? $variations[$key + 1]['equal'] : null,
                                            'sku' => !empty($variant['sku']) ? $variant['sku'] : $this->generateSku(),
                                            'created_by' => Auth::user()->id
                                        ];
                                        Variation::create($var_data);
                                    }
                                }
                            }
                        }
                        if ($re_product['height'] == ('' || 0) && $re_product['length'] == ('' || 0) && $re_product['width'] == ('' || 0)
                            || $re_product['size'] == ('' || 0) && $re_product['weight'] == ('' || 0)) {
                        } else {
                            $product_dimensions = [
                                'product_id' => $product->id ?? null,
                                'variation_id' => Variation::where('product_id', $product->id)->where('unit_id', $re_product['variation_id'])->first()->id ?? null,
                                'height' => $re_product['height'],
                                'length' => $re_product['length'],
                                'width' => $re_product['width'],
                                'size' => $re_product['size'],
                                'weight' => $re_product['weight']
                            ];
                            ProductDimension::create($product_dimensions);

                        }
                    }

                }
                DB::commit();

                $output = [
                    'success' => true,
                    'msg' => __('lang.success')
                ];
        }
        catch (\Exception $e)
        {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }

        // +++++++++++++++ Start : Notification ++++++++++++++++++++++
        // Fetch the user
        $users = User::where('id', '!=', auth()->user()->id)->get();
        $product_name = $product->name;
        // Get the name of the user creating the employee
        $userCreateEmp = auth()->user()->name;
        $type = "create_product";
        // Send notification to All users Except "auth()->user()"
        foreach ($users as $user) {
            Notification::send($user, new AddProductNotification($product->id, $userCreateEmp, $product_name, $type));
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
    // // ============================= Products Categories : Real-Time Filters =============================
    // // ++++++ fetch_sub_categories1() : Get Sub_Categories1 According to "selected main_categories" selectbox ++++++
    // public function fetch_sub_categories1(Request $request)
    // {
    //     $data['subcategory_id1'] = Category::where('parent_id', $request->subcategories1_id)->get(['id','name']);
    //     return response()->json($data);
    // }
    // // ++++++ fetch_sub_categories2() : Get Sub_Categories2 According to "selected sub_category1" selectbox ++++++
    // public function fetch_sub_categories2(Request $request)
    // {
    //     $data['subcategory_id2'] = Category::where('parent_id', $request->subcategories2_id)->get(['id','name']);
    //     return response()->json($data);
    // }
    // // ++++++ fetch_sub_categories3() : Get Sub_Categories3 According to "selected sub_category2" selectbox ++++++
    // public function fetch_sub_categories3(Request $request)
    // {
    //     $data['subcategory_id3'] = Category::where('parent_id', $request->subcategories3_id)->get(['id','name']);
    //     return response()->json($data);
    // }
    /* ++++++++++++++++++++++ add_store() ++++++++++++++++++++++ */
    public function add_store(Request $request)
    {
        // dd($request);
        try
        {
            $store = new Store();
            $store->branch_id               = $request->branch_id;
            $store->name                    = $request->name;
            $store->phone_number            = $request->phone_number;
            $store->email                   = $request->email;
            $store->manager_name            = $request->manager_name;
            $store->manager_mobile_number   = $request->manager_mobile_number;
            $store->created_by              = auth()->user()->id;
            $store->save();
            $output = [
                'success'  => true,
                'store_id' => $store->id,
                'msg' => __('lang.success')
            ];
        }
        catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }
        return $output;
    }
    /* ++++++++++++++++++++++ get store Dropdown() ++++++++++++++++++++++ */
    public function getStoresDropdown()
    {
        $stores = Store::orderBy('created_at', 'asc')->pluck('name', 'id')->toArray();
        $stores_dp = $this->Util->createDropdownHtml($stores, __('lang.please_select'));
        $output = [$stores_dp , array_key_last($stores)];
        return $output;
    }
    // +++++++++++++++ Get Dropdown List ++++++++++++++++++
    public function createDropdownHtml($array, $append_text = null)
    {
        $html = '';
        if (!empty($append_text)) {
            $html = '<option value="">' . $append_text . '</option>';
        }
        foreach ($array as $key => $value) {
            $html .= '<option value="' . $key . '">' . $value . '</option>';
        }
        return $html;
    }
  public function generateSku()
  {

//      $name_array = explode(" ", $name);
//      $sku = '';
//      foreach ($name_array as $w) {
//          if (!empty($w)) {
//              if (!preg_match('/[^A-Za-z0-9]/', $w)) {
//                  $sku .= $w[0];
//              }
//          }
//      }
//      // $sku = $sku . '-' . $number;
//      $sku = $sku . $number;
//      $sku_exist = Product::where('sku', $sku)->exists();

//      if ($sku_exist) {
//          return $this->generateSku($name, $number + 1);
//      } else {
//      }
      $start = System::getProperty('product_sku_start');
      $number = Product::count();
      $sku = $start . $number;
      return $sku;
  }
  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Application|Factory|View
   */
    public function show($id)
    {
        $product = Product::find($id);
        $stock_detials = ProductStore::where('product_id', $id)->get();
        return view('products.show')->with(compact(
            'product',
            'stock_detials',
        ));

    }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Application|Factory|View
   */
  public function edit($id)
  {
        $units=Unit::orderBy('created_at', 'desc')->get();
    //   $categories=Category::orderBy('created_at', 'desc')->pluck('name','id');
        $categories1 = Category::orderBy('name', 'asc')->where('parent_id',1)->pluck('name', 'id')->toArray();
        $categories2 = Category::orderBy('name', 'asc')->where('parent_id',2)->pluck('name', 'id')->toArray();
        $categories3 = Category::orderBy('name', 'asc')->where('parent_id',3)->pluck('name', 'id')->toArray();
        $categories4 = Category::orderBy('name', 'asc')->where('parent_id',4)->pluck('name', 'id')->toArray();
        $brands=Brand::orderBy('created_at', 'desc')->pluck('name','id');
        $stores=Store::orderBy('created_at', 'desc')->pluck('name','id');
        $quick_add=1;
        $product=Product::findOrFail($id);
        $product_tax_id=ProductTax::where('product_id',$product->id)->first()->product_tax_id??null;
        $customer_types = CustomerType::pluck('name', 'id');
        $product_tax = Tax::all();
        $unitArray = Unit::orderBy('created_at','desc')->pluck('name', 'id');
        $variation_units=Variation::where('product_id',$id)->pluck('unit_id');
        $basic_units=Unit::whereIn('id',$variation_units)->pluck('name','id');
        $branches = Branch::where('type','branch')->pluck('name','id');
        return view('products.edit',compact('unitArray','categories1','categories2','categories3','categories4','brands'
        ,'units','stores','quick_add','product','customer_types','product_tax','product_tax_id','basic_units','branches'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id,Request $request)
  {
    try{
      $product_data = [
        'name' => $request->name,
        'translations' => !empty($request->translations) ? $request->translations : [],
        'category_id' => $request->category_id,
        'subcategory_id1' => $request->subcategory_id1,
        'subcategory_id2' => $request->subcategory_id2,
        'subcategory_id3' => $request->subcategory_id3,
        'brand_id' => $request->brand_id,
        'sku' => !empty($request->product_sku) ? $request->product_sku : $this->generateSku($request->name),
        // 'height' => $request->height,
        // 'length' => $request->length,
        // 'width' => $request->width,
        // 'size' => $request->size,
        // 'weight' => $request->weight,
        'details' => $request->details,
        'details_translations' => !empty($request->details_translations) ? $request->details_translations : [],
        'active' => !empty($request->active) ? 1 : 0,
        'edited_by' => Auth::user()->id,
        // method column
        'method' => $request->method,
        'product_symbol'=>!empty($request->product_symbol) ? $request->product_symbol :null,
        'balance_return_request' => !empty($request->balance_return_request) ?$request->balance_return_request:null,

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

    $variations = $request->products[0]['variations'];
    if (!empty($variations)){
        foreach ($variations as $key => $variant){
            if(!empty($variant['new_unit_id'])){
                $var_data=[
                    'product_id' => $product->id,
                    'unit_id' => $variant['new_unit_id'],
                    'basic_unit_id' => !empty($variations[ $key+1 ]) ? $variations[ $key+1 ]['new_unit_id'] : null,
                    'equal' => !empty($variations[$key+1]) ? $variations[$key+1]['equal'] : null,
                    'sku' => !empty($variant['sku']) ? $variant['sku'] : $this->generateSku(),
                    'edited_by' => Auth::user()->id
                ];
                if(!empty($variant['variation_id'])){
                    $variation = Variation::find($variant['variation_id']);
                    $variation->update($var_data);
                }
                else{
                    Variation::create($var_data);
                }
            }
        }
    }

    if ($request->height ==(''||0) && $request->length ==(''||0) && $request->width ==(''||0)
    || $request->size ==(''||0) && $request->weight ==(''||0)) {
        ProductDimension::where('product_id',$product->id)->delete();
    }else{
        $product_dimensions=[
            'product_id'=>$product->id??null,
            'variation_id'=>Variation::where('product_id',$product->id)->where('unit_id',$request->variation_id)->first()->id??null,
            'height' => $request->height,
            'length' => $request->length,
            'width' => $request->width,
            'size' => $request->size,
            'weight' => $request->weight
        ];
        ProductDimension::where('product_id',$product->id)->update($product_dimensions);
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
        dd($e);
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
        $product->sell_lines()->delete();
        $product->stock_lines()->delete();
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
        $key = request()->key ?? 0;
        $units = Unit::orderBy('created_at','desc')->get();

        return view('products.product_unit_raw',compact(
            'index',
            'units','key'
        ));
    }
    public function addProductRow()
    {
        $key = request()->row_id ?? 0;
//        dd($key);
        $units=Unit::orderBy('created_at', 'desc')->get();
//        $categories = Category::orderBy('name', 'asc')->where('parent_id',null)->pluck('name', 'id')->toArray();
//        $subcategories = Category::orderBy('name', 'asc')->where('parent_id','!=',null)->pluck('name', 'id')->toArray();
        $categories1 = Category::orderBy('name', 'asc')->where('parent_id',1)->pluck('name', 'id')->toArray();
        $categories2 = Category::orderBy('name', 'asc')->where('parent_id',2)->pluck('name', 'id')->toArray();
        $categories3 = Category::orderBy('name', 'asc')->where('parent_id',3)->pluck('name', 'id')->toArray();
        $categories4 = Category::orderBy('name', 'asc')->where('parent_id',4)->pluck('name', 'id')->toArray();
        $brands=Brand::orderBy('created_at', 'desc')->pluck('name','id');
        $stores=Store::orderBy('created_at', 'desc')->pluck('name','id');
        // product_tax
        $product_tax = Tax::where('status','active')->get();
        $unitArray = Unit::orderBy('created_at','desc')->pluck('name', 'id');
        $branches = Branch::where('type', 'branch')->orderBy('created_by','desc')->pluck('name','id');
        return view('products.partials.product_row',compact(
            'key','units','categories1','categories2','categories3','categories4','branches','brands','stores','product_tax','unitArray'
        ));
    }
    // +++++++++++++++++++ delete multiple products ++++++++++++++++
    public function multiDeleteRow(Request $request){
        try {
            DB::beginTransaction();
            foreach ($request->ids as $id){
                $product = Product::find($id);
                if(!empty($product->variations)){
                    foreach ($product->variations as $variation){
                        $var = Variation::find($variation->id);
                        $var->forceDelete();
                    }
                }
                $product_stores = ProductStore::where('product_id', $id)->get();
                if(!empty($product_stores)){
                    foreach ($product_stores as $store){
                        $product_store = ProductStore::find($store->id);
                        $product_store->forceDelete();
                    }
                }

                $product->delete();
            }
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];

            DB::commit();
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }

        return $output;
    }

    public function get_remove_damage(Request $request,$id){
        $product_damages = ProductExpiryDamage::where("product_id",$id)->where("status","damage")->get();
        $status = "damage";
        return view('product_expiry_damage.index')
            ->with(compact( 'product_damages', 'status' ,'id' ));
    }
    public function deleteExpiryRow($id){
        try {
            $product_expiry=ProductExpiryDamage::find($id);
            $product_expiry->delete();
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

    public function getDamageProduct(Request $request,$id){
            // $addStockLines = AddStockLine::
            // where("add_stock_lines.product_id",$id)
            //     ->where("add_stock_lines.quantity",">",0 )
            //     ->leftjoin('variations', function ($join) {
            //         $join->on('add_stock_lines.variation_id', 'variations.id')->whereNull('variations.deleted_at');
            //     });
            // $store_id = $this->transactionUtil->getFilterOptionValues($request)['store_id'];
            // $store_query = '';
            // if (!empty($store_id)) {
            //     // $products->where('product_stores.store_id', $store_id);
            //     $store_query = 'AND store_id=' . $store_id;
            // }
            // $addStockLines = $addStockLines->select(
            //     'add_stock_lines.*',
            //     'add_stock_lines.expiry_date as exp_date',
            //     'add_stock_lines.created_at as date_of_purchase_of_the_expired_stock_removed',
            //     'add_stock_lines.purchase_price as add_stock_line_purchase_price',
            //     'add_stock_lines.purchase_price as add_stock_line_avg_purchase_price',
            //     'variations.sku',
            //     DB::raw('(SELECT SUM(add_stock_lines.quantity)  FROM add_stock_lines  JOIN variations as v ON add_stock_lines.variation_id=v.id WHERE v.id=variations.id ' . $store_query . '  ) as avail_current_stock'),
            //     DB::raw('(SELECT AVG(add_stock_lines.purchase_price) FROM add_stock_lines JOIN variations as v ON add_stock_lines.variation_id=v.id WHERE v.id=variations.id ' . $store_query . ') as avg_purchase_price'),
            //     DB::raw('(add_stock_lines.quantity - add_stock_lines.quantity_sold) as expired_current_stock'),
            // )->get();
                // return $addStockLines;
        return view("product_expiry_damage.add",compact('id'));
    }
    public function get_remove_expiry(Request $request,$id){
        $product_damages = ProductExpiryDamage::where("product_id",$id)->where("status","expiry")->get();
        $status = "expiry";
        return view('product_expiry_damage.index')
            ->with(compact( 'product_damages', 'status' ,'id' ));
    }
    public function addConvolution(Request $request,$id){
        // $addStockLines = AddStockLine::
        // where("add_stock_lines.product_id",$id)
        //     ->where("add_stock_lines.quantity",">",0 )
        //     ->leftjoin('variations', function ($join) {
        //         $join->on('add_stock_lines.variation_id', 'variations.id')->whereNull('variations.deleted_at');
        //     });
        // $store_id = $this->transactionUtil->getFilterOptionValues($request)['store_id'];
        // $store_query = '';
        // if (!empty($store_id)) {
        //     // $products->where('product_stores.store_id', $store_id);
        //     $store_query = 'AND store_id=' . $store_id;
        // }
        // $addStockLines = $addStockLines->select(
        //     'add_stock_lines.*',
        //     'add_stock_lines.expiry_date as exp_date',
        //     'add_stock_lines.created_at as date_of_purchase_of_the_expired_stock_removed',
        //     'add_stock_lines.purchase_price as add_stock_line_purchase_price',
        //     'add_stock_lines.purchase_price as add_stock_line_avg_purchase_price',
        //     'variations.sku',
        //     DB::raw('(SELECT SUM(add_stock_lines.quantity)  FROM add_stock_lines  JOIN variations as v ON add_stock_lines.variation_id=v.id WHERE v.id=variations.id ' . $store_query . '  ) as avail_current_stock'),
        //     DB::raw('(SELECT AVG(add_stock_lines.purchase_price) FROM add_stock_lines JOIN variations as v ON add_stock_lines.variation_id=v.id WHERE v.id=variations.id ' . $store_query . ') as avg_purchase_price'),
        //     DB::raw('(add_stock_lines.quantity - add_stock_lines.quantity_sold) as expired_current_stock'),
        // )->get();
            // return $addStockLines;
    return view("product_expiry_damage.create",compact('id'));
    }
}


?>
