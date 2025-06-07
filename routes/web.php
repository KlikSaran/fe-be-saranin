<?php

use App\Http\Controllers\Admin\ConsumerController as AdminConsumerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Public\BasketController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Public\CheckoutController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\IndexController;
use App\Http\Controllers\Public\ProductController;
use App\Http\Controllers\Public\ProfileController;
use App\Http\Controllers\Public\TransactionController;
use App\Http\Controllers\Public\SearchProductController;

// Public Routes
Route::resource('/', HomeController::class);

Route::middleware('auth')->group(function () {
    
    // Admin Routes
    Route::resource('/dashboards', DashboardController::class);
    Route::resource('/products', AdminProductController::class);
    Route::resource('/transactions', AdminTransactionController::class);
    Route::resource('/consumers', AdminConsumerController::class);
    
    // Public Routes
    Route::resource('/baskets-public', BasketController::class);
    Route::resource('/profiles-public', ProfileController::class);
    Route::resource('/transactions-public', TransactionController::class);
    Route::resource('/products-public', ProductController::class);
    Route::get('/checkout/preview', [CheckoutController::class, 'preview'])->name('checkout.preview');
    Route::post('/checkout/submit', [CheckoutController::class, 'submit'])->name('checkout.submit');
    Route::put('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('avatar.update');
    Route::get('/detail-product-public/{name}', [ProductController::class, 'showRecommendationProductDetail'])->name('products-recommendation-public.show');
    
    // Searching Routes
    Route::get('/search/product', [AdminProductController::class, 'search'])->name('search.product');
    Route::get('/search/transaction', [AdminTransactionController::class, 'search'])->name('search.transaction');
    Route::get('/search/consumer', [AdminConsumerController::class, 'search'])->name('search.consumer');
    Route::get('/search/consumer/product', [SearchProductController::class, 'search'])->name('search.consumer.product');

    // Logout Route
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login-submit', [LoginController::class, 'login'])->name('login.submit');
});
