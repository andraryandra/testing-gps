<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RoleController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\RedirectAuthController;
use App\Http\Controllers\Admin\Toko\ProductController;

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
    return redirect()->route('login');
});

Route::get('/redirect', [RedirectAuthController::class, 'redirect'])->name('redirect');


Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::prefix('dashboard')->name('dashboard.')->group(function () {

        Route::get('/home/admin', [HomeController::class, 'admin'])->name('admin');
        Route::get('/home/user', [HomeController::class, 'user'])->name('user');

        Route::resource('roles', RoleController::class);
        Route::group(['middleware' => ['role:USER|Admin']], function () {
            Route::resource('users', UserController::class);
        });

        // Route::resource('users', UserController::class);
        Route::resource('products', ProductController::class);
    });
});
