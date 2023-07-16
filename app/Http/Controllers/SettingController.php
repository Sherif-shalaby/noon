<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\System;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = System::pluck('value', 'key');
        $config_languages = config('constants.langs');
        $languages = [];
        foreach ($config_languages as $key => $value) {
            $languages[$key] = $value['full_name'];
        }
        $currencies  = $this->allCurrencies();
        return view('general-settings.index',compact('settings','languages','currencies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //          get show and hide module
    public function getModuleSettings(): Factory|View|Application
    {
        $modules = User::modulePermissionArray();
        $module_settings = System::getProperty('module_settings') ? json_decode(System::getProperty('module_settings'), true) : [];

        return view('settings.module')->with(compact(
            'modules',
            'module_settings',
        ));
    }

    //          update show and hide module
    public function updateModuleSettings(Request $request): RedirectResponse
    {
        $module_settings = $request->module_settings;

        try {
            System::updateOrCreate(
                ['key' => 'module_settings'],
                ['value' => json_encode($module_settings), 'date_and_time' => Carbon::now()]
            );
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
    public function updateGeneralSetting(Request $request)
    {
        // try {
            System::updateOrCreate(
                ['key' => 'site_title'],
                ['value' => $request->site_title, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            System::updateOrCreate(
                ['key' => 'developed_by'],
                ['value' => $request->developed_by, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            System::updateOrCreate(
                ['key' => 'timezone'],
                ['value' => $request->timezone, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            System::updateOrCreate(
                ['key' => 'invoice_terms_and_conditions'],
                ['value' => $request->invoice_terms_and_conditions, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            System::updateOrCreate(
                ['key' => 'language'],
                ['value' => $request->language, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            if (!empty($request->language)) {
                session()->put('language', $request->language);
            }
            System::updateOrCreate(
                ['key' => 'currency'],
                ['value' => $request->currency, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            System::updateOrCreate(
                ['key' => 'dollar_exchange'],
                ['value' => $request->dollar_exchange, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            if (!empty($request->currency)) {
                $currency = Currency::find($request->currency);
                $currency_data = [
                    'country' => $currency->country,
                    'code' => $currency->code,
                    'symbol' => $currency->symbol,
                    'decimal_separator' => '.',
                    'thousand_separator' => ',',
                    'currency_precision' => !empty(System::getProperty('numbers_length_after_dot')) ? System::getProperty('numbers_length_after_dot') : 5,
                    'currency_symbol_placement' => 'before',
                ];
                $request->session()->put('currency', $currency_data);
            }
            System::updateOrCreate(
                ['key' => 'invoice_lang'],
                ['value' => $request->invoice_lang, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            System::updateOrCreate(
                ['key' => 'help_page_content'],
                ['value' => $request->help_page_content, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            System::updateOrCreate(
                ['key' => 'watsapp_numbers'],
                ['value' => $request->watsapp_numbers, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            $data['letter_header'] = null;
            if ($request->has('letter_header') && !is_null('letter_header')) {
                $imageData = $this->getCroppedImage($request->letter_header);
                $extention = explode(";", explode("/", $imageData)[1])[0];
                $image = rand(1, 1500) . "_image." . $extention;
                $filePath = public_path('uploads/' . $image);
                $data['letter_header'] = $image;
                $fp = file_put_contents($filePath, base64_decode(explode(",", $imageData)[1]));
            }
            $data['letter_footer'] = null;
            if ($request->has('letter_footer') && !is_null('letter_footer')) {
                $imageData = $this->getCroppedImage($request->letter_footer);
                $extention = explode(";", explode("/", $imageData)[1])[0];
                $image = rand(1, 1500) . "_image." . $extention;
                $filePath = public_path('uploads/' . $image);
                $data['letter_footer'] = $image;
                $fp = file_put_contents($filePath, base64_decode(explode(",", $imageData)[1]));
            }
            $data['logo'] = null;
            if ($request->has('logo') && !is_null('logo')) {
                $imageData = $this->getCroppedImage($request->logo);
                $extention = explode(";", explode("/", $imageData)[1])[0];
                $image = rand(1, 1500) . "_image." . $extention;
                $filePath = public_path('uploads/' . $image);
                $data['logo'] = $image;
                $fp = file_put_contents($filePath, base64_decode(explode(",", $imageData)[1]));
            }

            foreach ($data as $key => $value) {
                if (!empty($value)) {
                    System::updateOrCreate(
                        ['key' => $key],
                        ['value' => $value, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
                    );
                    if ($key == 'logo') {
                        $logo = System::getProperty('logo');
                        $request->session()->put('logo', $logo);
                    }
                }
            }
            Artisan::call("optimize:clear");
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        // } catch (\Exception $e) {
        //     Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
        //     $output = [
        //         'success' => false,
        //         'msg' => __('lang.something_went_wrong')
        //     ];
        // }

    return redirect()->back()->with('status', $output);

    }
    public function allCurrencies($exclude_array = [])
    {
        $query = Currency::select('id', DB::raw("concat(country, ' - ',currency, '(', code, ') ', symbol) as info"))
            ->orderBy('country');
        if (!empty($exclude_array)) {
            $query->whereNotIn('id', $exclude_array);
        }

        $currencies = $query->pluck('info', 'id');

        return $currencies;
    }
    function getCroppedImage($img)
    {
        if (strlen($img) < 200) {
            return $this->getBase64Image($img);
        } else {
            return $img;
        }
    }
    public function removeImage($type)
    {
        try {
            System::where('key', $type)->update(['value' => null]);
            request()->session()->put($type, null);
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
    function getBase64Image($Image)
    {
        $image_path = str_replace(env("APP_URL") . "/", "", $Image);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $image_path);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $image_content = curl_exec($ch);
        curl_close($ch);
//    $image_content = file_get_contents($image_path);
        $base64_image = base64_encode($image_content);
        $b64image = "data:image/jpeg;base64," . $base64_image;
        return $b64image;
    }
}
