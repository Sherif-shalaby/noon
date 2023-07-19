<?php 

namespace App\Http\Controllers;

use App\Http\Requests\CustomerTypeRequest;
use App\Http\Requests\CustomerTypeUpdateRequest;
use App\Models\CustomerType;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CustomerTypeController extends Controller 
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
      $customer_types=CustomerType::latest()->get();
      $stores=Store::orderBy('created_at', 'desc')->pluck('name','id');
      return view('customer_types.index',compact('customer_types','stores'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(CustomerTypeRequest $request)
  {
    try {
      $data = $request->except('_token');
      $data['created_by'] = Auth::user()->id;
      $Customer_type=CustomerType::create($data);
      $output = [
        'success' => true,
        'msg' => __('lang.success')
    ];
    }catch (\Exception $e) {
        Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
        $output = [
            'success' => false,
            'msg' => __('lang.something_went_wrong')
        ];
    }
    return redirect()->back()->with('status', $output);
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
    $customertype = CustomerType::find($id);
    $stores=Store::orderBy('created_at', 'desc')->pluck('name','id');
    return view('customer_types.edit')->with(compact('customertype','stores'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(CustomerTypeUpdateRequest $request,$id)
  {
    try {
      $data = [
        'name' => $request->name,
        'translations' => !empty($request->translations) ? $request->translations : [],
        'category_id' => $request->category_id,
        'edited_by' => Auth::user()->id,
      ];
      CustomerType::find($id)->update($data);
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
      $customer_type=CustomerType::find($id);
      $customer_type->deleted_by=Auth::user()->id;
      $customer_type->save();
      $customer_type->delete();
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

?>