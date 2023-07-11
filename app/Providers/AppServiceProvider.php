<?php

namespace App\Providers;

use App\Models\System;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
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
        Paginator::useBootstrap();
        if(Schema::hasTable('systems')){
            $module_settings = System::getProperty('module_settings');

            $module_settings = !empty($module_settings) ? json_decode($module_settings, true) : [];
            view()->share('module_settings' , $module_settings);
        }
        $settings = System::pluck('value', 'key');
        view()->share('settings' , $settings);

    }
}
