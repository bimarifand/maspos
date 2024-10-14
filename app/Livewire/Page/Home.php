<?php

namespace App\Livewire\Page;

use App\Models\Cart;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class Home extends Component
{
    public $products;

    public function mount()
    {
        $this->products = Product::all();
    }

    public function render()
    {
        return view('livewire.page.home')
            ->layout('layouts.app');
    }

    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);
        $cartItem = Cart::where('user_id', auth()->id())
                    ->where('product_id', $productId)
                    ->first();

        if ($cartItem) {
        $cartItem->quantity += 1;
        $cartItem->save();
            } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }       

        $this->dispatch('cartUpdated')->to('page.cart-component');
}
}
