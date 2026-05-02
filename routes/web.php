<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CriteriaWeightController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TopsisController;
use App\Http\Controllers\PaymentCallbackController;
use App\Http\Controllers\Admin\TopsisAdminController;
use App\Models\Criteria;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

// Landing page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Midtrans callback
Route::post('/midtrans/callback', [PaymentCallbackController::class, 'callback'])
    ->name('midtrans.callback');

// Produk public
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/produk/kategori/{id}', [ProductController::class, 'byCategory'])
    ->name('products.byCategory');

// Profil CV
Route::view('/profil', 'pages.public.profile')->name('profil');

Route::get('/contact', function () {
    return view('pages.public.contact');
})->name('contact');

// TOPSIS public
Route::get('/rekomendasi', [TopsisController::class, 'index'])->name('rekomendasi');
Route::get('/topsis/subcategories/{parentId}', [TopsisController::class, 'getSubCategories'])->name('topsis.subcategories');
Route::get('/topsis/products/{categoryId}', [TopsisController::class, 'getProducts'])->name('topsis.products');
Route::get('/topsis/criteria-ranges/{categoryId}', [TopsisController::class, 'getCriteriaRanges'])->name('topsis.criteria-ranges');
Route::post('/topsis/calculate', [TopsisController::class, 'calculate'])
    ->name('topsis.calculate');


/*
|--------------------------------------------------------------------------
| AUTH ROUTES (LOGIN REQUIRED)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/admin/orders/history', function () {
        return view('admin.orders.history');
    })->name('admin.orders.history');



    /*
    |--------------------------------------------------------------------------
    | CART & CHECKOUT
    |--------------------------------------------------------------------------
    */
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::post('/payment/success', [PaymentCallbackController::class, 'success'])
        ->name('payment.success');

    /*
    |--------------------------------------------------------------------------
    | ORDERS (GLOBAL AUTH - USER + ADMIN VIEW)
    |--------------------------------------------------------------------------
    */
    Route::get('/orders/export', [OrderController::class, 'export'])
        ->name('orders.export');

    Route::resource('orders', OrderController::class);

    /*
    |--------------------------------------------------------------------------
    | USER ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:user'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/user/dashboard', [DashboardController::class, 'index'])
            ->name('user.dashboard');

        Route::get('/user/cart', [CartController::class, 'index'])
                ->name('user.cart');
            
        Route::resource('users', UserController::class);

        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports');

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
    Route::prefix('admin')->name('admin.')->middleware(['role:admin'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'adminIndex'])
            ->name('dashboard');

        Route::get('/topsis', [TopsisAdminController::class, 'index'])
            ->name('topsis.index');
        Route::delete('/topsis/{id}', [TopsisAdminController::class, 'destroy'])
            ->name('topsis.destroy');
        
        Route::get('/notifications/count', function () {
            return response()->json([
                'count' => \App\Models\Transaction::where('status', 'pending')->count()
            ]);
        });

        /*
        | ORDERS ADMIN (FIXED)
        */
        Route::get('/orders', [OrderController::class, 'index'])
            ->name('orders.index');

        Route::get('/orders/{id}', [OrderController::class, 'show'])
            ->name('orders.show');

        Route::get('/orders/export', [OrderController::class, 'export'])
            ->name('orders.export');

        Route::get('/orders/history', [OrderController::class, 'history'])
            ->name('orders.history');

        /*
        | CRUD ADMIN
        */
        Route::resource('users', UserController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class)->except(['show']);
        Route::get('/products/{id}', [ProductController::class, 'adminShow'])->name('products.show');


        
    });

    /*
    |--------------------------------------------------------------------------
    | OWNER ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:owner'])->group(function () {

        Route::get('/owner/dashboard', [DashboardController::class, 'ownerIndex'])
            ->name('owner.dashboard');
    });

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
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