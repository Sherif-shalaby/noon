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
            $currency_precision =3;
            return "number_format($expression,  $currency_precision, '.', ',')";
        });

        //Blade directive to format date.
        Blade::directive('format_date', function ($date = null) {
            if (!empty($date)) {
                return "Carbon\Carbon::createFromTimestamp(strtotime($date))->format('m/d/Y')";
            } else {
                return null;
            }
        });
        //Blade directive to format date and time.
        Blade::directive('format_datetime', function ($date) {
            if (!empty($date)) {
                $time_format = 'h:i A';
                if (System::getProperty('time_format') == 24) {
                    $time_format = 'H:i';
                }

                return "\Carbon\Carbon::createFromTimestamp(strtotime($date))->format('m/d/Y ' . '$time_format')";
            } else {
                return null;
            }
        });

        if(Schema::hasTable('systems')){

            $module_settings = System::getProperty('module_settings');
            $module_settings = !empty($module_settings) ? json_decode($module_settings, true) : [];
            view()->share('module_settings' , $module_settings);
            $settings = System::pluck('value', 'key');
            view()->share('settings',$settings);

        }
        Paginator::useBootstrap();





    }
}
