<?php

use App\Models\Product;
use App\Livewire\Page\CheckoutComponent;
use App\Livewire\Page\Home;
use App\Livewire\Page\About;
use App\Livewire\Page\Contact;
use App\Livewire\Page\CartComponent;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/cart', CartComponent::class)->name('cart.index');
Route::get('/', Home::class)->name('home');
Route::get('/checkout', CheckoutComponent::class)->name('checkout');
Route::get('/about', About::class)->name('about');
Route::get('/contact', Contact::class)->name('contact');
Route::get('/checkout/{orderId}', CheckoutComponent::class)->name('checkout')->middleware('auth');