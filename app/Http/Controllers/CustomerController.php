<?php 

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Models\Customer;
use App\Models\CustomerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller 
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
      $customers=Customer::latest()->get();
      return view('customers.index',compact('customers'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    $customer_types=CustomerType::latest()->pluck('name','id');
    return view('customers.create',compact('customer_types'));

  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(CustomerRequest $request)
  {
    try {
      $data = $request->except('_token');
      $data['created_by']=Auth::user()->id;
      $customer = Customer::create($data);
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
    if ($request->quick_add) {
      return $output;
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
    $customer = Customer::find($id);
    $customer_types = CustomerType::pluck('name', 'id');

    return view('customers.edit')->with(compact(
        'customer',
        'customer_types',
    ));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(CustomerUpdateRequest $request,$id)
  {
    try {
      $data = $request->except('_token');
      $data['name'] = $request->name;
      $data['updated_by'] = Auth::user()->id;
      Customer::find($id)->update($data);
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
      $customer=Customer::find($id);
      $customer->deleted_by=Auth::user()->id;
      $customer->save();
      $customer->delete();
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