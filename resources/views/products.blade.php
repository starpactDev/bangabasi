@extends('layouts.master')
@section('head')
<title>Bangabasi | eCommerce for Bengal</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
@php

$subCategoryId = request()->get('sub_category');

if($subCategoryId){
    $subCategory = \App\Models\SubCategory::find($subCategoryId);
    $category = \App\Models\Category::where('id', $subCategory->category_id)->first();
    $subCategoryName = $subCategory ? $subCategory->name : 'All Products';
    $xpage = $category->name .' ⮚ '. $subCategoryName;
    $xprv = 'home';
}

@endphp

@if ($subCategoryId)
<x-bread-crumb :page="$xpage" :previousHref="$xprv" />
@endif
<section class="exactly my-8" id="topBar"></section>

<section class="product-gird">
    <div class="container grid grid-cols-12 gap-4 border">
        <div class="col-span-12 md:col-span-3 md:order-1 order-2 p-4 ">
            <!-- 
                    <h3 class="text-gray-700 text-sm font-semibold uppercase my-4 py-4 border-b-2">Vendors List</h3>
                        <input type="text" name="" id="" class="w-full leading-8 border px-4 focus:outline-none focus:border-black" placeholder="Search Vendor">
                        <ul>
                            <li class="py-2 flex gap-6 cursor-pointer hover:text-gray-800 hover:shadow-md">
                                <img src="/images/sticker/fashion.png" alt="" class="w-1/6 border rounded-full">
                                    <p class="py-4">Fabric Seller</p>
                            </li>
                            <li class="py-2 flex gap-6 cursor-pointer hover:text-gray-800 hover:shadow-md">
                                <img src="/images/sticker/clothes.png" alt="" class="w-1/6 border rounded-full">
                                    <p class="py-4">Clothes Seller</p>
                            </li>
                            <li class="py-2 flex gap-6 cursor-pointer hover:text-gray-800 hover:shadow-md">
                                <img src="/images/sticker/krishna.png" alt="" class="w-1/6 border rounded-full">
                                    <p class="py-4">Dashakarma Seller</p>
                            </li>
                            <li class="py-2 flex gap-6 cursor-pointer hover:text-gray-800 hover:shadow-md">
                                <img src="/images/sticker/sewing.png" alt="" class="w-1/6 border rounded-full">
                                    <p class="py-4">Sewing Seller</p>
                            </li>

                        </ul> 
                    -->


            <h3 class="text-gray-700 text-sm font-semibold uppercase my-4 py-4 border-b-2">Filter by categories</h3>
            <input type="text" name="" id="" class="w-full leading-8 border px-4 focus:outline-none focus:border-black" placeholder="Find a category">
            <div class="h-80 overflow-y-auto py-4 my-4">
         
                @foreach ($filterSubCategories as $subCategory)
               
                @if($products->isNotEmpty() && $products[0]->sub_category == $subCategory->id)
                <div class="my-1 subCategory">
                    <input type="checkbox" name="sub_categories[]" id="subcategory-{{ $subCategory->id }}" value="{{ $subCategory->id }}" checked>
                    <label for="subcategory-{{ $subCategory->id }}" class="mx-4 text-gray-600 capitalize">{{ $subCategory->name }}</label>
                </div>
                @else
                <div class="my-1 subCategory">
                    <input type="checkbox" name="sub_categories[]" id="subcategory-{{ $subCategory->id }}" value="{{ $subCategory->id }}">
                    <label for="subcategory-{{ $subCategory->id }}" class="mx-4 text-gray-600 capitalize">{{ $subCategory->name }}</label>
                </div>
                @endif
                @endforeach
               

            </div>
            <div id="price-filter">
                <h3 class="text-gray-700 text-sm font-semibold uppercase my-4 py-4 border-b-2">Filter by price</h3>
                <div class="my-1">
                    <input type="checkbox" name="price1" id="price1">
                    <label for="price1" class="mx-4 text-gray-600 capitalize">₹500 - ₹999</label>
                </div>
                <div class="my-1">
                    <input type="checkbox" name="price2" id="price2">
                    <label for="price2" class="mx-4 text-gray-600 capitalize">₹1000 - ₹1499</label>
                </div>
                <div class="my-1">
                    <input type="checkbox" name="price3" id="price3">
                    <label for="price3" class="mx-4 text-gray-600 capitalize">₹1500 - ₹2000</label>
                </div>
                <div class="my-4">
                    
                    <form action="{{ route('user.products.filter') }}" method="GET">
                        @if($subCategoryId)
                    <input type="hidden" name="sub_category" value="{{ $subCategoryId }}">
                    @else
                    <input type="hidden" name="sub_category_ids" value="{{ $filterSubCategories }}">

                    @endif

                        <input type="number" name="min" id="minPrice"
                            class="w-1/4 border px-2 leading-8"
                            placeholder="min"
                            value="{{ request('min') }}">

                        <input type="number" name="max" id="maxPrice"
                            class="w-1/4 border px-2 leading-8 mx-4"
                            placeholder="max"
                            value="{{ request('max') }}">

                        <input type="submit" value="Apply"
                            class="w-4/12 text-white cursor-pointer bg-red-200 hover:bg-red-500 leading-8">
                    </form>
                </div>
            </div>

            <h3 class="text-gray-700 text-sm font-semibold uppercase my-4 py-4 border-b-2">Product Status</h3>
            <div class="my-2">
                <input type="checkbox" name="stock" id="inStock" value="1"  {{ request()->get('stock') === '1' ? 'checked' : '' }}  onclick="updateStockFilter(1)">
                <label for="inStock" class="mx-4 text-gray-600 capitalize">In Stock</label>
            </div>
            <div class="my-2">
                <input type="checkbox" name="stock" id="outStock" value="0"  {{ request()->get('stock') === '0' ? 'checked' : '' }}  onclick="updateStockFilter(0)">
                <label for="outStock" class="mx-4 text-gray-600 capitalize">Out of Stock</label>
            </div>


            <!-- <h3 class="text-gray-700 text-sm font-semibold uppercase my-4 py-4 border-b-2">Average Rating</h3>
                            <div class="my-2">
                                <input type="checkbox" name="fourPlus" id="fourPlus">
                                <label for="fourPlus" class="mx-4 text-yellow-400 leading-8 text-xl capitalize">&bigstar;&bigstar;&bigstar;&bigstar;&bigstar;</label>
                            </div>
                            <div class="my-2">
                                <input type="checkbox" name="threePlus" id="threePlus">
                                <label for="threePlus" class="mx-4 text-yellow-400 leading-8 text-xl capitalize">&bigstar;&bigstar;&bigstar;&bigstar;</label>
                            </div> -->
            <!-- <h3 class="text-gray-700 text-sm font-semibold uppercase my-4 py-4 border-b-2">Products Tags</h3>
                            @php
                                $jsonPath = public_path('data/tags.json'); // Path to your JSON file
                                $tags = [];

                                if (file_exists($jsonPath)) {
                                    $json = file_get_contents($jsonPath);
                                    $tags = json_decode($json, true);
                                }
                                shuffle($tags);
                            @endphp

                            <div class="flex flex-wrap gap-2">
                            @foreach ($tags as $tag)
                                <a href="" class="bg-gray-300 px-3 py-1 leading-8 hover:bg-orange-600 hover:text-white">{{ $tag }}</a>
                                @endforeach
                            </div> -->
        </div>
        <div class="col-span-12 md:col-span-9 md:order-2 order-1">
            <div class="flex justify-between p-4 gap-4">
                <select name="" id="sorting_type" class="px-4 py-2 w-1/2 max-w-48 border focus:outline-none focus:border-black">
                    <option value="default">Default Sorting</option>
                    <option value="rating" {{ request('sorting') == 'rating' ? 'selected' : '' }}>Sort by Rating</option>
                    {{-- <option value="2">Sort by Popularity</option> --}}
                    <option value="latest" {{ request('sorting') == 'latest' ? 'selected' : '' }}>Sort by Latest</option>
                    <option value="high-to-low" {{ request('sorting') == 'hight-to-low' ? 'selected' : '' }}>Sort by Price: High to Low</option>
                    <option value="low-to-high" {{ request('sorting') == 'low-to-high' ? 'selected' : '' }}>Sort by Price Low to High</option>
                </select>
                <select name="" id="limit" class="px-4 py-2 w-1/2 max-w-48 border focus:outline-none focus:border-black">
                    <option value="0">Show All</option>
                    <option value="10" {{ request('limit') == '10' ? 'selected' : '' }}>10</option>
                    <option value="20" {{ request('limit') == '20' ? 'selected' : '' }}>20</option>
                    <option value="50" {{ request('limit') == '50' ? 'selected' : '' }}>50</option>
                </select>
            </div>
            <div class="flex flex-wrap gap-8 justify-evenly">
                @if (count($products) == 0)
                    <h1 class="text-3xl font-bold text-center text-gray-500" style="text-align: center;margin-top:40px;">No products to Show!</h1>
                @else
                    @foreach ($products as $product)
                        @php
                            // Calculate average rating using Laravel's avg method or fallback to 0 if no reviews
                            $ratings = $product->reviews->avg('rating') ?: 0;
                            // Get the first product image or set default
                            $image = $product->productImages->first()->image ?? null;
                        @endphp
                        <x-product-card :image="$image" :category="$product->categoryDetails->name" :title="$product['name']" :rating="$ratings"
                            :originalPrice="$product['original_price']" :discountedPrice="$product['offer_price']" :id="$product->id" :inStock="$product->in_stock" :discountThreshold="$discountThreshold" />
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>

<x-brands />
@endsection

@push('scripts')

<script id="loadTopbar">
    function fetchTopbars(layout) {
        const data = {
            layout: 'layout1'
        };
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/topbars', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(data),
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok ' + response.statusText);
                return response.text();
            })
            .then(data => {
                // Log fetched data
                console.log(data);

                // Select main container
                const container = document.getElementById('topBar');

                // Clear existing content in case of multiple calls
                container.innerHTML = data;


            })
            .catch(error => {
                console.error('There has been a problem with your fetch operation:', error);
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const layoutType = 'layout1';
        fetchTopbars(layoutType);
    });
</script>

<script>
    $("#sorting_type").change(function() {
        let value = $(this).val();
        // window.location.href = window.location.href+`?sorting=${value}`;
        var p = window.location.search;

        var urlParams = new URLSearchParams(window.location.search);
        urlParams.set('sorting', value);
        window.location.search = urlParams.toString();

    })

    $("#limit").change(function() {
        let value = $(this).val();
        // window.location.href = window.location.href+`?limit=${value}`;


        var urlParams = new URLSearchParams(window.location.search);

        if (value == 0 || value == '0') {

            urlParams.delete('limit');
        } else {
            urlParams.set('limit', value);
        }

        window.location.search = urlParams.toString();

    })
</script>
<script id="searchSubCategory">
    document.addEventListener("DOMContentLoaded", () => {
        const searchInput = document.querySelector('input[placeholder="Find a category"]');
        const categoryDivs = document.querySelectorAll('.h-80 .my-1');

        searchInput.addEventListener("input", (event) => {
            const searchValue = event.target.value.toLowerCase();

            categoryDivs.forEach((categoryDiv) => {
                const label = categoryDiv.querySelector('label').textContent.toLowerCase();
                if (label.includes(searchValue)) {
                    categoryDiv.style.display = "block";
                } else {
                    categoryDiv.style.display = "none";
                }
            });
        });
    });
</script>
<script id="redirectSubCategory">
    document.addEventListener("DOMContentLoaded", () => {
        const categoryCheckboxes = document.querySelectorAll('input[name="sub_categories[]"]');

        const redirectToCategory = (event) => {
            const selectedCategory = event.target.value;

            // Construct the URL
            const params = new URLSearchParams();
            params.append("sub_category", selectedCategory);

            // Redirect to the new URL
            const newUrl = `${window.location.pathname}?${params.toString()}`;
            window.location.href = newUrl;
        };

        // Attach event listeners to checkboxes
        categoryCheckboxes.forEach((checkbox) => {
            checkbox.addEventListener("change", redirectToCategory);
        });
    });
</script>
<script id="minMaxPopulate">
    document.addEventListener("DOMContentLoaded", () => {
        const priceFilterContainer = document.querySelector("#price-filter");
        if (!priceFilterContainer) return; // Exit if the container is not found

        const checkboxes = priceFilterContainer.querySelectorAll('input[type="checkbox"]');
        const minInput = priceFilterContainer.querySelector('#minPrice');
        const maxInput = priceFilterContainer.querySelector('#maxPrice');
        const applyButton = priceFilterContainer.querySelector('input[type="submit"]');

        // Mapping of checkbox IDs to min-max values
        const priceRanges = {
            price1: {
                min: 500,
                max: 999
            },
            price2: {
                min: 1000,
                max: 1499
            },
            price3: {
                min: 1500,
                max: 2000
            },
        };

        const handleCheckboxChange = (event) => {
            const checkbox = event.target;

            if (checkbox.checked) {
                // Set min and max values based on the selected checkbox
                const {
                    min,
                    max
                } = priceRanges[checkbox.id] || {};
                minInput.value = min || '';
                maxInput.value = max || '';

                // Enable and style the Apply button
                applyButton.disabled = false;
                applyButton.classList.remove('bg-gray-200');
                applyButton.classList.add('bg-orange-600');
            } else {
                // Clear the min and max values if the checkbox is unchecked
                minInput.value = '';
                maxInput.value = '';

                // Disable and reset the Apply button if no other checkboxes are checked
                if (!Array.from(checkboxes).some((cb) => cb.checked)) {
                    applyButton.disabled = true;
                    applyButton.classList.remove('bg-orange-600');
                    applyButton.classList.add('bg-gray-200');
                }
            }
        };

        // Initialize the Apply button as disabled
        applyButton.disabled = true;
        applyButton.classList.add('bg-gray-200');
        applyButton.classList.remove('bg-orange-600');

        // Attach change event listeners to the checkboxes
        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', handleCheckboxChange);
        });
    });
</script>
<script id="enableApply">
    document.addEventListener("DOMContentLoaded", () => {
        const priceFilterContainer = document.querySelector("#price-filter");
        if (!priceFilterContainer) return; // Exit if the container is not found

        const minInput = priceFilterContainer.querySelector('input[placeholder="min"]');
        const maxInput = priceFilterContainer.querySelector('input[placeholder="max"]');
        const applyButton = priceFilterContainer.querySelector('input[type="submit"]');

        const validateInputs = () => {
            const minValue = parseFloat(minInput.value);
            const maxValue = parseFloat(maxInput.value);

            // Check if both min and max values are valid numbers and min is less than max
            if (!isNaN(minValue) && !isNaN(maxValue) && minValue < maxValue) {
                applyButton.disabled = false;
                applyButton.classList.remove('bg-gray-200');
                applyButton.classList.add('bg-orange-600');
            } else {
                applyButton.disabled = true;
                applyButton.classList.remove('bg-orange-600');
                applyButton.classList.add('bg-gray-200');
            }
        };

        // Attach input event listeners to both fields
        minInput.addEventListener("input", validateInputs);
        maxInput.addEventListener("input", validateInputs);

        // Initialize the Apply button as disabled
        applyButton.disabled = true;
        applyButton.classList.add('bg-gray-200');
        applyButton.classList.remove('bg-orange-600');
    });
</script>
<script id="stockFilter">
    function updateStockFilter(stockValue) {
        const url = new URL(window.location.href);
        const params = url.searchParams;

        // Update the stock parameter
        params.set('stock', stockValue);

        // Remove the other checkbox from URL if toggled
        if (stockValue == 1) {
            params.delete('outStock');
        } else if (stockValue == 0) {
            params.delete('inStock');
        }

        // Redirect to the updated URL
        window.location.href = url.toString();
    }
</script>
@endpush