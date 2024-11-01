<div class="flex flex-col min-h-screen bg-gray-50">
    <div class="flex flex-col items-center justify-center flex-grow p-6">
        @if(session()->has('success'))
            <div class="bg-white p-8 rounded-lg shadow-lg text-center max-w-md w-full">
                <h2 class="text-2xl font-bold mb-4">Payment Successful</h2>
                <div class="bg-green-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-white text-2xl">&#10003;</span>
                </div>
                <p class="text-lg mb-6">Total: Rp. {{ number_format($total, 0, ',', '.') }}</p>
                <a href="{{ route('home') }}" 
                   class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg transition hover:bg-blue-700">
                    Back to Home
                </a>
            </div>
        @else
            <div class="w-full max-w-4xl">
                <h2 class="text-2xl font-bold mb-6">Shopping Cart</h2>
                
                @if(count($cartItems) > 0)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 border-b">
                                    <th class="text-left px-6 py-4 text-gray-600">Product</th>
                                    <th class="text-center px-6 py-4 text-gray-600">Qty</th>
                                    <th class="text-right px-6 py-4 text-gray-600">Sub Total</th>
                                    <th class="px-6 py-4"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                <tr class="border-b last:border-b-0">
                                    <td class="py-6 px-6">
                                        <div class="flex items-center gap-4">
                                            <span class="text-gray-400">{{ $loop->iteration }}.</span>
                                            <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden">
                                                <img src="{{ asset('storage/' . $item->product->photo) }}" 
                                                     alt="{{ $item->product->name }}"
                                                     class="w-full h-full object-cover" />
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800">{{ $item->product->name }}</p>
                                                <p class="text-gray-600">Rp. {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6">
                                        <div class="flex items-center justify-center gap-3">
                                            <button wire:click="decrementQuantity({{ $item->id }})" 
                                                    class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center transition hover:bg-blue-700">
                                                -
                                            </button>
                                            <span class="w-8 text-center">{{ $item->quantity }}</span>
                                            <button wire:click="incrementQuantity({{ $item->id }})" 
                                                    class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center transition hover:bg-blue-700">
                                                +
                                            </button>
                                        </div>
                                    </td>
                                    <td class="px-6 text-right font-medium">
                                        Rp. {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 text-right">
                                        <button wire:click="removeItem({{ $item->id }})" 
                                                class="bg-red-500 text-white px-4 py-2 rounded-lg transition hover:bg-red-600">
                                            Remove Item
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-gray-50">
                                    <td colspan="2" class="px-6 py-4 text-right font-bold">Total</td>
                                    <td class="px-6 py-4 text-right font-bold">
                                        Rp. {{ number_format($total, 0, ',', '.') }}
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <div class="flex justify-between">
                        <a href="{{ route('home') }}" 
                           class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg transition hover:bg-gray-200">
                            Back to Home
                        </a>
                        <button wire:click="checkout" 
                                class="px-6 py-3 bg-blue-600 text-white rounded-lg transition hover:bg-blue-700">
                            Pay Bill
                        </button>
                    </div>
                @else
                    <div class="text-center py-12 bg-white rounded-lg shadow-sm">
                        <p class="text-gray-600">Your cart is empty.</p>
                        <a href="{{ route('home') }}" 
                           class="mt-4 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg transition hover:bg-blue-700">
                            Start Shopping
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>