<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Utils\Util;
class StoreController extends Controller
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
   * @return Application|Factory|View
   */
  public function index()
  {
      $stores = Store::all();

      return view('store.index')->with(compact(
          'stores'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Application|Factory|View
   */
  public function create()
  {
      return view('store.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return RedirectResponse
   */
// ++++++++++++++++++++++ Task : store() +++++++++++++++
  public function store(Request $request)
  {
    //  dd($request);
      $request->validate([
          'name' => 'max:255|required',
      ]);
      try {
          $data = $request->except('_token', 'quick_add');
          $data['created_by'] = Auth::user()->id;
          $store=Store::create($data);
          $output = [
              'success' => true,
              'id'=>$store->id,
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
   * @return Application|Factory|View
   */
  public function edit($id)
  {
      $store = Store::find($id);
      return view('store.edit')->with(compact('store'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return RedirectResponse
   */
  public function update(Request $request, $id)
  {
      try {
          $data = $request->except('_token', '_method');
          $data['updated_by'] = Auth::user()->id;
          $store = Store::find($id);
          $store->update($data);

          $output = [
              'success' => true,
              'id'=>$store->id,
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
      return redirect()->back()->with('status', $output);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return RedirectResponse
   */
  public function destroy($id)
  {
      try {
          $store = Store::find($id);
          $store->delete();

          $output = [
              'success' => true,
              'msg' => __('lang.success')
          ];
      }

      catch (\Exception $e) {
          Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
          $output = [
              'success' => false,
              'msg' => __('messages.something_went_wrong')
          ];
      }
      return redirect()->back()->with('status', $output);
  }
    public function getDropdown()
    {
        $stores =Store::orderBy('name', 'asc')->pluck('name', 'id');
        $stores_dp = $this->Util->createDropdownHtml($stores, __('lang.please_select'));
        return $stores_dp;
    }
}

?>
