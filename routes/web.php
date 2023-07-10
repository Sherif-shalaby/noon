<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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
    if (Auth::check()) {
        return view('home.index');
    } else {
        return redirect('/login');
    }
});
Route::group(['middleware' => ['auth']], function () {
    Route::resource('brands', App\Http\Controllers\BrandController::class);
    Route::get('settings/modules', [App\Http\Controllers\SettingController::class, 'getModuleSettings'])->name('getModules');
    Route::post('settings/modules', [App\Http\Controllers\SettingController::class, 'updateModuleSettings'])->name('updateModule');
    Route::resource('store',App\Http\Controllers\StoreController::class);
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    });
    //الاقسام
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::get('categories/{category?}/sub-categories', [CategoryController::class, 'subCategories'])->name('sub-categories');
});


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

// Route::get('/home', [HomeController::class, 'index'])->name('home');
