<?php

use App\Models\Toko\OfficialStore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RoleController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\VisitSalesController;
use App\Http\Controllers\Auth\RedirectAuthController;
use App\Http\Controllers\Admin\Toko\ProductController;
use App\Http\Controllers\Admin\VisitSchedulesController;
use App\Http\Controllers\Admin\Toko\OfficialStoreController;

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

Route::get('/map', [MapController::class, 'index'])->name('map.index');


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

        Route::controller(CategoriesController::class)->group(function () {
            Route::get('/categories', 'index')->name('categories.index');
            Route::get('/categories/create', 'create')->name('categories.create');
            Route::post('/categories', 'store')->name('categories.store');
            Route::get('/categories/{id}', 'show')->name('categories.show');
            Route::get('/categories/{id}/edit', 'edit')->name('categories.edit');
            Route::put('/categories/{id}', 'update')->name('categories.update');
            Route::delete('/categories/{id}', 'destroy')->name('categories.destroy');
        });

        Route::controller(OfficialStoreController::class)->group(function () {
            Route::get('/official-store', 'index')->name('official-store.index');
            Route::get('/official-store/create', 'create')->name('official-store.create');
            Route::post('/official-store', 'store')->name('official-store.store');
            Route::get('/official-store/{id}', 'show')->name('official-store.show');
            Route::get('/official-store/{id}/edit', 'edit')->name('official-store.edit');
            Route::put('/official-store/{id}', 'update')->name('official-store.update');
            Route::delete('/official-store/{id}', 'destroy')->name('official-store.destroy');
            Route::get('/official-stores/load-new-data', 'loadNewData')->name('official-store.loadNewData');
        });

        Route::controller(VisitSchedulesController::class)->group(function () {
            Route::get('/visit-schedules', 'index')->name('visit-schedules.index');
            Route::get('/visit-schedules/create', 'create')->name('visit-schedules.create');
            Route::post('/visit-schedules', 'store')->name('visit-schedules.store');
            Route::get('/visit-schedules/{id}', 'show')->name('visit-schedules.show');
            Route::get('/visit-schedules/{id}/edit', 'edit')->name('visit-schedules.edit');
            Route::put('/visit-schedules/{id}', 'update')->name('visit-schedules.update');
            Route::delete('/visit-schedules/{id}', 'destroy')->name('visit-schedules.destroy');
        });

        Route::controller(VisitSalesController::class)->group(function () {
            Route::get('/visit-sales', 'index')->name('visit-sales.index');

            Route::get('/visit-sales/create', 'create')->name('visit-sales.create');
            Route::get('/get-store-location', 'getStoreLocation')->name('visit-sales.json.location');
            Route::post('/visit-sales', 'store')->name('visit-sales.store');
            Route::put('/visit-sales/check-out/{id}', 'storeVisitSalesCheckOut')->name('visit-sales.check-out');


            Route::get('/visit-sales/{id}/store-official', 'createPageVisitSales')->name('visit-sales.create.store-page');
            Route::post('/visit-sales/store-official', 'storeVisitSales')->name('visit-sales.store.store-page');

            Route::get('/visit-sales/{id}', 'show')->name('visit-sales.show');

            Route::get('/visit-sales/{id}/edit', 'edit')->name('visit-sales.edit');
            Route::put('/visit-sales/{id}', 'update')->name('visit-sales.update');

            Route::delete('/visit-sales/{id}', 'destroy')->name('visit-sales.destroy');
        });
    });
});
