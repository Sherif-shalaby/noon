<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\App;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryupdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

      public function index()
      {
        // $categories = Category::latest()->paginate(10);
        $categories=Category::
            when(\request()->keyword != null, function ($query) {
                $query->where('name', 'like', '%' . \request()->keyword . '%')
                ->orWhere('translation->name->'.App::getLocale(), 'like', '%' . \request()->keyword . '%');
            })
            ->when(\request()->status != null, function ($query) {
                $query->whereStatus(\request()->status)??'';
            })
            ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);
        return view('categories.index',compact('categories'));
      }

    public function create()
    {
        // $cats=Category::whereNull('parent_id')->get(['id','name']);
        $cats = Category::get(['id', 'name']);
        return view('categories.create', compact('cats'));
    }

    public function store(CategoryRequest $request)
    {
        // $validator = Validator::make(
        //     $request->all(),
        //     [
        //         'name' => 'required|max:255|unique:categories,id',
        //         'status' => 'required',
        //         'parent_id' => 'nullable',
        //         'cover' => 'nullable',
        //     ],
        //     [
        //         'name.required' => __('categories.categoryNameRequired'),
        //     ]
        // );
        // if ($validator->fails()) {
        //     return response()->json(['status' => $validator->errors()->first()],[],[
        //         'name.required' => __('categories.categoryNameRequired')
        //     ]);
        // }
            $input['name']        = $request->name;
            $input['status']      = $request->status;
            $input['parent_id']   = $request->parent_id;
            if ($request->file('cover')) {
                $input['cover'] = store_file($request->file('cover'), 'categories');
            }
            if(!empty($request->translations))
            {
                $input['translation']= $request->translations;
            }else{
                $input['translation']=[];
            }
            Category::create($input);
            return response()->json(['status' => __('categories.addsuccess')]);

    }


    public function edit(Category $category)
    {
        // $cats=Category::whereNull('parent_id')->get(['id','name']);
        $cats = Category::whereNotIn('id', [$category->id])->get(['id', 'name']);
        return view('categories.edit', compact('category', 'cats'));
    }

    public function update(CategoryupdateRequest $request, Category $category)
    {
        // $validator = Validator::make(
        //     $request->all(),
        //     [
        //         'name' => 'required|max:255|unique:categories,id,'.$category->id,
        //         'status' => 'required',
        //         'parent_id' => 'nullable',
        //         'cover' => 'nullable',
        //     ],
        //     [
        //         'name.required' => __('categories.categoryNameRequired'),
        //     ]
        // );
        // if ($validator->fails()) {
        //     return response()->json(['status' => $validator->errors()->first()]);
        // }
        $input['name'] = $request->name;
        $input['status'] = $request->status;
        $input['parent_id'] = $request->parent_id;
        if ($request->file('cover')) {
            if ($category->cover != 'categorys/LOGO.png') {
                delete_file($category->getRawOriginal('cover'));
            }
            $input['cover'] = store_file($request->file('cover'), 'categories');
        }
        if(!empty($request->translations))
        {
            $input['translation']= $request->translations;
        }else{
            $input['translation']=[];
        }
        $category->update($input);
        return response()->json(['status' => __('categories.updatesuccess')]);
    }

    public function destroy(Category $category)
    {
        try {
            if ($category->cover != 'categorys/LOGO.png') {
                delete_file($category->getRawOriginal('cover'));
            }
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
    public function subCategories($id)
    {
        //  dd($category);
        $searchTerm = \request()->keyword;
        $category = Category::find($id);
        if ($category) {
            $categories = $category->subCategories()
                ->when(\request()->keyword != null, function ($query) {
                    $query->where('name', 'like', '%' . \request()->keyword . '%')
                    ->orWhere('translation->name->'.App::getLocale(), 'like', '%' . \request()->keyword . '%');
                })
                ->when(\request()->status != null, function ($query) {
                    $query->whereStatus(\request()->status) ?? '';
                })
                ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
                ->paginate(\request()->limit_by ?? 10);
        } else {
            $categories = Category::when(\request()->keyword != null, function ($query) {
                $query->where('name', 'like', '%' . \request()->keyword . '%')
                ->orWhere('translation->name->'.App::getLocale(), 'like', '%' . \request()->keyword . '%');
                })
                ->when(\request()->status != null, function ($query) {
                    $query->whereStatus(\request()->status) ?? '';
                })
                ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
                ->paginate(\request()->limit_by ?? 10);
        }

        return view('categories.index', compact('categories'));
    }
}
