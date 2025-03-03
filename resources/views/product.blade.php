@extends('layouts.master')
@section('head')
    <title>Bangabasi | Product Details</title>
    <meta property="og:title" content="{{ $product->name }}" />
    <meta property="og:image" content="{{ asset('user/uploads/products/images/' . $product->productImages->first()->image) }}" />
    <meta property="og:url" content="{{ route('user.product.details', ['id' => $product->id]) }}" />
    <meta property="og:type" content="website" />
@endsection
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $xpage = $product->name;
        $p_id = $product->id;
        $category = $product->categoryDetails->name;
        $sub_category = $product->subCategoryDetails->name;
        $price = $product->offer_price;
        $sizes = $product->productSizes;
        $short_description = $product->short_description;
        $full_details = $product->full_details;
        $in_stock = $product->in_stock;
        $images = $product->productImages;
        $originalPrice = $product->original_price;
        $discount = $product->discount_percentage;
        $xprv = 'home';
    @endphp

    <x-bread-crumb :page="$xpage" :previousHref="$xprv" />

    {{-- {{ $products }} --}}
    @php
    // Check if the images collection is not empty and get the first image URL, or set a fallback.
        $firstImageUrl = $images->isNotEmpty() 
            ? asset('user/uploads/products/images/' . $images->first()->image) 
            : asset('images/products/1.jpg');
    @endphp
    <div class="grid grid-cols-12 container mx-auto my-6 gap-x-6">
        <div class="col-span-12 lg:col-span-9 grid grid-cols-12 gap-x-8">
            <div class="col-span-12 lg:col-span-6 space-y-8">
                <div class="aspect-square bg-slate-50 border flex flex-col justify-end py-4 cursor-crosshair relative" id="preview" style="background-image: url('{{ $firstImageUrl }}');" data-type="image">
                    <div class="h-20 flex justify-center gap-2">
                        @foreach ($images as $image)
                            @php
                                $extension = pathinfo($image->image, PATHINFO_EXTENSION);
                                $isVideo = in_array($extension, ['mp4', 'mkv', 'avi', 'gif']);
                                $isYouTubeUrl = preg_match(
                                    '/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/',
                                    $image->image,
                                );
                            @endphp

                            @if ($isYouTubeUrl)
                                @php
                                    $youtubeId = '';
                                    if (preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $image->image, $matches)) {
                                        $youtubeId = $matches[1];
                                    } elseif (preg_match('/youtu.be\/([^\\?\\&]+)/', $image->image, $matches)) {
                                        $youtubeId = $matches[1];
                                    }
                                    elseif (preg_match('/shorts\/([^\\?\\&]+)/', $image->image, $matches)) {
                                        $youtubeId = $matches[1];
                                    }
                                    $embedURL = 'https://www.youtube.com/embed/' . $youtubeId;
                                @endphp
                                <div class="flex-1">
                                    <img src="https://img.youtube.com/vi/{{ $youtubeId }}/default.jpg" alt="" class="thumb border-2 mx-auto h-full cursor-pointer" yt-url="{{ $embedURL }}" data-type="youtube" data-src="https://img.youtube.com/vi/{{ $youtubeId }}/mqdefault.jpg">
                                </div>
                            @elseif ($isVideo)
                                <div class="flex-1">
                                    <img src="/images/icons/video-play.gif" alt="" class="thumb border-2 mx-auto h-full cursor-pointer" data-type="video" data-src="/images/icons/play.png">
                                </div>
                            @else
                                <div class="flex-1">
                                    <img src="{{ asset('user/uploads/products/images/' . $image->image) }}" alt="" class="thumb border-2 mx-auto h-full cursor-pointer" data-type="image" data-src="{{ asset('user/uploads/products/images/' . $image->image) }}">
                                </div>
                            @endif
                        @endforeach
                    </div>
                    @if ($isYouTubeUrl)
                        <button yt-url="" id="playBtn"
                            class="hidden xyz bg-blue-500 text-white rounded-full px-4 py-2 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 shadow-lg">&#9654;</button>
                        <iframe id="ytFrame"
                            class="hidden border-2 mx-auto cursor-pointer absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"
                            width="100%" height="50%" src="{{ $embedURL }}" frameborder="0"
                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen
                            data-type="youtube" data-src="{{ $embedURL }}">
                        </iframe>
                    @endif
                    @if ($isVideo)
                        <video id="nativeFrame" class="hidden border-2 mx-auto w-1/2 h-1/2 cursor-pointer absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2" controls data-type="video" data-src="{{ asset('user/uploads/products/images/' . $image->image) }}">
                            <source src="{{ asset('user/uploads/products/images/' . $image->image) }}" type="video/{{ $extension }}">
                            Your browser does not support the video tag.
                        </video>
                    @endif
                </div>
                <div class="w-full py-4  " style="border: 1px dashed red">
                    <h6 class="capitalize text-sm font-semibold px-4 text-gray-700">you may be interested in... </h6>
                    <div class="swiper8 interested py-8 relative overflow-hidden">
                        <div class="swiper-wrapper">

                            @if(count($related_products) >0)
                                @foreach ($related_products as $product)
                                    @php

                                        $ratings = 0;
                                    @endphp
                                    @if (count($product['reviews']) > 0)
                                        @foreach ($product['reviews'] as $review)
                                            @php
                                                $ratings += $review['rating'];
                                            @endphp
                                        @endforeach
                                        @php
                                            $ratings = $ratings / count($product['reviews']);
                                        @endphp
                                    @endif
                                    @if ($product->productImages->isNotEmpty())
                                        @php
                                            $image = $product->productImages->first()->image;

                                        @endphp
                                    @else
                                        <?php $image = null; ?>
                                    @endif
                                    <div class="swiper-slide">
                                        <x-product-card :image="$image" :category="$product->categoryDetails->name" :title="$product['name']" :rating="$ratings"
                                            :originalPrice="$product['original_price']" :discountedPrice="$product['offer_price']" :id="$product->id" :inStock="$product->in_stock" class="swiper-slide" />
                                    </div>
                                @endforeach
                            @else
                                <span style="color:red;font-weight:600;" class="mx-4">No Similar Products to display </span>
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
            <div class="col-span-12 lg:col-span-6">
                <h1 class="text-2xl font-semibold "> {{ $xpage }}</h1>
                <div>
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $rating)
                            <img src="/images/icons/star.svg" alt="Filled star" class="h-3 inline mx-[-1px]">
                        @else
                            <img src="/images/icons/star_nofill.svg" alt="Unfilled star" class="h-3 inline mx-[-1px]">
                        @endif
                    @endfor
                    <p class="px-4 inline">({{ $reviewCount }} customer reviews)</p>
                </div>
                <div class="flex justify-between items-center py-2 border-b">
                    <div>
                    <h3 class="text-slate-800">Category : <span class="text-slate-500">{{ $category }}</span></h3>
                        <h3 class="text-slate-800">Sub-Category : <span class="text-slate-500">{{ $sub_category }}</span></h3>
                        <h3 class="text-slate-800">Tags : <span class="text-slate-500">{{ $sub_category }}</span></h3>
                    </div>
                    <a href="https://wa.me/?text={{ urlencode( route('user.product.details', ['id' => $p_id])) }}" class="py-2 px-4 border border-green-600 hover:bg-green-100 text-center text-green-700 font-semibold rounded-md cursor-pointer  max-w-xs text-lg  my-2" data-product-id="{{ $p_id }}">
                        <img src="/images/icons/share.png" alt="" class="h-6 mr-3 inline">
                        Share
                    </a>
                </div>
                <style>
                    /* Custom fade-in keyframes */
                    @keyframes fadeIn {
                        from { opacity: 0; }
                        to { opacity: 1; }
                    }
                    
                    .fade-in {
                        animation: fadeIn 2s ease forwards;
                    }
                </style>
                <div class="my-3">
                    <h3 class="inline text-2xl font-semibold text-slate-700 fade-in delay-100 ">₹{{ $price }}</h3>
                    <p class="inline text-lg text-gray-500 fade-in delay-500 ">
                        <span class="line-through text-gray-400">₹{{ $originalPrice }}</span>
                        <span class="text-xl text-orange-500 font-semibold ml-2">({{ round($discount) }}%)</span>
                    </p>
                    <p class="text-green-700 my-2 fade-in delay-300">
                        You Save ₹{{ $originalPrice - $price }}
                    </p>
                </div>

                <!-- Size Chart -->
                @if ($sizes)
                    <h6 class="text-md font-semibold py-2">Size Chart</h6>
                    <div class="flex flex-wrap gap-4">
                        <!-- Clickable Sizes -->
                        @foreach ($sizes as $size)
                            @if ($size->quantity > 0)
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="size" value="{{ $size->size }}" data-quantity="{{ $size->quantity }}" class="sr-only peer" />
                                    <span class="w-fit px-2 h-8 flex items-center justify-center border-2 border-gray-300 rounded-full hover:border-orange-500 peer-checked:bg-orange-500 peer-checked:text-white peer-checked:border-transparent cursor-pointer">
                                        {{ $size->size }}
                                    </span>
                                </label>
                            @else
                                <span class="w-fit px-2 h-8 flex items-center justify-center border-2 border-gray-300 rounded-full bg-gray-200 text-gray-500 cursor-not-allowed">{{ $size->size }}</span>
                            @endif
                        @endforeach
                    </div>
                @endif
                @if ($in_stock)
                    <div class="my-4 w-fit px-4 border border-green-600 rounded-full">In Stock <span class="text-green-600 animate-ping">&#9679;</span></div>

                    <div class="my-4 space-y-2">
                        <form action="" class="border-b-2 border-neutral-800 w-fit px-2 py-1" id="checkPinCode">
                            @csrf
                            <label for="pincode"><i class="fa-solid fa-map-marker-alt text-blue-600"></i></label>
                            <input type="hidden" name="delivery_postcode" value="{{ $seller->pickupAddress->pincode ?? '713125' }}">
                            <input type="number" name="pickup_postcode" id="pincode" value="700001" class="px-2 w-24 focus:outline-none" pattern="^\d{6}$" required>
                            <input type="submit" value="Check Delivery" class="text-blue-600 cursor-pointer">
                        </form>
                        <h6 class="font-semibold" id="estDelivery"></h6>
                        <small id="cutOffTime"></small>
                        <p class="text-red-500" id="courierError"></p>
                    </div>
                    @php
                        $notBuyer = Auth::check() && Auth::user()->usertype !== 'user' ? true : false;
                    @endphp
                    
                    <div class="pb-4 relative {{$notBuyer ? 'grayscale' : ''}}" id="actionArea">
                        
                        <div class="flex justify-between py-4 px-4" >
                            <div class="w-1/4 flex h-8">
                                <button class="w-1/4 border hover:bg-slate-200" onclick="downCount()">-</button>
                                <div class="w-1/4 text-center border leading-8" id="cartCount">1</div>
                                <button class="w-1/4 border  hover:bg-slate-200" onclick="upCount()">+</button>
                            </div>

                            
                                <button id="toCartBtn" onclick="submitWishlistToCart({{ $p_id }}, {{ $price }});" class="w-3/4 bg-black text-white hover:bg-gray-900">Add To Cart</button>

                                <form id="wishlist_addToCart_{{ $p_id }}" action="{{ route('wishlist.addToCart') }}"
                                    method="POST" style="display: none;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $p_id }}">
                                    <input type="hidden" name="quantity" id="quantity_{{ $p_id }}" value="1">
                                    <input type="hidden" name="size" id="selected_size_{{ $p_id }}">
                                    <input type="hidden" name="unit_price" id="unit_price_{{ $p_id }}" value="{{ $price }}">
                                    <input type="hidden" name="total_price" id="total_price_{{ $p_id }}" value="{{ $price }}">
                                </form>

                            
                        </div>
                        
                        @if($notBuyer)
                            <div class="py-4 w-full"></div>
                        @else
                            <p class="text-center text-slate-400 text-sm py-2">---------------- OR ----------------</p>
                        @endif
                        <div class="flex justify-around my-2">
                            <button id="buyNow" class="py-4 px-6 bg-[#c44601] hover:bg-red-700 text-center text-slate-50 font-semibold rounded-md cursor-pointer  max-w-xs text-lg " id="buyNow" data-product-id="{{ $p_id }}">
                                <img src="/images/icons/shopping-cart.png" alt="" class="h-6 mr-3 inline invert">
                                Buy Now
                            </button>
                            @if ($wishlist)
                                <!-- Product is already in the wishlist, no click event will be attached -->
                                <h3 class="py-4 px-4 border border-red-600 hover:bg-red-50 text-center text-red-600 font-semibold rounded-md cursor-pointer max-w-xs inline-flex items-center justify-center text-lg" data-product-id="{{ $p_id }}">
                                    <img src="/images/icons/heart_fill.svg" alt="" class="h-6 mr-3">
                                    Wishlisted
                                </h3>
                            @else     
                                <!-- Product is not in the wishlist, attach click event -->
                                <button class="py-4 px-6 border-2 border-green-100 bg-green-600 hover:bg-green-700 text-center text-slate-50 font-semibold rounded-md cursor-pointer  max-w-xs text-lg add-to-wishlist" data-product-id="{{ $p_id }}">
                                    <img src="/images/icons/heart.svg" alt="" class="h-6 mr-3 inline invert">
                                    Add to wishlist
                                </button>
                            @endif
                        </div>
                        @if($notBuyer)
                            <div class="absolute w-full h-full top-0 flex justify-center items-center backdrop-blur-[1px] bg-neutral-200 bg-opacity-40 border">
                                <p class="-translate-y-4 text-lg">You aren't authorized user.</p>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="my-4 w-fit px-4 border border-red-600 rounded-full">Out of Stock <span class="text-red-600 animate-ping">&#9679;</span></div>
                @endif
            </div>
            <div class="col-span-12 my-12">
                <ul class=" md:flex ">
                    <li onclick="descriptionToggle(event)" data-target="description" class="tab-link px-4 py-2 bg-slate-200 hover:bg-slate-100 border">Description</li>
                    <li onclick="descriptionToggle(event)" data-target="qna" class="tab-link px-4 py-2 hover:bg-slate-100 border">Full Deatils</li>
                </ul>
                <div class="border min-h-64 p-8 tabs " id="description">
                    <p class="py-4 text-slate-700">
                        {!! $short_description !!}
                    </p>
                </div>
                <div class="border min-h-64 p-8 tabs  hidden" id="qna">
                    <p class="py-4 text-slate-700">
                        {!! $full_details !!}
                    </p>
                </div>
            </div>
            <div class="col-span-12 bg-slate-100 p-8 min-h-64">
                <h3 class="text-4xl font-semibold text-center ">{{ number_format($rating, 1) }}</h3>
                <p class="text-center">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $rating)
                            <img src="/images/icons/star.svg" alt="Filled star" class="h-3 inline mx-[-1px]">
                        @else
                            <img src="/images/icons/star_nofill.svg" alt="Unfilled star" class="h-3 inline mx-[-1px]">
                        @endif
                    @endfor
                </p>
                <p class="capitalize text-center ">Based on {{ $reviewCount }} customer reviews</p>
                <div class="py-4 ">
                    @for ($starRating = 5; $starRating >= 1; $starRating--)
                        <div class="flex justify-between items-center h-3 my-2">
                            <p>
                                @for ($i = 0; $i < $starRating; $i++)
                                    <img src="/images/icons/star.svg" alt="Star" class="h-3 inline mx-[-1px]">
                                @endfor
                                @for ($i = 0; $i < 5 - $starRating; $i++)
                                    <img src="/images/icons/star_nofill.svg" alt="Star" class="h-3 inline mx-[-1px]">
                                @endfor
                            </p>
                            <p class="w-3/4 bg-white h-3 relative">
                                <!-- Green bar showing percentage -->
                                <span class="absolute left-0 top-0 h-full bg-green-500"  style="width: {{ $ratingsPercentage[$starRating] }}%;"></span>
                            </p>
                            <span>{{ $ratingsCount[$starRating] }} </span>
                        </div>
                    @endfor
                </div>
            </div>
            <div class="col-span-12 grid grid-cols-2 my-4 gap-x-8">
                <div class="col-span-2 lg:col-span-1">
                    <h6 class="my-4">{{ $reviewCount }} reviews for {{ $xpage }}</h6>
                    <hr />
                    @if ($reviewCount < 1)
                        <p class="text-slate-900 my-6">There are no reviews yet.</p>
                    @else
                        @foreach ($review_info as $review)
                        <div class="my-4 bg-slate-100">
                            <div class="flex justify-start items-center gap-4 p-4 ">
                            <img src="/user/uploads/profile/{{ $review->user->image ?? 'default_dp.png' }}" alt="" class="h-16 rounded-full">
                                <div>
                                    <h6 class="text-slate-800 font-medium py-2"> {{ $review->name }}</h6>
                                    <?php
                                    $review_rating = $review->rating; // The rating value from your data
                                    $totalStars = 5; // Total number of stars
                                    ?>
                                    <?php for ($i = 1; $i <= $totalStars; $i++): ?>
                                    <span class="<?php echo $i <= $review_rating ? 'text-yellow-500' : 'text-gray-400'; ?>">
                                        &#9733; <!-- Filled star -->
                                    </span>
                                    <?php endfor; ?>
                                    <p class="text-sm text-slate-700">{{ $review->review_message }}</p>
                                </div>
                            </div>

                            @if(count($review->review_images) > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
                                    @foreach($review->review_images as $image)
                                        <div class="w-full aspect-square bg-gray-300 rounded-md">
                                            <img src="{{ asset('user/uploads/review_images/'.$image->image_path) }}" alt="Placeholder Image" class="object-cover w-full h-full rounded-md">
                                        </div>
                                    @endforeach 
                                </div>
                            @endif
                        </div>
                        @endforeach
                    @endif
                </div>
                @php
                    $buyer = Auth::check() && Auth::user()->usertype == 'user' ? true : false;
                @endphp
                
                @if($buyer)
                <div class="col-span-2 lg:col-span-1 ">
                    <h6 class="my-4">
                        @if ($reviewCount < 1)
                            Be the first to review
                        @else
                            Give your review
                        @endif “{{ $xpage }}”
                    </h6>
                    <hr />
                    <form id="reviewForm">
                        <p class="text-slate-900 my-6">Your email address will not be published. Required fields are marked.</p>
                        <p>Your Rating <span class="text-red-700">*</span></p>
                        <p class="space-x-4">
                            <!-- Loop through ratings 1 to 5 -->
                            @for ($rating = 1; $rating <= 5; $rating++)
                                <span>
                                    <input type="radio" name="rating" value="{{ $rating }}"
                                        id="rating-{{ $rating }}">
                                    <label for="rating-{{ $rating }}">
                                        <!-- Display star images equal to the current rating -->
                                        @for ($i = 0; $i < $rating; $i++)
                                            <img src="/images/icons/star.svg" alt="Star"
                                                class="h-3 inline mx-[-1px]">
                                        @endfor
                                    </label>
                                </span>
                            @endfor
                        </p>
                        <div id="rating-error" class="text-red-500"></div>

                        <label for="review" class="block mt-4">Your Review <span class="text-red-600">*</span></label>
                        <textarea name="review" id="review" class="border w-full min-h-40"></textarea>
                        <div id="review-error" class="text-red-500"></div>
                        <input type="text" name="p_id" id="p_id" value="{{ $p_id }}" hidden>
                        <label for="name" class="block mt-4">Your Name <span class="text-red-600">*</span></label>
                        <input type="text" name="name" id="name" class="w-full border leading-8 ">
                        <div id="name-error" class="text-red-500"></div>

                        <label for="email" class="block mt-4">Your Email <span class="text-red-600">*</span></label>
                        <input type="email" name="email" id="email" class="w-full border leading-8 ">
                        <div id="email-error" class="text-red-500"></div>
                        <!-- Image upload section -->
                        <div id="imageUploadSection" class="mt-6">
                            <label class="block mb-2">Upload Images</label>
                            <div id="imageFields" class="flex flex-wrap gap-4">
                                <!-- Initial field -->
                                <div class="relative w-24 h-24 border border-gray-300 rounded flex items-center justify-center overflow-hidden">
                                    <input type="file" name="images[]" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewImage(event, this)">
                                    <img class="w-full h-full object-cover hidden" alt="Preview">
                                    <span class="text-gray-400 text-sm">+</span>
                                </div>
                                <!-- Add More Images Button -->
                                <button type="button" id="addImageFieldBtn" class="relative w-24 h-24 border border-dashed border-blue-500 rounded flex items-center justify-center overflow-hidden bg-blue-100 text-blue-500">
                                    <span class="text-sm">+ Add</span>
                                </button>
                            </div>
                        </div>



                        <button type="button" id="submitBtn" class="block my-8 bg-black text-white px-8 py-2 hover:bg-gray-800">Submit</button>
                    </form>


                </div>
                @else
                <div class="col-span-2 lg:col-span-1 border p-4">
                    <p class="text-center">Please login to add review</p>
                    <a href="{{route('login')}}" class="mx-auto w-fit px-4 py-2 my-4 block bg-orange-500 text-white hover:bg-orange-600">Login</a>
                </div>
                @endif
            </div>
        </div>
        <div class=" col-span-12 lg:col-span-3 sticky-container flex flex-col">
            <div id="sidebar" class="order-3 lg:order-1">

            </div>
            <div class="order-1 lg:order-2 border p-4 ">
                <h6 class="font-semibold ">Sold By</h6>
                <div class="flex justify-between items-center gap-x-2 my-2">
                    <img src="{{ asset('user/uploads/seller/logo/'. ($seller->logo ?? 'bangabasi.jpg')) }}" alt="{{ $seller->store_name ?? 'Unknown'}}" class="w-2/6 rounded-full">
                    <h6 class="w-4/6 text-slate-700 font-semibold text-lg">{{$seller->store_name ?? 'Unknown'}}</h6>
                </div>
                <div class="flex  my-2 border-t border-b">
                    <div class=" flex-1 p-2 ">
                        <p class="text-indigo-700 font-semibold w-fit px-2 border rounded-full my-1" title="{{$seller->average_rating ?? 'not found'}}">{{  number_format($seller->average_rating ?? 0, 1) }} <span>★</span></p>
                        <p class="text-slate-600">{{ $seller->total_reviews > 0 ? $seller->total_reviews . ' ' . Str::plural('Review', $seller->total_reviews) : 'No Reviews Yet' }}</p>
                    </div>
                    <div class=" flex-1 p-2">
                        <p class="text-rose-700 text-center font-semibold min-w-14 w-fit px-2 border rounded-full my-1">{{ $seller->product_count ?? '0'}}</p>
                        <p class="text-slate-600">Products</p>
                    </div>

                </div>

                <button class="mx-auto block px-6 py-2 font-semibold border rounded border-violet-500 group hover:bg-violet-600 hover:text-white">
                    <img src="{{ asset('images/icons/store.png')}}" alt="" class="h-4 mr-4 inline group-hover:invert">
                    View Shop
                </button>
            </div>
            <div class="order-2 lg:order-3 border p-4 my-4">
                <h4 class="text-lg font-semibold text-indigo-900 mb-4">Shipping Information</h4>
                <h6 class="font-semibold text-base"><span class="text-neutral-500">City : </span> {{$seller->pickupAddress->city ?? 'Unknown'}}, {{ $seller->pickupAddress->street ?? 'Unknown'}}</h6>
                <h6 class="font-semibold text-base"><span class="text-neutral-500">Pincode : </span> {{$seller->pickupAddress->pincode ?? 'Unknown'}}, {{ $seller->pickupAddress->state ?? 'Unknown'}}</h6>
            </div>
        </div>

    </div>

    <x-brands />
@endsection

@push('scripts')
    <script id="descriptionToggle">
        function descriptionToggle(event) {
            const clickedTab = event.currentTarget; // The clicked <li> element
            const targetId = clickedTab.getAttribute("data-target"); // Get target content ID

            // Hide all tab content sections
            document.querySelectorAll(".tabs").forEach(tab => tab.classList.add("hidden"));

            // Remove active class from all tabs
            document.querySelectorAll(".tab-link").forEach(tab => tab.classList.remove("bg-slate-200"));

            // Show the targeted tab content
            document.getElementById(targetId)?.classList.remove("hidden");

            // Add active class to the clicked tab
            clickedTab.classList.add("bg-slate-200");
        }
    </script>
    <script>
        function submitWishlistToCart(id, discountedPrice) {
            const selectedSize = document.querySelector('input[name="size"]:checked');
            
            const quantity = parseInt(document.getElementById('cartCount').textContent);

            if (!selectedSize) {
                Swal.fire({
                    title: 'Size Required',
                    text: 'Please select a size before adding the product to the cart.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const availableQuantity = parseInt(selectedSize.dataset.quantity);
            console.log(availableQuantity);
            if (quantity > availableQuantity) {
                Swal.fire({
                    title: 'Insufficient Stock',
                    text: `Only ${availableQuantity} item(s) available for this size.`,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

        @auth
            // If user is logged in, proceed with adding the item to the cart
            document.getElementById('quantity_' + id).value = quantity;
            document.getElementById('selected_size_' + id).value = selectedSize.value;
            const unitPrice = parseFloat(document.getElementById('unit_price_' + id).value);
            const totalPrice = quantity * unitPrice;
            document.getElementById('total_price_' + id).value = totalPrice;

            
            Swal.fire({
                title: 'Product added to cart!',
                text: 'Click OK to view your cart page.',
                icon: 'success',
                confirmButtonText: 'OK',
                preConfirm: () => {
                    document.getElementById('wishlist_addToCart_' + id).submit();
                    return new Promise((resolve) => {
                        setTimeout(() => {
                            window.location.href = "{{ route('cart') }}";
                            resolve();
                        }, 500);
                    });
                }
            });
        @endauth

        @guest
        Swal.fire({
            title: 'You need to login first!',
            text: 'Please log in to add the product to your cart.',
            icon: 'warning',
            confirmButtonText: 'Login',
            preConfirm: () => {
                window.location.href = "{{ route('login') }}";
            }
        });
        @endguest
        }

        function downCount() {
            let count = parseInt(document.getElementById('cartCount').textContent);
            if (count > 1) {
                document.getElementById('cartCount').textContent = count - 1;
            }
        }

        function upCount() {
            let count = parseInt(document.getElementById('cartCount').textContent);
            document.getElementById('cartCount').textContent = count + 1;
        }
    </script>
    <script id="submitReview">
        $(document).ready(function() {
            $('#submitBtn').click(function(e) {
                e.preventDefault();

                // Clear previous errors
                $('#rating-error, #review-error, #name-error, #email-error').html('');

                // Create a FormData object to hold both form data and image files
                var formData = new FormData($('#reviewForm')[0]);
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                $.ajax({
                    url: '{{ route('user.product.reviews.store') }}', // Route name in Laravel
                    type: 'POST',
                    data: formData,
                    processData: false, // Don't process the files
                    contentType: false, // Don't set content type, browser will handle it
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Your review has been submitted!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        $('#reviewForm')[0].reset(); // Reset the form on success
                    },
                    error: function(response) {
                        // Validation error handling
                        if (response.responseJSON.errors.rating) {
                            $('#rating-error').text(response.responseJSON.errors.rating[0]);
                        }
                        if (response.responseJSON.errors.review) {
                            $('#review-error').text(response.responseJSON.errors.review[0]);
                        }
                        if (response.responseJSON.errors.name) {
                            $('#name-error').text(response.responseJSON.errors.name[0]);
                        }
                        if (response.responseJSON.errors.email) {
                            $('#email-error').text(response.responseJSON.errors.email[0]);
                        }
                        Swal.fire({
                            title: 'Error!',
                            text: 'Please correct the highlighted errors.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>
    <script id="addToWishListDefination">
        $(document).ready(function() {
            const addToWishlistUrl = "{{ route('wishlist.add') }}";
            const wishlistUrl = "{{ route('wishlist') }}";

            // Attach click event only to elements that can add to wishlist
            $(document).on('click', 'button.add-to-wishlist', function() {
                const heartIcon = $(this).find('img');
                const productId = $(this).data('product-id');

                if (!productId) {
                    alert('Product ID not found');
                    return;
                }

                // Toggle heart icon state
                heartIcon.attr('src', heartIcon.attr('src').endsWith('heart.svg') ? '/images/icons/heart_fill.svg' : '/images/icons/heart.svg');

                // Check if user is logged in
                $.get('/check-auth', function(data) {
                    if (!data.loggedIn) {
                        // If not logged in, show alert and redirect to login
                        Swal.fire({
                            title: 'You need to log in first!',
                            text: 'Click OK to log in.',
                            icon: 'warning',
                            confirmButtonText: 'OK',
                            preConfirm: () => {
                                window.location.href =
                                    `/login?redirect=${encodeURIComponent(window.location.href)}&product_id=${encodeURIComponent(productId)}`;
                            }
                        });
                    } else if (data.loggedIn && data.userType !== 'user') {
                        // If logged in but the user type is not 'user'
                        Swal.fire({
                            title: 'Access Denied!',
                            text: 'Only users with the correct privileges can add to the wishlist.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        // If logged in, send AJAX request to add to wishlist
                        $.ajax({
                            url: addToWishlistUrl,
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}', // CSRF token
                                product_id: productId
                            },
                            success: function(data) {
                                if (data.success) {
                                    Swal.fire({
                                        title: 'Added to wishlist!',
                                        text: 'Click OK to view your wishlist.',
                                        icon: 'success',
                                        confirmButtonText: 'OK',
                                        preConfirm: () => {
                                            window.location.href =
                                                wishlistUrl;
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: data.message ||
                                            'Unable to add to wishlist. Please try again.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error adding to wishlist:', error);
                            }
                        });
                    }
                });
            });
        });
    </script>
    <script id="loadSidebar">
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/product-sidebar')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Populate the sidebar with the received data
                    const sidebarContainer = document.getElementById('sidebar'); // Change this to your actual sidebar container ID
                    if (sidebarContainer) {
                        sidebarContainer.innerHTML = `
                            <img src="${data.main_image}" alt="Main Image" class="w-full">
                            <div class="min-h-36 bg-slate-100 my-6 px-6">
                                ${data.dialogs.map(dialog => `
                                    <div class="flex items-center gap-x-3 py-4">
                                        ${dialog.svg}
                                        <p>${dialog.text}</p>
                                    </div>
                                `).join('')}
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error fetching sidebar data:', error);
                });
        });
    </script>
    <script id="instantCheckoutDefination">
        $(document).ready(function() {
            const checkOutUrl = "{{ route('instant_checkout') }}";

            // Attach click event only to elements that can add to wishlist
            $(document).on('click', 'button#buyNow', function() {
                //alert('Hello')
                const productId = $(this).data('product-id');

                if (!productId) {
                    alert('Product ID not found');
                    return;
                }

                const selectedSize = document.querySelector('input[name="size"]:checked');               
                const quantity = parseInt(document.getElementById('cartCount').textContent);
                

                if (!selectedSize) {
                    Swal.fire({
                        title: 'Size Required',
                        text: 'Please select a size before buying the product.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                const availableQuantity = parseInt(selectedSize.dataset.quantity);
                console.log(availableQuantity);

                if (quantity > availableQuantity) {
                    Swal.fire({
                        title: 'Insufficient Stock',
                        text: `Only ${availableQuantity} item(s) available for this size.`,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                // Check if user is logged in
                $.get('/check-auth', function(data) {
                    if (!data.loggedIn) {
                        // If not logged in, show alert and redirect to login
                        Swal.fire({
                            title: 'You need to log in first!',
                            text: 'Click OK to log in.',
                            icon: 'warning',
                            confirmButtonText: 'OK',
                            preConfirm: () => {
                                window.location.href = `/login?redirect=${encodeURIComponent(window.location.href)}&product_id=${encodeURIComponent(productId)}`;
                            }
                        });
                    } else if (data.loggedIn && data.userType !== 'user') {
                        // If logged in but the user type is not 'user'
                        Swal.fire({
                            title: 'Access Denied!',
                            text: 'Only users with the correct privileges can add to the wishlist.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        // Redirect to checkout with product_id
                        window.location.href = `${checkOutUrl}?product_id=${productId}&product_quantity=${quantity}&product_size=${selectedSize.value}`;
                    }
                });
            });
        });
    </script>
    <script id="interactiveImage">
        // Preview image function
        function previewImage(event, input) {
            const fileInput = input;
            const previewImg = fileInput.nextElementSibling;
            const placeholder = previewImg.nextElementSibling;

            if (fileInput.files && fileInput.files[0]) {
                const file = fileInput.files[0];

                // Ensure the file is an image
                if (!file.type.startsWith("image/")) {
                    alert("Please upload a valid image file.");
                    fileInput.value = ""; // Reset the input
                    return;
                }

                // Create a FileReader instance
                const reader = new FileReader();

                // Ensure consistent loading by delaying the display update slightly
                reader.onload = (e) => {
                    setTimeout(() => {
                        previewImg.src = e.target.result;
                        previewImg.classList.remove("hidden");
                        placeholder.classList.add("hidden");
                    }, 50); // Short delay to allow DOM stability
                };

                // Trigger reading the file
                reader.readAsDataURL(file);
            }
        }


        // Add more image fields dynamically
        const addImageFieldBtn = document.getElementById('addImageFieldBtn');
        const imageFieldsContainer = document.getElementById('imageFields');

        if(addImageFieldBtn && imageFieldsContainer){
            addImageFieldBtn.addEventListener('click', () => {
                // Create a new field
                const newField = document.createElement('div');
                newField.classList.add( 'relative', 'w-24', 'h-24', 'border', 'border-gray-300', 'rounded', 'flex', 'items-center', 'justify-center', 'overflow-hidden');

                newField.innerHTML = `
                    <input type="file" name="images[]" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewImage(event, this)">
                    <img class="w-full h-full object-cover hidden" alt="Preview">
                    <span class="text-gray-400 text-sm">+</span>
                `;

                // Insert the new field before the add button
                imageFieldsContainer.insertBefore(newField, addImageFieldBtn);
            });
        }
        

    </script>
    <script id="serviceAbility">
        document.querySelector('#checkPinCode').addEventListener('submit', async (e) => {
            e.preventDefault();

            const pickupPostcode = document.querySelector('input[name="pickup_postcode"]').value;
            const deliveryPostcode = document.querySelector('input[name="delivery_postcode"]').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            try {
                const response = await fetch('{{ route('shiprocket.serviceability') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        pickup_postcode: pickupPostcode,
                        delivery_postcode: deliveryPostcode,
                    }),
                });

                const data = await response.json();
                const estDelivery = document.getElementById('estDelivery');
                const cutOffTime = document.getElementById('cutOffTime');
                const courierError = document.getElementById('courierError');
                const actionArea = document.querySelector('#actionArea')
                const toCartBtn = document.querySelector('#toCartBtn')


                if (data.status === 200) {
                    // Handle available couriers
                    let courier;
                    const recommendedCourierId = data.shiprocket_recommended_courier_id;

                    if (recommendedCourierId) {
                        courier = data.data.available_courier_companies.find(c => c.courier_company_id === recommendedCourierId);
                    }

                    // If no recommended courier, pick the first one
                    if (!courier) {
                        courier = data.data.available_courier_companies[0];
                    }

                    if (courier) {
                        estDelivery.textContent = `Delivered in ${courier.estimated_delivery_days || courier.etd} days | ${courier.courier_name}`;
                        cutOffTime.textContent = `if ordered before ${courier.cutoff_time}`;
                        actionArea.style.pointerEvents = 'auto';
                        actionArea.classList.remove('grayscale', 'bg-gray-100');
                        toCartBtn.classList.remove('bg-neutral-600');
                        toCartBtn.classList.add('bg-black');
                        courierError.textContent = '';
                    }
                } else {
                    // Handle error response
                    if (data.message) {
                        estDelivery.textContent = '';
                        cutOffTime.textContent = '';
                        courierError.textContent = `${data.message}`;
                        actionArea.style.pointerEvents = 'none';
                        actionArea.classList.add('grayscale', 'bg-gray-100');
                        toCartBtn.classList.add('bg-neutral-600');
                        toCartBtn.classList.remove('bg-black');
                    }
                    else{
                        courierError.textContent = 'Something went wrong. Please try again later.';
                    }
                }
            } catch (error) {
                console.error('Unexpected error:', error);
                courierError.textContent = 'Internal server error. ';
            }
        });
    </script>
@endpush