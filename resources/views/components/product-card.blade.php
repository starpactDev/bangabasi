@php

	$discount = 0;
	if($originalPrice && $discountedPrice){
		$discount = ceil((($originalPrice - $discountedPrice) / $originalPrice ) * 100);
	}

@endphp
@props(['image', 'category', 'title', 'rating', 'originalPrice', 'discountedPrice', 'id', 'class' => ''])

<div class="swiper-slide product-card w-40 min-h-64 shadow-sm hover:shadow-md  group  {{ $inStock ? '' : 'bnw'}} {{$cardClass}}">
	
	<div class="card-img min-h-40 aspect-square relative">
		@if (isset($id))
		<img src="{{ asset('user/uploads/products/images/' . $image) }}" alt="{{$image}}" class="absolute h-full w-full object-cover ">
		@else
		<img src="/images/products/{{ $image }}" alt="{{$image}}" class="absolute h-full w-full object-cover ">
		@endif
	</div>
	<!-- $discountThreshold is defined and register in AppServiceProvider -->
	@if($discountThreshold <= $discount)
	<div class="absolute top-1 right-1 px-1 rounded-ful bg-green-600 text-white">
		<i class="fa-solid fa-tag"></i>
	</div>
	@endif
	<div class="absolute w-full justify-center trasnsition-all top-0 hidden group-hover:top-10 group-hover:flex ">
		<form action="{{ route('wishlist.addAndRedirect') }}" method="POST">
			@csrf
			<input type="hidden" name="product_id" value="{{ $id }}">
			<button type="submit" class="mx-2 p-2 bg-white/65 text-xl text-orange-600 group-hover:shadow-md">
				<i class="fa-solid fa-heart"></i>
			</button>
		</form>
		<a href="https://wa.me/?text={{ urlencode('Check out this product: ' . route('user.product.details', ['id' => $id])) }}" target="_blank" class="mx-2 p-2 bg-white/65 text-xl text-orange-600 border"><i class="fa-solid fa-share"></i></a>
	</div>
	@if(isset($id))
		<a href="{{ route('user.product.details', ['id' => $id]) }}" class="{{ $class ?? '' }}">
	@endif
		<div class=" min-h-24 max-h-36 py-1 px-2 bg-white ">

			<h4 class="block text-sm text-[#686868] truncate">{{ $category }}</h4>
			<h2 class="font-semibold text-gray-600 truncate group-hover:text-orange-600">{{ $title }}</h2>
			<div class="flex items-center justify-between">
				<div class="">
					@for ($i = 0; $i < floor($rating); $i++)
						<img src="/images/icons/star.svg" alt="" class="h-3 inline mx-[-1px]">
					@endfor
					@if (floor($rating) < 5)
						<img src="/images/icons/star_nofill.svg" alt="" class="h-3 inline mx-[-1px]">
					@endif
					@for ($i = 0; $i < (4 - ceil($rating)); $i++)
						<img src="/images/icons/star_nofill.svg" alt="" class="h-3 inline mx-[-1px]">
					@endfor
				</div>
				<div class="text-[#388e3c] text-sm font-bold pr-4">{{round($discount)}} %</div>
			</div>
			<div class="flex gap-4">
				<del class="text-red-500 text-sm">₹{{ round($originalPrice) }}</del>
				<p class="font-semibold text-slate-700">₹ {{ round($discountedPrice) }}</p>
			</div>
		</div>
		@if(isset($id))
	</a>
	@endif
</div>