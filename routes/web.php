<?php

use App\Livewire\CancelPage;
use App\Livewire\SuccessPage;
use Illuminate\Support\Facades\Route;
use League\Csv\Query\Row;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', \App\Livewire\HomePage::class);
Route::get('/categories', \App\Livewire\CategoriesPage::class);
Route::get('/products', \App\Livewire\ProductsPage::class);
Route::get('/cart', \App\Livewire\CartPage::class);
Route::get('/product/{product}', \App\Livewire\ProductDetailPage::class)->name('product.details');
Route::get('/checkout', \App\Livewire\CheckoutPage::class);
Route::get('/my-orders', \App\Livewire\MyOrdersPage::class);
Route::get('cancel', CancelPage::class);

// my order details
Route::get('/my-orders/{order}', \App\Livewire\MyOrderDetailPage::class)->name('my-orders.details');

Route::get('cancel', CancelPage::class);
Route::get('success', SuccessPage::class);
// login , register , rest and forget password
Route::get('/login', \App\Livewire\Auth\LoginPage::class);
Route::get('/register', \App\Livewire\Auth\RegisterPage::class);
Route::get('/reset-password', \App\Livewire\Auth\RestPasswordPage::class);
Route::get('/forgot-password', \App\Livewire\Auth\ForgetPasswordPage::class);
// end of file
