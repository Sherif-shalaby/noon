<?php

namespace App\Providers;

use App\Models\System;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        if(Schema::hasTable('systems')){
            $module_settings = System::getProperty('module_settings');

            $module_settings = !empty($module_settings) ? json_decode($module_settings, true) : [];
            view()->share('module_settings' , $module_settings);
        }
        Blade::directive('format_date', function ($date = null) {
            if (!empty($date)) {
                return "Carbon\Carbon::createFromTimestamp(strtotime($date))->format('m/d/Y')";
            } else {
                return null;
            }
        });

    }
}
