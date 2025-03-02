<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;


Route::redirect('/', 'register');
Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');
Route::post('register', [RegisteredUserController::class, 'store']);
