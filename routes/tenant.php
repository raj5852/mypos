<?php

declare(strict_types=1);

use App\Http\Controllers\BankAccountsController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductListController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierListController;
use App\Http\Controllers\UnitController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,

])->group(function () {
    // Route::get('/', function () {
    //     return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    // });


    Route::view('/', 'users.dashboard');
    Route::resource('units', UnitController::class)->only('index', 'create', 'destroy');
    Route::resource('category', CategoryController::class)->only('index', 'create', 'edit', 'destroy');
    Route::resource('brand', BrandController::class)->only('index', 'create', 'edit', 'destroy');

    //product add
    Route::resource('product', ProductController::class)->only('index', 'create', 'edit', 'destroy', 'show');
    Route::get('product/sellhistory/{id}', [ProductController::class, 'sellhistory'])->name('product.sellhistory');
    Route::get('product/barcode/{id}', [ProductController::class, 'barcode'])->name('product.barcode');
    Route::get('product/qrcode/{id}', [ProductController::class, 'qrcode'])->name('product.qrcode');


    //people
    Route::resource('customer', CustomerController::class);
    Route::resource('supplier', SupplierController::class);

    //stock
    Route::get('stock', [StockController::class, 'index'])->name('product.stock');
    Route::get('product-list', ProductListController::class)->name('product-list');
    Route::get('supplier-list', SupplierListController::class)->name('supplier-list');

    //purchase
    Route::resource('purchase', PurchaseController::class);
    Route::get('purchase/invoice/{purchaseId}', [PurchaseController::class, 'invoice'])->name('purchase.invoice');

    // setting
    Route::get('setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('setting', [SettingController::class, 'store'])->name('setting.store');

    //owner
    Route::resource('owner', OwnerController::class);
    //bank accounts
    Route::resource('bank', BankAccountsController::class)->only('index', 'create', 'store');

    Route::prefix('bank')->group(function () {
        Route::get('add-balance/{id}', [BankAccountsController::class, 'addbalance'])->name('bank.addbalance');
        Route::post('add-balance/{id}', [BankAccountsController::class, 'addbalanceStore'])->name('bank.addbalancestore');

        Route::get('withdraw/{id}', [BankAccountsController::class, 'withdraw'])->name('bank.withdraw');
        Route::post('withdraw/{id}', [BankAccountsController::class, 'withdrawStore'])->name('bank.withdrawStore');

        Route::get('transfer/{id}',[BankAccountsController::class,'transfer'])->name('bank.transfer');
        Route::post('transfer/{id}',[BankAccountsController::class,'transferStore'])->name('bank.transferStore');
        Route::get('transaction-history/{id}',[BankAccountsController::class,'transaction'])->name('bank.transaction');
    });



    Route::get('demo', function () {
    });
});
