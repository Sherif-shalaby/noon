<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('home.index');
});


Route::get('settings/modules', [App\Http\Controllers\SettingController::class, 'getModuleSettings'])->name('getModules');
Route::post('settings/modules', [App\Http\Controllers\SettingController::class, 'updateModuleSettings'])->name('updateModule');
Route::resource('store',App\Http\Controllers\StoreController::class);


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
