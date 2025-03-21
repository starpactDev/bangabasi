@extends("layouts.master")
@section('head')
<title>Bangabasi | eCommerce for Bengal</title>
@endsection
@section('content')

<section class="py-8 hero">
	<div class="container">
		<div class="grid grid-cols-12 gap-4 ">
			<div class="col-span-12 lg:col-span-5">
				<div class="dokra min-h-screen md:h-full col-span-12 md:col-span-6 lg:col-span-5 md:row-span-9 border-blue" style="background-image: url('{{ asset('user/uploads/homepage/'.$homeData['heroSection']['image']) }}');">

					<div class="text-center w-full px-4" id="banga">
						<div class="text-xxl font-roboto  font-bold ">{!! $homeData['heroSection']['head'] !!}</div>
						<div class="banner-title text-white">{!! $homeData['heroSection']['description'] !!}</div>
						<a href="{{$homeData['heroSection']['redirect']}}" class="text-[1rem] text-orange-600 font-semibold hover:underline">{{$homeData['heroSection']['button']}}</a>
					</div>

				</div>
			</div>
			<div class="col-span-12 lg:col-span-7">
				<div class="col-span-12 md:col-span-6 lg:col-span-7 md:row-span-3 ">
					<div class="w-full py-2">
						<h2 class="text-[1.5rem] font-bold font-roboto my-4 ">Today's Popular Picks</h2>
					</div>
					<div class="swiper popular-picks py-6">
						<div class="swiper-wrapper">
							@if(count($popularPicks) > 0)

							@foreach ($popularPicks as $product)

							@php
							$averageRating = App\Helpers\ReviewHelper::getAverageRating($product->section_product->id);
							@endphp

							@if ($product->section_product->productImages->isNotEmpty())
							@php
							$image = $product->section_product->productImages->first()->image;
							@endphp
							@else
							@php
							$image = null;
							@endphp
							@endif

							@if ($product->section_product)
							<x-product-card
								:image="$image"
								:category="$product->section_product->categoryDetails->name"
								:title="$product->section_product->name"
								:rating="$averageRating" {{-- Ensure xRating is passed here --}}
								:originalPrice="$product->section_product->original_price"
								:discountedPrice="$product->section_product->offer_price"
								:id="$product->section_product->id"
								:discountThreshold="$discountThreshold"
								class="swiper-slide" />
							@endif

							@endforeach
							@endif
						</div>
						<!-- Pagination -->
						<div class="swiper-pagination"></div>
						<!-- Navigation Arrows -->
						<div class="swiper-button-prev"></div>
						<div class="swiper-button-next"></div>
					</div>
				</div>
				<div class="col-span-12 md:col-span-6 lg:col-span-7 min-h-48 md:row-span-3 p-4 md:p-0 ">
					<div class="grid grid-cols-12 h-full bg-slate-50">
						<div class="col-span-12 md:col-span-6 h-full flex items-center px-2">
							<div class="grooming min-h-52 mx-auto h-[95%] w-[95%] hover:h-[100%] hover:w-[100%]" style="background-image: url('{{ asset('user/uploads/homepage/'.$homeData['heroSideSection']['image']) }}')">

							</div>
						</div>
						<div class="col-span-12 md:col-span-6 h-full flex flex-column justify-center items-center">
							<div class="py-4">
								<h2 class="text-xl font-semibold ">{!! $homeData['heroSideSection']['head'] !!}</h2>
								<h6>{!! $homeData['heroSideSection']['description'] !!}</h6>
								<a href="{!! $homeData['heroSideSection']['redirect'] !!}" class="text-[1rem] text-secondary font-semibold hover:underline">{!! $homeData['heroSideSection']['button'] !!}</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-span-12 md:col-span-6 lg:col-span-5 md:row-span-3 ">
					<div class="swiper2 after-grooming relative overflow-hidden py-6">
						<div class="swiper-wrapper">
							@if(count($popularPicks) > 0)
							@foreach ($popularPicksTwo as $product)
							@php
							$averageRating = App\Helpers\ReviewHelper::getAverageRating($product->section_product->id);
							@endphp

							@if ($product->section_product->productImages->isNotEmpty())
							@php
							$image = $product->section_product->productImages->first()->image;
							@endphp
							@else
							@php
							$image = null;
							@endphp
							@endif

							@if ($product->section_product)
							<x-product-card
								:image="$image"
								:category="$product->section_product->categoryDetails->name"
								:title="$product->section_product->name"
								:rating="$averageRating" {{-- Ensure xRating is passed here --}}
								:originalPrice="$product->section_product->original_price"
								:discountedPrice="$product->section_product->offer_price"
								:id="$product->section_product->id"
								class="swiper-slide" />
							@endif

							@endforeach
							@endif
						</div>
						<!-- Pagination -->
						<div class="swiper-pagination"></div>
						<!-- Navigation Arrows -->
						<div class="swiper-button-prev"></div>
						<div class="swiper-button-next"></div>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

<!-- kaleidoscopic section -->

<section class="mt-8 bg-sky-50 kaleidoscopic">
	<div class="container grid grid-cols-12 min-h-48 ">
		<div class="col-span-12 lg:col-span-3 h-full py-4">
			<h3 class="text-xl font-semibold leading-[2rem]">You will find a kaleidoscopic of handcrafted trendy garments.</h3>
			<p class="text-slate-600 my-3">Give a pinch of aestheticism to your thoughts.</p>
		</div>
		<div class="col-span-12 lg:col-span-9 h-full py-4 grid grid-cols-12 gap-4">
			@foreach ($activeCategories as $category)
				<a class="col-span-6 md:col-span4 lg:col-span-2 flex flex-col items-center justify-center cursor-pointer group hover:opacity-90" id="{{ $category->id }}">
					<img src="/user/uploads/category/image/{{ $category->images }}" alt="{{ $category->images }}" class="group-hover:opacity-70">
					<h6 class="mt-2 text-gray-800 group-hover:text-orange-700">{{ $category->name }}</h6>
				</a>
			@endforeach
		</div>
	</div>
</section>

@php
	$food_products = App\Models\Product::where('category', 2)->inRandomOrder()->take(10)->get();
	$clothing_products = App\Models\Product::where('category', 1)->inRandomOrder()->take(10)->get();
	$dashakarma_products = App\Models\Product::where('category', 3)->inRandomOrder()->take(10)->get();
	$machinery_products = App\Models\Product::where('category', 6)->inRandomOrder()->take(10)->get();
@endphp

<!-- don't Miss Section  -->
<section class="py-8" id="dontMissSection">
	<div class="container">
		<h2 class="text-xl font-bold capitalize w-fit mx-auto py-4">Dont' Miss out These Offers!</h2>
		<ul class="flex mx-auto w-full flex-wrap justify-center" id="tabList">
			<li onclick=tabToggle(dashakarma) class="px-8 md:px-4 py-4 w-full md:w-1/4 text-center font-semibold text-slate-600 capitalize cursor-pointer hover:text-orange-600 ">Dashakarma</li>
			<li onclick=tabToggle(machinery) class="px-8 md:px-4 py-4 w-full md:w-1/4 text-center font-semibold text-slate-600 capitalize cursor-pointer hover:text-orange-600 bg-slate-50">Machinery</li>
			<li onclick=tabToggle(clothing) class="px-8 md:px-4 py-4 w-full md:w-1/4 text-center font-semibold text-slate-600 capitalize cursor-pointer hover:text-orange-600 bg-slate-50">Clothing</li>
			<li onclick=tabToggle(food) class="px-8 md:px-4 py-4 w-full md:w-1/4 text-center font-semibold text-slate-600 capitalize cursor-pointer hover:text-orange-600 bg-slate-50">Food Item</li>
		</ul>

		<div class="min-h-[80vh] border-[3px] border-orange-600 tabs" id="dashakarma">
			<div class="h-[40vh] flex justify-end items-center banner bg-right md:bg-left bg-cover" style="background-image: url('{{ asset('user/uploads/homepage/' . $homeData['dontMissSectionDashaKarma']['image']) }}')">
				<div class="max-w-[360px] px-8">
					<h3 class="text-xl font-semibold">{!! $homeData['dontMissSectionDashaKarma']['head'] !!}</h3>
					<p>{!! $homeData['dontMissSectionDashaKarma']['description'] !!}</p>
					<a href="{{ $homeData['dontMissSectionDashaKarma']['redirect'] }}" class="text-[1rem] text-secondary font-semibold hover:underline">{!! $homeData['dontMissSectionDashaKarma']['button'] !!}</a>
				</div>
			</div>
			<div class="flex flex-wrap gap-8 justify-around dashkarma-swiper relative overflow-hidden">
				<div class="swiper-wrapper">
					@foreach ($dashakarma_products as $product)
						@php
							$averageRating = App\Helpers\ReviewHelper::getAverageRating($product->id);
						@endphp
						@if ($product->productImages->isNotEmpty())
							@php
								$image = $product->productImages->first()->image;
							@endphp
						@else
							<?php $image = null; ?>
						@endif
						<x-product-card :image="$image" :category="$product->categoryDetails->name" :title="$product['name']" :rating="$averageRating"
							:originalPrice="$product['original_price']" :discountedPrice="$product['offer_price']" :id="$product->id" class="swiper-slide" />
					@endforeach
				</div>
				<!-- Pagination -->
				<div class="swiper-pagination"></div>
				<!-- Navigation Arrows -->
				<div class="swiper-button-prev"></div>
				<div class="swiper-button-next"></div>
			</div>
		</div>
		<div class="min-h-[80vh] border-[3px] border-ornage-600 hidden tabs" id="machinery">
			<div class="h-[40vh] flex justify-start items-center banner bg-left md:bg-right bg-cover" style="background-image: url('{{ asset('user/uploads/homepage/' . $homeData['dontMissSectionMachinery']['image']) }}')">
				<div class="max-w-[360px] px-8">
					<h3 class="text-xl font-semibold">{!! $homeData['dontMissSectionMachinery']['head'] !!}</h3>
					<p>{!! $homeData['dontMissSectionMachinery']['description'] !!}</p>
					<a href="{{ $homeData['dontMissSectionDashaKarma']['redirect'] }}" class="text-[1rem] text-secondary font-semibold hover:underline">{!! $homeData['dontMissSectionMachinery']['button'] !!}</a>
				</div>
			</div>
			<div class="flex flex-wrap gap-8 justify-around machinery-swiper relative overflow-hidden">
				<div class="swiper-wrapper">
					@foreach ($machinery_products as $product)
					@php
					$averageRating = App\Helpers\ReviewHelper::getAverageRating($product->id);
					@endphp

					@if ($product->productImages->isNotEmpty())
					@php
					$image = $product->productImages->first()->image;
					@endphp
					@else
					<?php $image = null; ?>
					@endif

					<x-product-card :image="$image" :category="$product->categoryDetails->name" :title="$product['name']" :rating="$averageRating"
						:originalPrice="$product['original_price']" :discountedPrice="$product['offer_price']" :id="$product->id" class="swiper-slide" />
					@endforeach
				</div>

				<!-- Pagination -->
				<div class="swiper-pagination"></div>
				<!-- Navigation Arrows -->
				<div class="swiper-button-prev"></div>
				<div class="swiper-button-next"></div>
			</div>
		</div>
		
		<div class="min-h-[80vh] border-[3px] border-orange-600 hidden tabs" id="clothing">
			<div class="h-[40vh] flex justify-end items-center banner bg-right md:bg-left bg-cover" style="background-image: url('{{ asset('user/uploads/homepage/' . $homeData['dontMissSectionClothing']['image']) }}')">
				<div class="max-w-[360px] px-8">
					<h3 class="text-xl font-semibold">{!! $homeData['dontMissSectionClothing']['head'] !!}</h3>
					<p>{!! $homeData['dontMissSectionClothing']['description'] !!}</p>
					<a href="{{ $homeData['dontMissSectionClothing']['redirect'] }}" class="text-[1rem] text-secondary font-semibold hover:underline">{!! $homeData['dontMissSectionClothing']['button'] !!}</a>
				</div>
			</div>
			<div class="flex flex-wrap gap-8 justify-around clothing-swiper relative overflow-hidden py-4">
				<div class="swiper-wrapper">
					@foreach ($clothing_products as $product)
					@php
					$averageRating = App\Helpers\ReviewHelper::getAverageRating($product->id);
					@endphp
					@if ($product->productImages->isNotEmpty())
					@php
					$image = $product->productImages->first()->image;
					@endphp
					@else
					<?php $image = null; ?>
					@endif
					<x-product-card :image="$image" :category="$product->categoryDetails->name" :title="$product['name']" :rating="$averageRating"
						:originalPrice="$product['original_price']" :discountedPrice="$product['offer_price']" :id="$product->id" class="swiper-slide" />
					@endforeach
				</div>
				<!-- Pagination -->
				<div class="swiper-pagination"></div>
				<!-- Navigation Arrows -->
				<div class="swiper-button-prev"></div>
				<div class="swiper-button-next"></div>
			</div>
		</div>
		<div class="min-h-[80vh] border-[3px] border-orange-600 hidden tabs" id="food">
			<div class="h-[40vh] flex justify-end items-center banner bg-right md:bg-left bg-cover" style="background-image: url('{{ asset('user/uploads/homepage/' . $homeData['dontMissSectionFoodItem']['image']) }}')">
				<div class="max-w-[360px] px-8">
					<h3 class="text-xl font-semibold">{!! $homeData['dontMissSectionFoodItem']['head'] !!}</h3>
					<p>{!! $homeData['dontMissSectionFoodItem']['description'] !!}</p>
					<a href="{{ $homeData['dontMissSectionFoodItem']['redirect'] }}" class="text-[1rem] text-secondary font-semibold hover:underline">{!! $homeData['dontMissSectionFoodItem']['description'] !!}</a>
				</div>
			</div>
			<div class="flex flex-wrap gap-8 justify-around food-swiper relative overflow-hidden py-4">
				<div class="swiper-wrapper">
					@foreach ($food_products as $product)
					@php
					$averageRating = App\Helpers\ReviewHelper::getAverageRating($product->id);
					@endphp

					@if ($product->productImages->isNotEmpty())
					@php
					$image = $product->productImages->first()->image;
					@endphp
					@else
					<?php $image = null; ?>
					@endif
					<x-product-card :image="$image" :category="$product->categoryDetails->name" :title="$product['name']" :rating="$averageRating"
						:originalPrice="$product['original_price']" :discountedPrice="$product['offer_price']" :id="$product->id" class="swiper-slide" />
					@endforeach
				</div>
				<!-- Pagination -->
				<div class="swiper-pagination"></div>
				<!-- Navigation Arrows -->
				<div class="swiper-button-prev"></div>
				<div class="swiper-button-next"></div>
			</div>
		</div>
	</div>
</section>

<!-- traditional Clothing -->
<section class="py-8 traditional overflow-x-hidden">
	<h2 class="w-fit mx-auto text-xl font-bold py-6">Indian Traditional Clothing</h2>
	<div class="container grid grid-cols-12  gap-8 ">
		<div class="col-span-12 md:col-span-5 p-4 border-2 min-h-60">
			<div class="banner w-full h-full overflow-hidden flex justify-around items-center gap-4 px-6">
				<img src="{{ asset('user/uploads/homepage/' . $homeData['traditionalSectionLeftSide']['image']) }}" alt="" class="h-full w-[30%]">
				<div class="">
					<h3 class="w-fit text-md md:text-lg lg:text-xl font-bold">{!! $homeData['traditionalSectionLeftSide']['head'] !!}</h3>
					<p class="text-xs md:text-sm">{!! $homeData['traditionalSectionLeftSide']['description'] !!}</p>
					<a href="{{ $homeData['traditionalSectionLeftSide']['redirect'] }}" class="text-sm md:text-md lg:text-[1rem] text-secondary font-semibold hover:underline">{!! $homeData['traditionalSectionLeftSide']['button'] !!}</a>
				</div>
			</div>
		</div>
		<div class="col-span-12 md:col-span-7 p-4 border-2 min-h-60">
			<div class="banner w-full h-full overflow-hidden flex justify-around items-center gap-4 px-6">
				<img src="{{ asset('user/uploads/homepage/' . $homeData['traditionalSectionRightSide']['image']) }}" alt="" class="h-full w-[25%]">
				<div class="">
					<h3 class="w-fit text-md md:text-lg lg:text-xl font-bold">{!! $homeData['traditionalSectionRightSide']['head'] !!}</h3>
					<p class="text-xs md:text-sm">{!! $homeData['traditionalSectionRightSide']['description'] !!}</p>
					<a href="{{ $homeData['traditionalSectionLeftSide']['redirect'] }}" class="text-sm md:text-md lg:text-[1rem] text-secondary font-semibold hover:underline">{!! $homeData['traditionalSectionRightSide']['button'] !!}</a>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- newest Section-->
<section class="py-8 newest">
	<h2 class="w-fit mx-auto text-xl font-bold py-4">Newest At Bangabasi</h2>
	<div class="container grid grid-cols-12 gap-4 py-4 ">
		<div class="col-span-12 lg:col-span-5 h-full p-4 border">
			<div class="w-full puja h-80 flex items-center px-[15%] " style="background-image: url('{{ asset('user/uploads/homepage/' . $homeData['newestSection']['image']) }}'); background-size: cover; background-position: center">
				<div class="text-center w-52">
					<h3 class="w-fit text-2xl font-bold text-key">{!! $homeData['newestSection']['head'] !!}</h3>
					<p class="text-slate-600 py-4">{!! $homeData['newestSection']['description'] !!}</p>
					<a href="{{$homeData['newestSection']['redirect']}}" class="text-[1rem] text-orange-600 text-mediumBlue font-semibold py-8 hover:underline hover:text-orange-900">{{$homeData['newestSection']['button']}}</a>
				</div>
			</div>
			<ul class="flex flex-wrap pt-12 px-8 two-two w-full">
				@foreach($activeSubCategories as $activeSubCategory)
				<li>
					<a href="{{ url('/products') }}?sub_category={{ $activeSubCategory->id }}" class="text-slate-500 font-medium hover:text-primary">{{$activeSubCategory->name}}</a>
				</li>
				@endforeach
			</ul>
		</div>
		<div class="col-span-12 lg:col-span-7 border h-full">

			<div class="flex flex-wrap justify-around my-4  gap-4">
				@foreach ($newest_products as $product)

					@php
						$averageRating = App\Helpers\ReviewHelper::getAverageRating($product->id);
					@endphp

					@if ($product->productImages->isNotEmpty())
						@php
							$image = $product->productImages->first()->image;
						@endphp
					@else
						@php
							$image = null;
						@endphp
					@endif

				@if ($product)
				<x-product-card
					:image="$image"
					:category="$product->categoryDetails->name"
					:title="$product->name"
					:rating="$averageRating" {{-- Ensure xRating is passed here --}}
					:originalPrice="$product->original_price"
					:discountedPrice="$product->offer_price"
					:id="$product->id"
					class="my-6" />
				@endif

				@endforeach
			</div>

		</div>
	</div>
</section>

<!-- most-wishes -->
<section class="py-8 most-wishes">
	<h2 class="py-4 text-lg md:text-2xl font-bold text-center">Most Wishes For In Clothing</h2>
	<div class="container female-model min-h-96 grid grid-cols-12">
		<div class="hidden lg:block lg:col-span-4">
			<div class="w-full h-96 ">
				<img src="{{ asset('user/uploads/homepage/'.$homeData['mostWishesSection']['image']) }}" alt="" class=" h-full w-auto mx-16">
			</div>
		</div>
		<div class="col-span-12 lg:col-span-8 flex flex-wrap items-center justify-equal gap-4 py-6">
			<div class="swiper3 most w-full relative overflow-hidden py-8">
				<div class="swiper-wrapper w-full">

					@foreach ($most_wishes as $product)
					@php
					$averageRating = App\Helpers\ReviewHelper::getAverageRating($product->section_product->id);
					@endphp

					@if ($product->section_product->productImages->isNotEmpty())
					@php
					$image = $product->section_product->productImages->first()->image;
					@endphp
					@else
					@php
					$image = null;
					@endphp
					@endif

					@if ($product->section_product)
					<x-product-card
						:image="$image"
						:category="$product->section_product->categoryDetails->name"
						:title="$product->section_product->name"
						:rating="$averageRating" {{-- Ensure xRating is passed here --}}
						:originalPrice="$product->section_product->original_price"
						:discountedPrice="$product->section_product->offer_price"
						:id="$product->section_product->id"
						class="swiper-slide" />
					@endif

					@endforeach
				</div>
				<!-- Pagination -->
				<div class="swiper-pagination"></div>
				<!-- Navigation Arrows -->
				<div class="swiper-button-prev"></div>
				<div class="swiper-button-next"></div>
			</div>

		</div>
	</div>
	<div>
		<div class="container">
			<h4 class="text-sm text-slate-600 font-semibold text-center py-4 border-bottom-4 border-bottom">PROUDUCTS TAGS</h4>
			<ul class="w-4/5 mx-auto flex flex-wrap justify-center gap-2 gap-y-4">
				@foreach ($all_products as $product)
					@php
					// Get the first tag for the current product
					$firstTag = $firstTags[$product->id] ?? null; // Default to null if no tag exists
					@endphp

					@if ($firstTag) <!-- Only show the item if a first tag is available -->
					<li>
						<a href="#" class="px-4 py-2 block max-w-64 md:max-w-48 whitespace-nowrap overflow-hidden text-ellipsis text-sm bg-slate-100 text-slate-500 hover:text-slate-50 hover:bg-orange-600 ">
							{{ $firstTag }} <!-- Display the first unique tag -->
						</a>
					</li>
					@endif
				@endforeach
			</ul>
		</div>

	</div>
</section>

<!-- sellers -->
<section class="py-8 sellers">
	<div class="container grid grid-cols-12 gap-4">
		<div class="col-span-12 md:col-span-4 lg:col-span-3 ">
			<h3 class="text-center text-2xl font-bold py-6 ">Bangabasi Sellers</h3>
			<ul class="px-6 text-slate-500 py-4">
				<li class="py-2 cursor-pointer hover:text-orange-600 ">Clothing</li>
				<li class="py-2 cursor-pointer hover:text-orange-600 ">Food Item</li>
				<li class="py-2 cursor-pointer hover:text-orange-600 ">Dashakarma</li>
				<li class="py-2 cursor-pointer hover:text-orange-600 ">Handcrafts</li>
				<li class="py-2 cursor-pointer hover:text-orange-600 ">Men's Grooming</li>
				<li class="py-2 cursor-pointer hover:text-orange-600 ">Machinery</li>
				<li class="py-2 cursor-pointer hover:text-orange-600 ">Electronics</li>
			</ul>
		</div>

		<div class="col-span-12 md:col-span-8 lg:col-span-9 min-h-32 flex items-center justify-around flex-wrap gap-4 overflow-hidden">

			@foreach ($selectedProducts as $product)

			@php
				$averageRating = App\Helpers\ReviewHelper::getAverageRating($product->id);
			@endphp

			@if ($product->productImages->isNotEmpty())
				@php
					$image = $product->productImages->first()->image;
				@endphp
			@else
				@php
					$image = null;
				@endphp
			@endif

			@if ($product)
			<x-product-card
				:image="$image"
				:category="$product->categoryDetails->name"
				:title="$product->name"
				:rating="$averageRating"
				:originalPrice="$product->original_price"
				:discountedPrice="$product->offer_price"
				:id="$product->id"
			/>
			@endif

			@endforeach
		</div>
	</div>
	<!-- marquee -->
	<x-marquee />
</section>

<!-- handpicked items -->
<section class="handpicked ">
	<h2 class="text-center text-2xl font-semibold capitalize py-6">Handpicked Products for You</h2>
	<div class="container border-4 p-6">
		<div class="handcrafts grid grid-cols-12 min-h-60 items-center" style="background-image: url('{{ asset('user/uploads/homepage/'.$homeData['handpickedSection']['image']) }}'); background-size: cover; background-position: left">
			<div class="col-span-12 md:col-span-6 mx-auto lg-mx-0 lg:px-16 ">
				<h3 class="text-lg md:text-2xl font-bold py-2 md:py-4">{!! $homeData['handpickedSection']['head'] !!}</h3>
				<p class="my-2 md:my-4 text-sm md:text-md">{!! $homeData['handpickedSection']['description'] !!}</p>
				<a href="{{ $homeData['handpickedSection']['redirect'] }}" class="text-orange-500 text-semibold text-sm md:text-md capitalize interactive-border my-2 md:my-4 my-8">{{ $homeData['handpickedSection']['button'] }}</a>
			</div>
			<div class="hidden md:col-span-6">

			</div>
		</div>
		<div class="w-full py-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
			@foreach ($handpicked as $product)



				@php
					$averageRating = App\Helpers\ReviewHelper::getAverageRating($product->section_product->id);
					$cardClass="mx-auto col-span-1"
				@endphp

				@if ($product->section_product->productImages->isNotEmpty())
					@php
						$image = $product->section_product->productImages->first()->image;
					@endphp
				@else
					@php
						$image = null;
					@endphp
				@endif

				@if ($product->section_product)

				<x-product-card
					:cardClass="$cardClass"
					:image="$image"
					:category="$product->section_product->categoryDetails->name"
					:title="$product->section_product->name"
					:rating="$averageRating" 
					:originalPrice="$product->section_product->original_price"
					:discountedPrice="$product->section_product->offer_price"
					:id="$product->section_product->id" />
				@endif


			@endforeach
		</div>

	</div>
</section>

<!-- brands section -->

<x-brands />

<!-- blogs section -->
<x-blogsection />
@endsection