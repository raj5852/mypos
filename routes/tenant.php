<?php

declare(strict_types=1);

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
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
    Route::resource('product', ProductController::class)->only('index', 'create', 'edit', 'destroy','show');
    Route::get('product/sellhistory/{id}',[ProductController::class,'sellhistory'])->name('product.sellhistory');
    Route::get('product/barcode/{id}',[ProductController::class,'barcode'])->name('product.barcode');
    Route::get('product/qrcode/{id}',[ProductController::class,'qrcode'])->name('product.qrcode');


    //people
    Route::resource('customer',CustomerController::class);
    Route::resource('supplier',SupplierController::class);


    Route::get('demo', function () {
        echo productcode(5);
    });

});
