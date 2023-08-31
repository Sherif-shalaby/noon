<?php

use App\Http\Controllers\AddStockController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SellReturnController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\StorePosController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomersReportController;
use App\Http\Controllers\CustomerTypeController;
use App\Http\Controllers\DailyReportSummary;
use App\Http\Controllers\GeneralTaxController;
use App\Http\Controllers\MoneySafeController;
use App\Http\Controllers\PayableReportController;
use App\Http\Controllers\ProductTaxController;
use App\Http\Controllers\PurchasesReportController;
use App\Http\Controllers\ReceivableController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\WageController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\SellPosController;


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
Route::group(['middleware' => ['auth']], function () {
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    });

    Route::get('brands/get-dropdown', [BrandController::class,'getDropdown']);
    Route::resource('brands', BrandController::class);
    Route::resource('store', App\Http\Controllers\StoreController::class);
    Route::resource('jobs',App\Http\Controllers\JobTypeController::class);
    //employees
    Route::resource('employees',App\Http\Controllers\EmployeeController::class);
    Route::get('wages/calculate-salary-and-commission/{employee_id}/{payment_type}', [WageController::class,'calculateSalaryAndCommission']);
    Route::resource('wages',WageController::class);
    Route::get('settings/modules', [SettingController::class, 'getModuleSettings'])->name('getModules');
    Route::post('settings/modules', [SettingController::class, 'updateModuleSettings'])->name('updateModule');
    Route::post('settings/update-general-settings', [SettingController::class, 'updateGeneralSetting'])->name('settings.updateGeneralSettings');
    Route::post('settings/remove-image/{type}', [SettingController::class,'removeImage']);
    Route::resource('settings', SettingController::class);
    Route::get('stores/get-dropdown', [StoreController::class,'getDropdown']);
    Route::resource('store',StoreController::class);
    //الاقسام
    Route::get('categories/get-dropdown', [CategoryController::class,'getDropdown']);
    Route::get('category/get-subcategories/{id}', [CategoryController::class, 'getSubcategories']);
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::get('categories/{category?}/sub-categories', [CategoryController::class, 'subCategories'])->name('sub-categories');
    // colors
    Route::resource('colors', ColorController::class)->except(['show']);
    // sizes
    Route::resource('sizes', SizeController::class)->except(['show']);
    // units
    Route::get('units/get-dropdown', [UnitController::class,'getDropdown']);
    Route::resource('units', UnitController::class)->except(['show']);
    Route::get('product/get-raw-price', [ProductController::class,'getRawPrice']);

    Route::resource('products', ProductController::class);
    //customers
    Route::get('customer/get-important-date-row', [CustomerController::class,'getImportantDateRow']);
    Route::resource('customers', CustomerController::class);
    Route::resource('customertypes', CustomerTypeController::class);

    // stocks
    Route::get('add-stock/get-source-by-type-dropdown/{type}', [AddStockController::class , 'getSourceByTypeDropdown']);
    Route::get('add-stock/get-paying-currency/{currency}', [AddStockController::class , 'getPayingCurrency']);
    Route::get('add-stock/update-by-exchange-rate/{exchange_rate}', [AddStockController::class , 'updateByExchangeRate']);
    Route::view('add-stock/index', 'add-stock.index')->name('stocks.index');
    Route::view('add-stock/create', 'add-stock.create')->name('stocks.create');
    Route::get('add-stock/show/{id}',[AddStockController::class , 'show'])->name('stocks.show');
    Route::get('add-stock/add-payment/{id}',[AddStockController::class , 'addPayment'])->name('stocks.addPayment');
    Route::post('add-stock/post-payment/{id}',[AddStockController::class , 'storePayment'])->name('stocks.storePayment');

//    Route::get('add-stock/add-payment/{id}', function ($id) {
//        return view('add-stock.add-payment', compact('id'));
//    })->name('stocks.addPayment');

    // store pos
    Route::resource('store-pos', StorePosController::class);
    // ########### General Tax ###########
    Route::resource('general-tax', GeneralTaxController::class);
    // ########### Product Tax ###########
    Route::resource('product-tax', ProductTaxController::class);

     // ########### Purchases Report ###########
     Route::resource('purchases-report', PurchasesReportController::class);


    // ########### Purchases Report ###########
    Route::resource('purchases-report', PurchasesReportController::class);
    // ########### Sales Report ###########
    Route::resource('sales-report', SalesReportController::class);
    // ########### Receivable Report ###########
    Route::resource('receivable-report', ReceivableController::class);
    // ########### Payable Report ###########
    Route::resource('payable-report', PayableReportController::class);
    // ########### Customers Report ###########
    Route::resource('customers-report', CustomersReportController::class);
    // ########### Daily Report Summary ###########
    Route::resource('daily-report-summary', DailyReportSummary::class);

    // Sell Screen
    Route::view('invoices', 'invoices.index')->name('invoices.index');
    Route::view('invoices/create', 'invoices.create')->name('invoices.create');
    Route::get('invoices/{invoice}', function ($id) {
        return view('invoices.show', compact('id'));
    })->name('invoices.show');
    Route::resource('pos',SellPosController::class);

    // Sell Return
    Route::get('sale-return/add/{id}', function ($id) {
        return view('returns.sell.create', compact('id'));
    })->name('sell.return');

    // Returns
    Route::get('sell-return', [SellReturnController::class,'index'])->name('sell_return.index');

    // user check password
    Route::post('user/check-password', [HomeController::class, 'checkPassword']);
    //suppliers
    Route::resource('suppliers',SuppliersController::class);
    //money safe
    Route::post('moneysafe/post-add-money-to-safe', [MoneySafeController::class,'postAddMoneyToSafe'])->name('moneysafe.post-add-money-to-safe');
    Route::get('moneysafe/get-add-money-to-safe/{id}', [MoneySafeController::class,'getAddMoneyToSafe'])->name('moneysafe.get-add-money-to-safe');
    Route::post('moneysafe/post-take-money-to-safe', [MoneySafeController::class,'postTakeMoneyFromSafe'])->name('moneysafe.post-take-money-to-safe');
    Route::get('moneysafe/get-take-money-to-safe/{id}', [MoneySafeController::class,'getTakeMoneyFromSafe'])->name('moneysafe.get-take-money-to-safe');
    Route::get('moneysafe/watch-money-to-safe-transaction/{id}', [MoneySafeController::class,'getMoneySafeTransactions'])->name('moneysafe.watch-money-to-safe-transaction');
    Route::resource('moneysafe', MoneySafeController::class);
});


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
