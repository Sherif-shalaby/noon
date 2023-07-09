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

class StoreController extends Controller
{

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
  public function store(Request $request): RedirectResponse
  {
//      dd($request);
      $request->validate([
          'name' => 'max:255|required',
      ]);
      try {
          $data = $request->except('_token', 'quick_add');
          $data['created_by'] = Auth::user()->id;
          Store::create($data);
          $output = [
              'success' => true,
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
