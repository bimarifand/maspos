<?php

use Livewire\Livewire;
use App\Models\Product;
use App\Livewire\Page\Home;
use App\Livewire\Page\About;
use App\Livewire\Page\Contact;
use App\Livewire\Page\CartComponent;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Livewire\Page\CheckoutComponent;

Route::middleware('redirect.if.not.loggedin')->group(function () {
    Route::get('/' , Home::class)->name('home');
    Route::get('/cart', CartComponent::class)->name('cart.index');
    Route::get('/checkout', CheckoutComponent::class)->name('checkout');
    Route::get('/checkout/{orderId}', CheckoutComponent::class)->name('checkout')->middleware('auth');
});
