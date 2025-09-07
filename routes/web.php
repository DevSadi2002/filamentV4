<?php

use App\Livewire\CancelPage;
use App\Livewire\SuccessPage;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use League\Csv\Query\Row;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', \App\Livewire\HomePage::class);
Route::get('/categories', \App\Livewire\CategoriesPage::class);
Route::get('/products', \App\Livewire\ProductsPage::class);
Route::get('/products/{slug}', \App\Livewire\ProductDetailPage::class)->name('product.details');
Route::get('/cart', \App\Livewire\CartPage::class);
Route::get('cancel', CancelPage::class);

// my order details

// login , register , rest and forget password

Route::middleware('guest')->group(function () {
    Route::get('/login', \App\Livewire\Auth\LoginPage::class);
    Route::get('/register', \App\Livewire\Auth\RegisterPage::class);
    Route::get('/reset-password/{token}/', \App\Livewire\Auth\ResetPasswordPage::class)->name('password.reset');
    Route::get('/forgot-password', \App\Livewire\Auth\ForgetPasswordPage::class)->name('password.request');
});


Route::middleware('auth')->group(
    function () {
        Route::get('/logout', function () {
            auth()->logout();
            return redirect('/');
        });
        Route::get('/checkout', \App\Livewire\CheckoutPage::class);
        Route::get('/my-orders', \App\Livewire\MyOrdersPage::class);
        Route::get('/my-orders/{order}', \App\Livewire\MyOrderDetailPage::class)->name('my-orders.details');
        Route::get('/success', SuccessPage::class);
        Route::get('/cancel', CancelPage::class);
    }
);
// end of file
