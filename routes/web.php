<?php

use App\Http\Controllers\CategoryController;
use App\Models\Category;
use App\Models\Unit;
use Carbon\Carbon;
use Faker\Core\Number;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    // $tenant1 =App\Models\Tenant::create(['id' => 'demo']);
    // $tenant1->domains()->create(['domain' => 'demo.localhost']);
});

// Route::get('categorydadasdf', [CategoryController::class,'create']);
// test
