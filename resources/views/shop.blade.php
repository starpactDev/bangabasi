@extends('layouts.master')

@section('head')
    <title>{{ $seller->store_name }} | Shop</title>
@endsection

@section('content')
	<div class="container mx-auto px-6 py-12">
		<!-- Seller Header Section -->
		<div class="bg-white shadow-lg rounded-lg p-6 md:p-8 flex flex-col md:flex-row items-center gap-6 md:gap-0">
			<!-- Left Section: Logo, Store Name & Stats -->
			<div class="w-full md:w-1/3 flex flex-col items-center border-r border-gray-300 pr-6">
				<!-- Seller Logo -->
				<img src="{{ $seller->logo ? asset('user/uploads/seller/logo/'.$seller->logo) : asset('images/bangabasi_logo_short.png') }}" 
					alt="Store Logo" class="w-24 h-24 rounded-full border border-gray-300">

				<!-- Store Name -->
				<h1 class="text-2xl font-bold text-orange-500 mt-3 text-center">{{ $seller->store_name }}</h1>

				<!-- Seller Stats -->
				<div class="flex justify-center gap-6 mt-4">
					<!-- Total Products -->
					<div class="text-center px-4 py-2 bg-sky-50 rounded-lg hover:shadow-sm hover:bg-sky-100">
						<span class="block text-2xl font-bold text-blue-600">{{ $totalProducts }}</span>
						<span class="text-gray-500 text-sm">Products</span>
					</div>

					<!-- Average Rating -->
					<div class="relative w-16 h-16">
						<svg class="absolute w-full h-full transform -rotate-90" viewBox="0 0 36 36">
							<circle class="text-gray-200" stroke-width="3" stroke="currentColor" fill="transparent" r="16" cx="18" cy="18"></circle>
							<circle class="text-yellow-500" stroke-width="3" stroke-linecap="round" stroke="currentColor" fill="transparent" 
									r="16" cx="18" cy="18"
									stroke-dasharray="100" 
									stroke-dashoffset="{{ 100 - ($averageRating / 5) * 100 }}"/>
						</svg>
						<span class="absolute inset-0 flex items-center justify-center text-xl font-bold text-yellow-500">
							{{ number_format($averageRating, 1) }}
						</span>
					</div>

					<!-- Total Reviews -->
					<div class="text-center px-4 py-2 bg-orange-50 rounded-lg hover:shadow-sm hover:bg-orange-100">
						<span class="block text-2xl font-bold text-orange-500">{{ $totalReviews }}</span>
						<span class="text-gray-500 text-sm">Reviews</span>
					</div>
				</div>
			</div>

			<!-- Right Section: Store Description -->
			<div class="w-full md:w-2/3 pl-6">
				<p class="text-gray-600 text-base leading-relaxed">
					{{ $seller->description ?? 'No description available' }}
				</p>
			</div>
		</div>
	</div>

    <!-- Products Section -->
    <div class="container mx-auto my-12">
        <h2 class="text-2xl font-semibold text-blue-600 text-center">Products from {{ $seller->store_name }}</h2>

        <!-- Product Grid -->
        <div class="flex flex-wrap gap-8 justify-evenly mt-6">
            @foreach ($products as $product)
                @php
					$cardClass = '';
                    $ratings = $product->reviews->avg('rating') ?: 0;
                    $image = $product->productImages->first()->image ?? null;
                @endphp
                <x-product-card 
                    :image="$image"
                    :category="$product->categoryDetails->name"
                    :title="$product['name']"
                    :rating="$ratings"
                    :originalPrice="$product['original_price']"
                    :discountedPrice="$product['offer_price']"
                    :id="$product->id"
                    :inStock="$product->in_stock"
                    :discountThreshold="$discountThreshold" 
                />
            @endforeach
			
        </div>
		<div class="py-8 border-b-gray-500 border-b-4"></div>
    </div>
</div>
@endsection