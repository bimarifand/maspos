<div>
    <div class="container mt-4">
        <div class="header">
            <div>
                <a href="/dashboard/categories/create"><button class="btn btn-second">Add Category</button></a>
                <a href="/dashboard/products/create"><button class="btn btn-second">Add Product</button></a>
                <a href="/cart"><button class="btn btn-primary">Cart</button></a>
            </div>
        </div>

        <div class="container">
            <div class="row flex-row flex-nowrap overflow-auto">
                @foreach($products as $product)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card product-card">
                        <img src="{{ asset('storage/' . $product->photo) }}" class="card-img-top" alt="{{ $product->name }}">
                        <button class="btn btn-danger btn-sm delete-btn"></button>
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text price">Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                            <button wire:click="addToCart({{ $product->id }})" class="btn btn-primary w-100 add-to-cart-btn">+ Add to Cart</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <hr>

        <div class="total-bill">
            <a href="/cart"><button class="btn btn-primary">Total Bill: Rp. {{ number_format($total, 0, ',', '.') }}</button></a>
        </div>
    </div>
</div>
