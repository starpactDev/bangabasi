<div class="w-full flex gap-4">
    @if (count($comboproducts) == 0)
        <h1 class="text-3xl font-bold text-center text-gray-500" style="text-align: center; margin-top:40px;">No products to Show!</h1>
    @else
        @foreach ($comboproducts as $product)
                @php
                    // Get the first product image or set default
                    $image = $product->productImages->first()->image ?? null;
                    $imageUrl = $image;
                @endphp
                <x-product-card 
                    :image="$imageUrl" 
                    :category="$product->categoryDetails->name" 
                    :title="$product['name']" 
                    :rating="$product->rating"
                    :originalPrice="$product['original_price']" 
                    :discountedPrice="$product['offer_price']" 
                    :id="$product->id" 
                    :inStock="true" 
                    :discountThreshold="$discountThreshold" 
                />
        @endforeach
    @endif
</div>