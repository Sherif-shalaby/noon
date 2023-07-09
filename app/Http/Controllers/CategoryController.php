<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class CategoryController extends Controller
{

//   public function index()
//   {
//     // $categories = Category::latest()->paginate(10);
//     $categories=Category::
//         when(\request()->keyword != null, function ($query) {
//             $query->where('name', 'like', '%' . \request()->keyword . '%');
//         })
//         ->when(\request()->status != null, function ($query) {
//             $query->whereStatus(\request()->status)??'';
//         })
//         ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
//         ->paginate(\request()->limit_by ?? 10);
//     return view('categories.index',compact('categories'));
//   }

  public function create()
  {
    // $cats=Category::whereNull('parent_id')->get(['id','name']);
    $cats=Category::get(['id','name']);
    return view('categories.create',compact('cats'));
  }

  public function store(CategoryRequest $request)
  {
    try {
        $input['name'] = $request->name;
        $input['status'] = $request->status;
        $input['parent_id'] = $request->parent_id;
        Category::create($input);
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
    return redirect()->route('categories.index')->with('status', $output);
  }


  public function edit(Category $category)
  {
    // $cats=Category::whereNull('parent_id')->get(['id','name']);
    $cats=Category::whereNotIn('id', [$category->id])->get(['id','name']);
    return view('categories.edit',compact('category','cats'));
  }

  public function update(CategoryRequest $request, Category $category)
  {
    try {
        $input['name'] = $request->name;
        $input['status'] = $request->status;
        $input['parent_id'] = $request->parent_id;
        $category->update($input);
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
    return redirect()->route('categories.index')->with('status', $output);
  }

  public function destroy(Category $category)
  {
    try {
        $category->delete();
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
    public function subCategories($id){
        //  dd($category);
        $category = Category::find($id);
        if($category){
            $categories = $category->subCategories()
            ->when(\request()->keyword != null, function ($query) {
                $query->where('name', 'like', '%' . \request()->keyword . '%');
            })
            ->when(\request()->status != null, function ($query) {
                $query->whereStatus(\request()->status)??'';
            })
            ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);
        }else{
            $categories=Category::
            when(\request()->keyword != null, function ($query) {
                $query->where('name', 'like', '%' . \request()->keyword . '%');
            })
            ->when(\request()->status != null, function ($query) {
                $query->whereStatus(\request()->status)??'';
            })
            ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);
        }

        return view('categories.index',compact('categories'));
    }
}


