@extends('layouts.master')
@section('head')
<title>Bangabasi | eCommerce for Bengal</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
@php
$xpage = 'Sale';
$xprv = 'home';
@endphp
<x-bread-crumb :page="$xpage" :previousHref="$xprv" />

<section class="exactly my-8" id="topBar"></section>

<section class="product-gird">
    <div class="container grid grid-cols-12 gap-4 border">
        <div class="col-span-12 md:col-span-3 p-4 ">
            <h3 class="text-gray-700 text-sm font-semibold uppercase my-4 py-4 border-b-2">Filter by categories</h3>
            <input type="text" name="" id="" class="w-full leading-8 border px-4 focus:outline-none focus:border-black" placeholder="Find a category">
            <div class="h-80 overflow-y-auto py-4 my-4">

                @foreach ($filterSubCategories as $subCategory)
                <div class="my-1 subCategory">
                    <input type="checkbox" name="sub_categories[]" id="subcategory-{{ $subCategory->id }}" value="{{ $subCategory->id }}" @if(request()->get('sub_category') == $subCategory->id) checked @endif>
                    <label for="subcategory-{{ $subCategory->id }}" class="mx-4 text-gray-600 capitalize">{{ $subCategory->name }}</label>
                </div>
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
                    <form action="{{ route('products.sale') }}" method="GET">
                        @php

                        $subCategoryId = request()->get('sub_category');
                        @endphp
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
                <input type="radio" name="stock" id="inStock" value="1" {{ request('stock') === '1' ? 'checked' : '' }} onchange="updateStockFilter(1)">
                <label for="inStock" class="mx-4 text-gray-600 capitalize">In Stock</label>
            </div>
            <div class="my-2">
                <input type="radio" name="stock" id="outStock" value="0" {{ request('stock') === '0' ? 'checked' : '' }} onchange="updateStockFilter(0)">
                <label for="outStock" class="mx-4 text-gray-600 capitalize">Out of Stock</label>
            </div>
            <div class="my-2">
                <input type="radio" name="stock" id="allStock" value="" {{ request()->has('stock') ? '' : 'checked' }} onchange="updateStockFilter('')">
                <label for="allStock" class="mx-4 text-gray-600 capitalize">All</label>
            </div>
        </div>
        <div class="col-span-12 md:col-span-9 ">
            <div class="flex justify-between p-4 ">
                <select name="" id="sorting_type" class="px-4 py-2 border focus:outline-none focus:border-black">
                    <option value="default">Default Sorting</option>
                    <option value="rating" {{ request('sorting') == 'rating' ? 'selected' : '' }}>Sort by Rating</option>
                    <option value="latest" {{ request('sorting') == 'latest' ? 'selected' : '' }}>Sort by Latest</option>
                    <option value="high-to-low" {{ request('sorting') == 'hight-to-low' ? 'selected' : '' }}>Sort by Price: High to Low</option>
                    <option value="low-to-high" {{ request('sorting') == 'low-to-high' ? 'selected' : '' }}>Sort by Price Low to High</option>
                </select>
                <select name="" id="limit" class="px-4 py-2 border focus:outline-none focus:border-black">
                    <option value="0">Show All</option>
                    <option value="10" {{ request('limit') == '10' ? 'selected' : '' }}>10</option>
                    <option value="20" {{ request('limit') == '20' ? 'selected' : '' }}>20</option>
                    <option value="50" {{ request('limit') == '50' ? 'selected' : '' }}>50</option>
                </select>
            </div>
            <div class="flex flex-wrap gap-8 justify-evenly">

                @if (count($saleProducts) == 0)
                <h1 class="text-3xl font-bold text-center text-gray-500" style="text-align: center;margin-top:40px;">No products to Show!</h1>
                @else
                @foreach ($saleProducts as $product)

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
                @php
                $image = null;
                @endphp
                @endif
                <x-product-card :image="$image" :category="$product->categoryDetails->name" :title="$product['name']" :rating="$ratings" :originalPrice="$product['original_price']" :discountedPrice="$product['offer_price']" :id="$product->id" :inStock="$product->in_stock" />
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
            layout: 'layout2'
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
                //console.log(data);

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
    function updateStockFilter(value) {
        const url = new URL(window.location.href);
        
        if (value === '') {
            // Remove the stock parameter if the "All" option is selected
            url.searchParams.delete('stock');
        } else {
            // Set or replace the stock parameter
            url.searchParams.set('stock', value);
        }

        // Redirect to the updated URL
        window.location.href = url.toString();
    }
</script>
@endpush