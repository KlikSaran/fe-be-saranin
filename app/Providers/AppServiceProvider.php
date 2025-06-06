<?php

namespace App\Providers;

use App\Models\DetailTransaction;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $cartCount = 0;

            if (Auth::check()) {
                $userId = Auth::id();

                $transactionIds = Transaction::where('user_id', $userId)->pluck('id');

                $cartCount = DetailTransaction::whereIn('transaction_id', $transactionIds)->count();
            }

            $view->with('cartCount', $cartCount);
        });
    }
}
