<div class="flex flex-col items-center justify-center h-screen">
    @if(session()->has('success'))
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <h2 class="text-2xl font-bold mb-2">Payment Successful</h2>
            <div class="bg-green-500 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-white">&#10003;</span>
            </div>
            <p class="text-lg">Total: Rp. {{ number_format($total, 0, ',', '.') }}</p>
            <a href="{{ route('home') }}" class="mt-4 inline-block bg-blue-300 text-white px-4 py-2 rounded">Back to Home</a>
        </div>
    @else
        <h2 class="text-2xl font-bold mb-4">Shopping Cart</h2>
        @if(count($cartItems) > 0)
            <table class="w-full mb-8">
                <thead>
                    <tr>
                        <th class="text-left">Product</th>
                        <th class="text-center">Qty</th>
                        <th class="text-right">Sub Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                    <tr>
                        <td class="py-4">
                            <div class="flex items-center">
                                <div class="w-16 h-16 bg-blue-500 mr-4"></div>
                                <div>
                                    <p class="font-bold">{{ $item->product->name }}</p>
                                    <p>Rp. {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="flex items-center justify-center">
                                <button wire:click="decrementQuantity({{ $item->id }})" class="bg-blue-500 text-white rounded-full w-8 h-8">-</button>
                                <span class="mx-2">{{ $item->quantity }}</span>
                                <button wire:click="incrementQuantity({{ $item->id }})" class="bg-blue-500 text-white rounded-full w-8 h-8">+</button>
                            </div>
                        </td>
                        <td class="text-right">
                            Rp. {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}
                        </td>
                        <td class="text-right">
                            <button wire:click="removeItem({{ $item->id }})" class="bg-red-500 text-white px-4 py-2 rounded">Remove Item</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-right font-bold">Total</td>
                        <td class="text-right font-bold">Rp. {{ number_format($total, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            <div class="flex justify-between">
                <a href="{{ route('home') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded">Continue Shopping</a>
                <button wire:click="checkout" class="bg-blue-300 text-white-700 px-6 py-2 rounded">Checkout</button>
            </div>
        @else
            <p>Your cart is empty.</p>
        @endif
    @endif
</div>
