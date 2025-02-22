@extends('layouts.master')
@section('head')
    <title>Bangabasi | Wishlist</title>
@endsection
@section('content')
    @php
        $xpage = 'Wishlist';
        $xprv = 'home';
    @endphp
    <x-bread-crumb :page="$xpage" :previousHref="$xprv" />
    <x-navigation-tabs />
    
    <div class="container py-8 px-4">
        <h1>My WishList</h1>
    </div>

    <div class="container grid grid-cols-4 md:grid-cols-8 lg:grid-cols-12 gap-16 lg:gap-24 ">

        @foreach ($wishlists as $product)
        @php
            $product_id = $product['id'];
            $sizes = App\Models\ProductSize::where('product_id', $product_id)->get();
            $image = App\Models\ProductImage::where('product_id', $product_id)->first();
        @endphp
            <x-wish-card :image="$image" :id="$product['wishlist_id']" :title="$product['name']" :originalPrice="$product['original_price']" :discountedPrice="$product['offer_price']"
                :inStock="$product['in_stock']" :sizes="$sizes" />
        @endforeach
    </div>

    <div class="container py-8 bg-slate-100 my-4 px-4">
        {{-- <p class="text-center"><span class="inline-block w-8 mx-4 rounded-full border border-neutral-800 cursor-pointer hover:bg-orange-200">1</span><span class="inline-block w-8 mx-4 rounded-full border border-neutral-800 cursor-pointer hover:bg-orange-200">2</span><span class="inline-block w-8 mx-4 rounded-full border border-neutral-800 cursor-pointer hover:bg-orange-200">3</span></p> --}}
        {{ $wishlists->links() }}
    </div>
@endsection
