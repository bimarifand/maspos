<?php

namespace App\Livewire\Page;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use Livewire\Component;

class Home extends Component
{
    public $products;
    public $total = 0;
    public $categories;
    public $selectedCategory = null;

    public function mount()
    {
        $this->categories = Category::all();
        $this->loadProducts();
        $this->calculateTotal();
    }

    public function render()
    {
        return view('livewire.page.home')
            ->layout('layouts.app');
    }

    public function loadProducts()
    {
        $query = Product::query();
        
        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }
        
        $this->products = $query->get();
    }

    public function filterCategory($categoryId = null)
    {
        $this->selectedCategory = $categoryId;
        $this->loadProducts();
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

        $this->calculateTotal();
        $this->dispatch('cartUpdated')->to('page.cart-component');
    }

    public function calculateTotal()
    {
        $this->total = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get()
            ->sum(function($item) {
                return $item->quantity * $item->product->price;
            });
    }
}