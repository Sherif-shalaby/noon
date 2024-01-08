<?php

namespace App\Http\Controllers;

use App\Http\Requests\BranchRequest;
use App\Models\Branch;
use App\Models\Store;
use App\Utils\Util;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Routing\Annotation\Route;

class BranchController extends Controller
{
    protected $Util;
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
        $branches = Branch::where('type','branch')->get();
        return view('branches.index',compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $stores=Store::orderBy('created_at', 'desc')->pluck('name','id');
        return view('branches.create',compact('stores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(BranchRequest $request)
    {
        try {
//            dd($request);
            DB::beginTransaction();

            $branch = new Branch();
            $branch->name = $request->name;
            $branch->type = 'branch';
            $branch->created_by  = Auth::user()->id;
            $branch->save();

            if(!empty($request->stores)){
                foreach ($request->stores as $store){
                    $s = Store::find($store);
                    $s->branch_id = $branch->id;
                    $s->save();
                }
            }
            DB::commit();
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
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $branch = Branch::find($id);
        $stores=Store::orderBy('created_at', 'desc')->pluck('name','id');
        return view('branches.edit',compact('branch','stores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $branch = Branch::find($id);
            $branch->name = $request->name;
            $branch->edited_by = Auth::user()->id;

            $branch->save();

            foreach ($branch->stores as $store){
                $store->branch_id = null;
                $store->save();
            }
            if(!empty($request->stores)){
                foreach ($request->stores as $store){
                    $s = Store::find($store);
                    $s->branch_id = $branch->id;
                    $s->save();
                }
            }
            DB::commit();
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
            dd($e);
        }
        return redirect()->back()->with('status', $output);

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
            $branch=Branch::find($id);
            $branch->deleted_by=Auth::user()->id;
            $branch->save();
            $branch->delete();
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
    public function getBranchStores($ids){
        $branchIds = explode(',', $ids);

        $stores = Store::whereIn('branch_id',$branchIds)->orderBy('name', 'asc')->pluck('name', 'id');
        $stores_dp = $this->Util->createDropdownHtml($stores, __('lang.please_select'));
        return $stores_dp;
    }
}
