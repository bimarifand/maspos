<?php

namespace App\Livewire\Page;

use Livewire\Component;
use App\Models\Order;

class CheckoutComponent extends Component
{
    public $order;

    public function mount($orderId)
    {
        $this->order = Order::findOrFail($orderId);
    }

    public function render()
    {
        return view('livewire.page.checkout-component')
            ->layout('layouts.app');
    }
}