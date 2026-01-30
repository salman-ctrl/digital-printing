<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CriteriaWeightController;
use App\Models\Criteria;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard User
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/criteria-weights', function () {
        return view('criteria_weights.create', [
            'criterias' => Criteria::all()
        ]);
    })->name('criteria-weights.create');

    Route::post('/criteria-weights', [CriteriaWeightController::class, 'store'])
    ->name('criteria-weights.store');

    // =========================
    // KATALOG PRODUK
    // =========================
    // Route::get('/products', ...);
    // Route::get('/products/{product}', ...);

    // =========================
    // TOPSIS
    // =========================
    // Route::get('/topsis', ...);
    // Route::post('/topsis/calculate', ...);

    // =========================
    // CART
    // =========================
    // Route::get('/cart', ...);
    // Route::post('/cart/add', ...);
    // Route::delete('/cart/remove/{id}', ...);

    // =========================
    // CHECKOUT & TRANSACTION
    // =========================
    // Route::get('/checkout', ...);
    // Route::post('/checkout/process', ...);

    // =========================
    // PAYMENT (MIDTRANS)
    // =========================
    // Route::get('/payment/{transaction}', ...);
    // Route::post('/payment/callback', ...);

    // =========================
    // RIWAYAT TRANSAKSI
    // =========================
    // Route::get('/transactions', ...);
    // Route::get('/transactions/{id}', ...);

    Route::get('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
});


});

require __DIR__.'/auth.php';

