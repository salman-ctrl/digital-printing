<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CriteriaWeightController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Models\Criteria;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

// Public dashboard / landing page
Route::get('/', [DashboardController::class, 'public'])->name('home');

// Guest tidak bisa checkout, middleware 'auth' akan paksa login
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});

Route::get('/produk', [ProductController::class, 'index'])
    ->name('products.index');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | USER ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:user'])->group(function () {

        // Dashboard user khusus
        Route::get('/user/dashboard', function () {
            return view('user.dashboard');
        })->name('user.dashboard');

        // Bisa juga pakai controller jika ada logic khusus
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Resource CRUD
        Route::resource('users', UserController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('orders', OrderController::class);

        // Reports / Laporan
        Route::get('/reports', [ReportController::class, 'index'])->name('reports');

        // Criteria weights
        Route::get('/criteria-weights', function () {
            return view('criteria_weights.create', [
                'criterias' => Criteria::all()
            ]);
        })->name('criteria-weights.create');

        Route::post('/criteria-weights', [CriteriaWeightController::class, 'store'])
            ->name('criteria-weights.store');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin'])->group(function () {

        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        // TODO: CRUD kategori, produk, kriteria admin
    });

    /*
    |--------------------------------------------------------------------------
    | OWNER ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:owner'])->group(function () {

        Route::get('/owner/dashboard', function () {
            return view('owner.dashboard');
        })->name('owner.dashboard');

        // TODO: laporan & hasil TOPSIS
    });

    /*
    |--------------------------------------------------------------------------
    | LOGOUT ROUTE
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});

require __DIR__.'/auth.php';

