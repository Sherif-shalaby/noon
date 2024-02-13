<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerBalanceAdjustment;
use App\Models\Store;
use App\Models\User;
use App\Utils\Util;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerBalanceAdjustmentsController extends Controller
{
    protected $commonUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(Util $commonUtil)
    {
        $this->commonUtil = $commonUtil;
    }


    /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {

  }

  /**
   * Show the form for creating a new resource.
   *
   * @return
   */
  public function create()
  {
//      dd();
//      $stores = Store::getDropdown();
      $users = User::Notview()->pluck('name', 'id');
      $customer = Customer::find(Request()->customer_id);

      return view('customer_balance_adjustments.create')->with(compact(
//          'stores',
          'users',
          'customer',
      ));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
      try {
          DB::beginTransaction();
          $data = $request->except('_token');
          $data['current_balance'] = $this->commonUtil->num_uf($data['current_balance']);
          $data['add_new_balance'] = $this->commonUtil->num_uf($data['add_new_balance']);
          $data['new_balance'] = $this->commonUtil->num_uf($data['new_balance']);
          $data['current_dollar_balance'] = $this->commonUtil->num_uf($data['current_dollar_balance']);
          $data['add_new_dollar_balance'] = $this->commonUtil->num_uf($data['add_new_dollar_balance']);
          $data['new_dollar_balance'] = $this->commonUtil->num_uf($data['new_dollar_balance']);
          $data['date_and_time'] = Carbon::now();
          $data['created_by'] = $request->user_id;
          $customer = Customer::find($request->customer_id);
          $customer->balance = $data['new_balance'];
          $customer->dollar_balance = $data['new_dollar_balance'];
          $customer->save();

          CustomerBalanceAdjustment::create($data);
          DB::commit();
          //TODO::total_rp need to update or not based on client response
          $output = [
              'success' => true,
              'msg' => __('lang.success')
          ];
      } catch (\Exception $e) {
          Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
          dd($e);
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

}

?>
