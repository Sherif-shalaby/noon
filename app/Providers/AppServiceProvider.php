<?php

namespace App\Providers;

use App\Models\System;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Blade directive to format number into required format.
        Blade::directive('num_format', function ($expression) {
            $currency_precision =2;
            return "number_format($expression,  $currency_precision, '.', ',')";
        });

        //Blade directive to convert.
        Blade::directive('format_date', function ($date = null) {
            if (!empty($date)) {
                return "Carbon\Carbon::createFromTimestamp(strtotime($date))->format('m/d/Y')";
            } else {
                return null;
            }
        });
        Paginator::useBootstrap();
        if(Schema::hasTable('systems')){
            $module_settings = System::getProperty('module_settings');

            $module_settings = !empty($module_settings) ? json_decode($module_settings, true) : [];
            view()->share('module_settings' , $module_settings);
            $settings = System::pluck('value', 'key');
            view()->share('settings',$settings);
        }

        Blade::directive('format_date', function ($date = null) {
            if (!empty($date)) {
                return "Carbon\Carbon::createFromTimestamp(strtotime($date))->format('m/d/Y')";
            } else {
                return null;
            }
        });

        //Blade directive to format number into required format.
        Blade::directive('num_format', function ($expression) {
            $currency_precision =2;
            return "number_format($expression,  $currency_precision, '.', ',')";
        });

    }
}
