<?php

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

    Route::resource('class', 'ClassController');
    Route::resource('category', 'CategoryController');
    Route::resource('product', 'ProductController');
    Route::resource('brand', 'BrandController');
    Route::resource('currency', 'CurrencyController');
    Route::resource('store', 'StoreController');
    Route::resource('productstore', 'ProductStoreController');
    Route::resource('customer', 'CustomerController');
    Route::resource('customertype', 'CustomerTypeController');
    Route::resource('customerbalanceadjustments', 'CustomerBalanceAdjustmentsController');
    Route::resource('employee', 'EmployeeController');
    Route::resource('jobtype', 'JobTypeController');
    Route::resource('exchangerates', 'ExchangeRatesController');
    Route::resource('productdiscount', 'ProductDiscountController');

    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    });
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

// Route::get('/home', [HomeController::class, 'index'])->name('home');
