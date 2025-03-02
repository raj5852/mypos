<?php

declare(strict_types=1);

use App\Http\Controllers\BankAccountsController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DamageController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductListController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchasePaymentController;
use App\Http\Controllers\Sale\AddPayment;
use App\Http\Controllers\Sale\ChalanPrintController;
use App\Http\Controllers\Sale\DeleteController;
use App\Http\Controllers\Sale\PrintController;
use App\Http\Controllers\Sale\SaleController;
use App\Http\Controllers\Sale\ShowController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierListController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserRoleController;



Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    Route::get('/', [AuthenticatedSessionController::class, 'create'])->middleware('guest');

    Route::middleware('auth')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Route::view('/', 'users.dashboard');
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
        Route::prefix('purchase')->group(function () {
            Route::get('invoice/{purchaseId}', [PurchaseController::class, 'invoice'])->name('purchase.invoice');
            Route::get('add-payment/{id}', [PurchaseController::class, 'addpayment'])->name('purchase.addpayment');
            Route::post('add-payment/{id}', [PurchaseController::class, 'addpaymentStore'])->name('purchase.addpaymentStore');
            Route::delete('paument/{id}', [PurchasePaymentController::class, 'delete'])->name('purchase.payment.delete');
            Route::delete('delete/{id}', [PurchasePaymentController::class, 'deletePurchase'])->name('purchase.delete');
        });

        // setting
        Route::get('setting', [SettingController::class, 'index'])->name('setting.index');
        Route::post('setting', [SettingController::class, 'store'])->name('setting.store');

        //owner
        Route::resource('owner', OwnerController::class);
        Route::prefix('owner')->group(function () {
            Route::get('invested/{id}', [OwnerController::class, 'invested'])->name('owner.invested');
            Route::get('withdraw/{id}', [OwnerController::class, 'withdraw'])->name('owner.withdraw');
        });
        //bank accounts
        Route::resource('bank', BankAccountsController::class)->only('index', 'create', 'store');

        Route::prefix('bank')->group(function () {
            Route::get('add-balance/{id}', [BankAccountsController::class, 'addbalance'])->name('bank.addbalance');
            Route::post('add-balance/{id}', [BankAccountsController::class, 'addbalanceStore'])->name('bank.addbalancestore');

            Route::get('withdraw/{id}', [BankAccountsController::class, 'withdraw'])->name('bank.withdraw');
            Route::post('withdraw/{id}', [BankAccountsController::class, 'withdrawStore'])->name('bank.withdrawStore');

            Route::get('transfer/{id}', [BankAccountsController::class, 'transfer'])->name('bank.transfer');
            Route::post('transfer/{id}', [BankAccountsController::class, 'transferStore'])->name('bank.transferStore');

            Route::get('transaction-history/{id}', [BankAccountsController::class, 'transaction'])->name('bank.transaction');
        });

        // POS
        Route::get('pos', [PosController::class, 'index'])->name('pos');

        //sales
        Route::prefix('sale')->group(function () {
            Route::get('/', [SaleController::class, 'index'])->name('sale');
            Route::get('/print/{id}', [PrintController::class, 'index'])->name('sale.print');
            Route::get('/chalan-print/{id}', [ChalanPrintController::class, 'index'])->name('sale.chalanprint');
            Route::get('/show/{id}', [ShowController::class, 'index'])->name('sale.show');
            Route::get('addpayment/{id}', [AddPayment::class, 'index'])->name('sale.addpayment');
            Route::post('addpayment/store', [AddPayment::class, 'store'])->name('sale.store');

            Route::delete('addpayment/delete/{id}', [DeleteController::class, 'addpaymentdelete'])->name('sale.addpayment.delete');
            Route::delete('order/delete/{id}', [DeleteController::class, 'delete'])->name('sale.delete');
        });
        // damage

        Route::resource('damage', DamageController::class);
        Route::resource('userrole', UserRoleController::class);
    });

    require __DIR__ . '/auth.php';

});
