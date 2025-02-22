@extends("layouts.master")

@section('head')
<title>Our Sellers | Bangabasi</title>
@endsection

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="text-center">
        <h1 class="text-5xl font-bold text-orange-500 "> Meet Our Sellers </h1>
        <p class="text-lg text-gray-600 mt-3">Explore our top-rated sellers and their products.</p>
    </div>

    <!-- Sellers Grid -->
    <div class="mt-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($sellers as $seller)
        <div class="relative bg-white bg-opacity-80 backdrop-blur-md p-6 rounded-md shadow-md hover:shadow-lg transition-all duration-300 border border-gray-200">
            
            <!-- Seller Logo & Store Name -->
            <div class="flex items-center space-x-4">
                <img src="{{ $seller->logo ? asset('user/uploads/seller/logo/'.$seller->logo) : asset('images/bangabasi_logo_short.png') }}" 
                     alt="Store Logo" 
                     class="w-20 h-20 rounded-full border-4 border-orange-500 shadow-md">
                <div>
                    <h2 class="text-2xl font-bold text-blue-600">{{ $seller->store_name }}</h2>
                    <p class="text-sm text-gray-500">{{ $seller->email }}</p>
                </div>
            </div>

            <!-- Store Description -->
			<div class="min-h-12">
				<p class="mt-4 text-gray-700 italic line-clamp-2">{{ $seller->description ? Str::limit($seller->description, 120) : 'No description available' }}</p>
			</div>

            <!-- Statistics Section -->
            <div class="mt-5 grid grid-cols-3 gap-4 text-center">
                
                <!-- Total Products -->
                <div class="bg-blue-50 p-3 rounded-lg shadow-md">
                    <p class="text-lg font-semibold text-blue-600">{{ $seller->product_count }}</p>
                    <p class="text-xs text-gray-500 uppercase">Products</p>
                </div>

                <!-- Total Reviews -->
                <div class="bg-orange-50 p-3 rounded-lg shadow-md">
                    <p class="text-lg font-semibold text-orange-500">{{ $seller->total_reviews }}</p>
                    <p class="text-xs text-gray-500 uppercase">Reviews</p>
                </div>

                <!-- Rating with Circular Progress Bar -->
				<div class="flex flex-col justify-center">
					<div class="relative w-14 h-14 flex items-center justify-center mx-auto">
						<svg class="absolute w-full h-full transform -rotate-90" viewBox="0 0 36 36">
							<circle class="text-gray-200" stroke-width="3" stroke="currentColor" fill="transparent" r="16" cx="18" cy="18"></circle>
							<circle class="text-yellow-500" stroke-width="3" stroke="currentColor" fill="transparent" r="16" cx="18" cy="18"
									 stroke-dasharray="100" stroke-dashoffset="{{ 100 - ($seller->average_rating / 5) * 100 }}">
							</circle>
						</svg>
						<p class="absolute text-xs font-semibold text-yellow-600">{{ number_format($seller->average_rating, 1) }} ★</p>
					</div>
				</div>
                
            </div>

            <!-- Action Button -->
            <a href="{{ route('seller.shop', ['sellerId' => $seller->id]) }}" class="mt-5 block text-center bg-orange-500 text-white py-2 rounded-lg font-semibold hover:bg-orange-600 transition"> Visit Store </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
