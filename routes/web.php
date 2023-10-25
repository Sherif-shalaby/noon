<?php

use App\Http\Controllers\SellCarController;
use App\Models\PurchaseOrderLine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GetDueReport;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\WageController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellPosController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AddStockController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DailyReportSummary;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\GetDueReportController;
use App\Http\Controllers\InitialBalanceController;
use App\Http\Controllers\StorePosController;
use App\Http\Controllers\MoneySafeController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\ProductTaxController;
use App\Http\Controllers\ReceivableController;
use App\Http\Controllers\SellReturnController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\CustomerTypeController;
use App\Http\Controllers\PayableReportController;
use App\Http\Controllers\SupplierReportController;
use App\Http\Controllers\CustomersReportController;
use App\Http\Controllers\PurchasesReportController;
use App\Http\Controllers\PurchaseOrderLineController;
use App\Http\Controllers\CustomerOfferPriceController;
use App\Http\Controllers\CustomerPriceOfferController;
use App\Http\Controllers\GeneralTaxController;
use App\Http\Controllers\EmployeeController;
use App\Http\Livewire\CustomerPriceOffer\CustomerPriceOffer;
use App\Http\Controllers\RepresentativeSalaryReportController;

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
    // Home cards route
    Route::get('returns', function () {
        return view('returns.index');
    })->name('returns');

    Route::get('settings/all', function () {
        return view('settings.index');
    })->name('settings.all');

    Route::get('reports/all', function () {
        return view('reports.index');
    })->name('reports.all');

    Route::get('brands/get-dropdown', [BrandController::class,'getDropdown']);
    Route::resource('brands', BrandController::class);
    Route::resource('store', App\Http\Controllers\StoreController::class);
    Route::resource('jobs',App\Http\Controllers\JobTypeController::class);
    //employees
    Route::resource('employees',App\Http\Controllers\EmployeeController::class);
    Route::get('add_point', [App\Http\Controllers\EmployeeController::class,'addPoints'])->name('employees.add_points');
    // +++++++++++++++++++++++ filters of "employees products" +++++++++++++++++++++
    Route::get('/employees/filter/{id}', [App\Http\Controllers\EmployeeController::class,'filterProducts']);
    // store() method
    // Route::post('/products', 'ProductController@store');

    // Wages
    Route::resource('wages',WageController::class);
    Route::get('wages/calculate-salary-and-commission/{employee_id}/{payment_type}', [WageController::class,'calculateSalaryAndCommission'])->name('calculateSalaryAndCommission');
    Route::post('wages/update-other-payment/', [WageController::class,'update_other_payment'])->name('update_other_payment');
    Route::get('settings/modules', [SettingController::class, 'getModuleSettings'])->name('getModules');
    Route::post('settings/modules', [SettingController::class, 'updateModuleSettings'])->name('updateModule');
    // Get "مصدر الاموال" depending on "طريقة الدفع"
    Route::get('/wage/get-source-by-type-dropdown/{type}', [WageController::class,'getSourceByTypeDropdown']);

    // +++++++++++++++++++++++++++ general-settings ++++++++++++++++++++
    Route::post('settings/update-general-settings', [SettingController::class, 'updateGeneralSetting'])->name('settings.updateGeneralSettings');
    // // general_setting : fetch "state" of selected "country" selectbox
    // Route::post('api/fetch-state',[SettingController::class,'fetchState']);
    // // general_setting : fetch "city" of selected "state" selectbox
    // Route::post('api/fetch-cities',[SettingController::class,'fetchCity']);

    Route::post('settings/remove-image/{type}', [SettingController::class,'removeImage']);
    Route::resource('settings', SettingController::class);
    Route::get('stores/get-dropdown', [StoreController::class,'getDropdown']);
    Route::resource('store',StoreController::class);
    //الاقسام
    Route::get('categories/get-dropdown/{category_id}', [CategoryController::class,'getDropdown']);
    Route::get('category/get-subcategories/{id}', [CategoryController::class, 'getSubcategories']);
    // employees subcategory
    Route::get('employees/get-subcategories/{id}', [EmployeeController::class, 'getSubcategories']);
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::get('categories/{category?}/sub-categories', [CategoryController::class, 'subCategories'])->name('sub-categories');
    Route::get('categories/sub_category_modal', [CategoryController::class, 'getSubCategoryModal'])->name('categories.sub_category_modal');
    // colors
    Route::resource('colors', ColorController::class)->except(['show']);
    // sizes
    Route::resource('sizes', SizeController::class)->except(['show']);
    // units
    Route::get('units/get-unit-data/{id}', [UnitController::class,'getUnitData']);
    Route::get('units/get-dropdown', [UnitController::class,'getDropdown']);
    Route::resource('units', UnitController::class)->except(['show']);
    Route::get('product/get-raw-price', [ProductController::class,'getRawPrice']);
    Route::get('product/get-raw-unit', [ProductController::class,'getRawUnit']);
    Route::post('product/multiDeleteRow', [ProductController::class,'multiDeleteRow']);
    Route::get('product/remove_damage/{id}', [ProductController::class,'get_remove_damage'])->name('get_remove_damage');
    Route::get('product/create/{id}/getDamageProduct', [ProductController::class,'getDamageProduct'])->name("getDamageProduct");
    Route::resource('products', ProductController::class);
    //customers
    Route::get('customer/get-important-date-row', [CustomerController::class,'getImportantDateRow']);
    Route::resource('customers', CustomerController::class);
    Route::resource('customertypes', CustomerTypeController::class);
    Route::get('customer/get-dropdown', [CustomerController::class,'getDropdown']);


    // stocks

    //    Route::get('add-stock/get-source-by-type-dropdown/{type}', [AddStockController::class , 'getSourceByTypeDropdown']);
    //    Route::get('add-stock/get-paying-currency/{currency}', [AddStockController::class , 'getPayingCurrency']);
    //    Route::get('add-stock/update-by-exchange-rate/{exchange_rate}', [AddStockController::class , 'updateByExchangeRate']);
    Route::view('add-stock/index', 'add-stock.index')->name('stocks.index');
    Route::view('add-stock/create', 'add-stock.create')->name('stocks.create');
    Route::view('add-stock/{id}/edit/', 'add-stock.edit')->name('stocks.edit');
    Route::get('add-stock/show/{id}',[AddStockController::class , 'show'])->name('stocks.show');
    Route::get('add-stock/add-payment/{id}',[AddStockController::class , 'addPayment'])->name('stocks.addPayment');
    Route::post('add-stock/post-payment/{id}',[AddStockController::class , 'storePayment'])->name('stocks.storePayment');
    Route::delete('add-stock/{id}/delete',[AddStockController::class , 'destroy'])->name('stocks.delete');

    // Initial Balance
    Route::get('initial-balance/get-raw-unit', [InitialBalanceController::class,'getRawUnit']);
    Route::resource('initial-balance', InitialBalanceController::class);
    Route::get('suppliers/get-dropdown', [SuppliersController::class,'getDropdown']);
    Route::get('balance/get-raw-product', [ProductController::class,'getRawProduct']);
    //delivery
    Route::resource('delivery',  DeliveryController::class);
    // Route::get('delivery/edit/{id}',   [DeliveryController::class,'edit'])->name('delivery.edit');
    Route::get('delivery/create/{id}', [DeliveryController::class,'create'])->name('delivery.create');
    Route::get('plans', [DeliveryController::class,'plansList'])->name('delivery_plan.plansList');
    Route::post('delivery_plan/sign-in', [DeliveryController::class,'signIn']);
    Route::post('delivery_plan/sign-out', [DeliveryController::class,'signOut']);

    // Route::get('delivery/maps', [DeliveryController::class,'index'])->name('delivery.maps');


    //    Route::get('add-stock/add-payment/{id}', function ($id) {
    //        return view('add-stock.add-payment', compact('id'));
    //    })->name('stocks.addPayment');

    // store pos
    Route::resource('store-pos', StorePosController::class);
    // ########### General Tax ###########
    Route::resource('general-tax', GeneralTaxController::class);
    // ########### Product Tax ###########
    Route::get('product-tax/get-dropdown', [ProductTaxController::class,'getDropdown']);
    Route::resource('product-tax', ProductTaxController::class);
    // ########### Purchases Report ###########
    Route::resource('purchases-report', PurchasesReportController::class);
    // ########### Sales Report ###########
    Route::resource('sales-report', SalesReportController::class);
    // ########### Receivable Report ###########
    Route::resource('receivable-report', ReceivableController::class);
    // ########### Payable Report ###########
    Route::resource('payable-report', PayableReportController::class);
    // ########### Get Due Report ###########
    Route::resource('get-due-report', GetDueReportController::class);
    // ########### Supplier Report ###########
    Route::resource('get-supplier-report', SupplierReportController::class);
    // ########### Customers Report ###########
    Route::resource('customers-report', CustomersReportController::class);
    // ########### Daily Report Summary ###########
    Route::resource('daily-report-summary', DailyReportSummary::class);
    // ########### Purchase Order ###########
    Route::resource('purchase_order', PurchaseOrderLineController::class);

    // ########### representative salary report ###########
    Route::resource('representative_salary_report', RepresentativeSalaryReportController::class);
    // ajax request : get_product_search
    Route::get('search', [PurchaseOrderLineController::class,'search'])->name('purchase_order.search');
    // selected_products : Add All Selected Product
    Route::get('/selected-product',[PurchaseOrderLineController::class,'deleteAll'])->name('product.delete');
    // Sell Screen
    Route::view('invoices', 'invoices.index')->name('invoices.index');
    Route::view('invoices/create', 'invoices.create')->name('invoices.create');
    Route::get('invoices/{invoice}', function ($id) {
        return view('invoices.show', compact('id'));
    })->name('invoices.show');
    Route::get('invoices/edit/{invoice}', function ($id) {
        return view('invoices.edit', compact('id'));
    })->name('invoices.edit');
    Route::resource('pos',SellPosController::class);
    Route::get('print/invoice/{id}',[SellPosController::class, 'print'])->name('print_invoice');
    // ################################# Task : customer_price_offer #################################
    Route::view('customer_price_offer/index', 'customer_price_offer.index')->name('customer_price_offer.index');
    Route::view('customer_price_offer/create', 'customer_price_offer.create')->name('customer_price_offer.create');
    Route::view('customer_price_offer/edit/{id}', 'customer_price_offer.edit')->name('customer_price_offer.edit');
    // Route::get('customer_price_offer/edit/{id}', [CustomerOfferPriceController::class,'edit'])->name('customer_price_offer.edit');
    Route::delete('/customer_price_offer/delete/{id}', [CustomerOfferPriceController::class, 'destroy'])->name('customer_price_offer.destroy');;

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
    // general_setting : fetch "state" of selected "country" selectbox
    Route::post('api/fetch-state',[SuppliersController::class,'fetchState']);
    // general_setting : fetch "city" of selected "state" selectbox
    Route::post('api/fetch-cities',[SuppliersController::class,'fetchCity']);

    //money safe
    Route::post('moneysafe/post-add-money-to-safe', [MoneySafeController::class,'postAddMoneyToSafe'])->name('moneysafe.post-add-money-to-safe');
    Route::get('moneysafe/get-add-money-to-safe/{id}', [MoneySafeController::class,'getAddMoneyToSafe'])->name('moneysafe.get-add-money-to-safe');
    Route::post('moneysafe/post-take-money-to-safe', [MoneySafeController::class,'postTakeMoneyFromSafe'])->name('moneysafe.post-take-money-to-safe');
    Route::get('moneysafe/get-take-money-to-safe/{id}', [MoneySafeController::class,'getTakeMoneyFromSafe'])->name('moneysafe.get-take-money-to-safe');
    Route::get('moneysafe/watch-money-to-safe-transaction/{id}', [MoneySafeController::class,'getMoneySafeTransactions'])->name('moneysafe.watch-money-to-safe-transaction');
    Route::resource('moneysafe', MoneySafeController::class);

    // sell car
    Route::resource('sell-car', SellCarController::class);

    // branch
    Route::resource('branches',BrandController::class);


    Route::post('api/fetch-customers-by-city',[DeliveryController::class,'fetchCustomerByCity']);
});

Route::get('create-or-update-system-property/{key}/{value}', [SettingController::class,'createOrUpdateSystemProperty'])->middleware('timezone');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
