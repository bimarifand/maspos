<?php

namespace App\Livewire\Page;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Livewire\Component;

class CartComponent extends Component
{
    public $cartItems = [];
    public $total = 0;

    public function getListeners()
    {
        return [
            'cartUpdated' => 'loadCart',
        ];
    }


    public function mount()
    {
        $this->loadCart();
    }

    public function decrementQuantity($cartItemId)
    {
        $cartItem = Cart::find($cartItemId);
        if ($cartItem->quantity > 1) {
            $cartItem->quantity--;
            $cartItem->save();
        } else {
            $cartItem->delete();
        }
        $this->loadCart();
    }

    public function incrementQuantity($cartItemId)
    {
        $cartItem = Cart::find($cartItemId);
        $cartItem->quantity++;
        $cartItem->save();
        $this->loadCart();
    }

    public function removeItem($cartItemId)
    {
        Cart::destroy($cartItemId);
        $this->loadCart();
    }

    public function render()
    {
        return view('livewire.page.cart-component')
            ->layout('layouts.app');
    }

    public function loadCart()
    {
        $this->cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        $this->calculateTotal();
    }

    private function calculateTotal()
    {
        $this->total = $this->cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });
    }

    public function checkout()
{
    if ($this->cartItems->isEmpty()) {
        session()->flash('error', 'Your cart is empty');
        return;
    }

    try {
        // Buat order baru
        $order = Order::create([
            'user_id' => auth()->id(),
            'total' => $this->total,
            'items' => $this->cartItems->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ];
            })->toArray(),
        ]);
    
        // Hapus item dari cart setelah di-checkout
        Cart::where('user_id', auth()->id())->delete();
    
        // Set session success message
        session()->flash('success', 'Payment Successful');
    
        // Arahkan ke halaman checkout dengan orderId
        return redirect()->route('checkout', ['orderId' => $order->id]);
    } catch (\Exception $e) {
        // Log error
        \Log::error('Checkout Error: ' . $e->getMessage());
        
        session()->flash('error', 'An error occurred during checkout. Please try again.');
    }
}
    
}
