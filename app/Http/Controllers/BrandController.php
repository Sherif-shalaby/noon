<?php 

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Utils\Util;
class BrandController extends Controller 
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
  public function index()
  {
    $brands=Brand::all();
    return view('brands.index',compact('brands'));
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
  public function store(BrandRequest $request)
  {
    //     $this->validate(
    //       $request,
    //       ['name' => ['required','unique:brands,name,NULL,id,deleted_at,NULL', 'max:255']
    //       ]
    //   );

      try {
          $data = $request->except('_token');
          // $data['created_by']=Auth::user()->id;
          $brand = Brand::create($data);
          $output = [
              'success' => true,
              'id' => $brand->id,
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
        $brand = Brand::find($id);
        return view('brands.edit')->with(compact(
            'brand'
        ));
    }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(BrandUpdateRequest $request,Brand $brand)
  {
  //   $this->validate(
  //     $request,
  //     ['name' => ['required', 'unique:brands,name,'.$id,'max:255']],
  // );

  try {
      $data['name'] = $request->name;
      // $data['edited_by'] = Auth::user()->id;
      $brand->update($data);
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
      Brand::find($id)->delete();
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
  
  public function getDropdown()
    {
        $brands = Brand::orderBy('name', 'asc')->pluck('name', 'id');
        $brands_dp = $this->Util->createDropdownHtml($brands, __('lang.please_select'));
        return $brands_dp;
    }
}

?>