<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SizeController extends Controller
{
    public function index(){
        $sizes = Size::latest()->paginate(10);
        return view('sizes.index', compact('sizes'));
    }
    public function store(Request $request){
        $this->validate(
            $request,
            ['name' => ['required', 'unique:sizes,name', 'max:255']]
        );
        try {
            $input['name'] = $request->name;
            $input['slug'] = Str::slug($request->name);
            if (!empty($request->translations)) {
                $input['translation'] = $request->translations;
            } else {
                $input['translation'] = [];
            }
            Size::create($input);
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
    public function update(Request $request, Size $size){
        $this->validate(
            $request,
            ['name' => ['required', 'unique:sizes,name,' . $size->id, 'max:255']],
        );

        try {
            $input['name'] = $request->name;
            $input['slug'] = Str::slug($request->name);
            if (!empty($request->translations)) {
                $input['translation'] = $request->translations;
            } else {
                $input['translation'] = [];
            }
            $size->update($input);
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
    public function destroy(Size $size){
        try {
            $size->delete();
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
