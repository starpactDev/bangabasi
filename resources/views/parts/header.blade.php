@php
    use App\Models\Category;
    use App\Models\SubCategory;

    // Fetch active categories
    $activeCategoryIds = Category::where('status', 'active')->pluck('id');
    $activeCategory = Category::where('status', 'active')->get();

    // Fetch sub-categories for these active categories
    $subCategories = SubCategory::whereIn('category_id', $activeCategoryIds)->get();

    // Check if there are enough sub-categories to pick from
    $numberToSelect = 5;
    $subCategoryCount = $subCategories->count();

    if ($subCategoryCount > $numberToSelect) {
        // Randomly select 5 sub-categories
        $products = $subCategories->random($numberToSelect);
    } else {
        // If not enough sub-categories, return all available
        $products = $subCategories;
    }
@endphp

<header class="w-full lg:sticky top-0 z-50 ">

    {{-- First Row Start --}}

    <div class="w-full bg-gradient-to-r from-orange-500 to-orange-400 px-4 md:px-12 py-1 md:py-2 ">
        <div class="w-full flex flex-wrap gap-x-4 items-center justify-between">
            {{-- Logo Section --}}
            <div class="min-w-32 order-1 ">
                <a href="{{ route('home') }}">
                    @if (isset($logos['1']))
                        <img src={{ asset('user/uploads/logos/' . $logos['1']->image_path) }}
                            class="h-auto max-w-32 lg:max-w-48" alt="Bangabasi Main Logo" />
                    @endif
                </a>
            </div>

            {{-- Search Section --}}
            <div
                class="w-full md:w-[55%] min-w-64 h-8 md:h-12 border-2 border-white rounded-full bg-white order-3 md:order-2">
                <div class="w-full flex h-full px-2 md:px-6 items-center">
                    <div class="flex justify-around items-center h-full rounded-l-full w-1/5 min-w-32 relative">
                        <select id="categoryDropdown"
                            class="bg-transparent w-full appearance-none outline-none md:pr-6">
                            <option value="all-categories">All categories</option>
                            @foreach ($global_categories as $category)
                                @if ($category->subCategories->count())
                                    <optgroup label="{{ strtoupper($category->name) }}">
                                        @foreach ($category->subCategories as $subCategory)
                                            <option value="{{ $subCategory->id }}" class="">
                                                {{ $subCategory->name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endif
                            @endforeach
                        </select>
                        <i
                            class="fa-solid fa-angle-down absolute right-2 top-1/2 transform -translate-y-1/2 pointer-events-none"></i>
                    </div>


                    <div class="w-3/4 pl-2 md:pl-6">
                        <input id="search_bar" class="w-full h-full px-4 outline-none" placeholder="Search"
                            onkeyup="searchProducts()">
                    </div>
                    <p style="cursor: pointer;" onclick="searchProductsOnClick()">
                        <i class="fa fa-search"></i>
                    </p>

                </div>

                <div id="search_result" class="w-full border mt-2 relative bg-white shadow-lg"
                    style="display: none; z-index: 9999;">
                    <div id="search_header" class="w-full flex justify-between items-center bg-gray-100 py-2 px-4">
                        <div class="text-sm font-semibold">
                            RECOMMENDED FOR YOU
                        </div>
                        <div class="hover: cursor-pointer">
                            Refresh <i class="fa fa-refresh"></i>
                        </div>
                    </div>
                    <div id="results_container">
                        @foreach ($products as $product)
                            <div class="w-full flex items-center gap-4 hover:bg-gray-200/30 hover:cursor-pointer mt-2 py-2 px-4"
                                data-subcategory="{{ $product->id }}">
                                <div>
                                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </div>
                                </div>
                                <div class="text-md text-red-600 font-semibold">
                                    {{ $product->name }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Cart Section --}}

            <div class="w-[20%] min-w-32 order-2 md:order-3">
                <div class="w-full flex justify-between items-center text-white py-1 md:py-2 px-4 font-bold text-lg">
                    <div class=" relative hover:cursor-pointer hover:text-gray-200"> <span
                            class="hidden xl:inline">Track Order</span> <i class="fa-regular fa-clock"></i></div>
                    @php
                        // Check if the user is authenticated and fetch the wishlist count
                        $wishlistCount = Auth::check()
                            ? \App\Models\Wishlist::where('user_id', Auth::id())->count()
                            : 0;
                        $cartCount = Auth::check() ? \App\Models\Cart::where('user_id', Auth::id())->count() : 0;
                    @endphp
                    <div class="relative hover:cursor-pointer hover:text-gray-200">
                        <a href="{{ route('wishlist') }}">
                            <i class="fa-regular fa-heart"></i>
                        </a>
                        <span
                            class="absolute top-0 -right-3 inline-flex items-center justify-center w-4 h-4 ms-2 text-xs font-semibold text-gray-800 bg-yellow-300 rounded-full">
                            {{ $wishlistCount }}
                        </span>
                    </div>

                    <div class="relative hover:cursor-pointer hover:text-gray-200">
                        <a href="{{ route('cart') }}">
                            <i class="fa fa-shopping-cart"></i>
                        </a>
                        <span
                            class="absolute top-0 -right-3 inline-flex items-center justify-center w-4 h-4 ms-2 text-xs font-semibold text-gray-800 bg-yellow-300 rounded-full">
                            {{ $cartCount }}
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- First Row End --}}

    {{-- Second Row Start --}}

    <div class="w-full bg-[#c44601] text-white py-2 px-12 hidden lg:block">
        <div class="w-full hidden lg:flex justify-between">
            <div id="all_categories" class="md:w-auto dropdown ">
                <i class="fa-solid fa-layer-group"></i>
                <span class="font-bold text-md pl-2"> All Categories </span>
                <span>
                    <i class="fa-solid fa-angle-down"></i>
                </span>

                <div class="dropdown-content-1">
                    <div class="w-[320px] bg-white text-black mt-10 ml-12">

                        <div
                            class="py-3 px-6 text-sm border-b  border-gray-300 sub-menu hover:cursor-pointer hover:bg-gray-100">

                            <div class=" w-full flex items-center justify-between">
                                <div class="flex gap-4">
                                    <img src="{{ asset('images/icons/menu_1.png') }}" class="w-18">
                                    {{ $activeCategory->get(0)->name ?? 'Category not found' }}
                                </div>


                                <span>
                                    <i class="fa-solid fa-angle-right"></i>
                                </span>
                            </div>

                            @include('parts.dropdown-content.clothes')

                        </div>

                        <div
                            class="py-3 px-6 text-sm border-b border-gray-300 sub-menu hover:cursor-pointer hover:bg-gray-100">

                            <div class=" w-full flex items-center justify-between">
                                <div class="flex gap-4">
                                    <img src="{{ asset('images/icons/menu_2.png') }}" class="w-18">
                                    {{ $activeCategory->get(1)->name ?? 'Category not found' }}
                                </div>
                                <span>
                                    <i class="fa-solid fa-angle-right"></i>
                                </span>
                            </div>

                            @include('parts.dropdown-content.food')

                        </div>


                        <div
                            class="py-3 px-6 text-sm border-b border-gray-300 sub-menu hover:cursor-pointer hover:bg-gray-100">

                            <div class=" w-full flex items-center justify-between">
                                <div class="flex gap-4">
                                    <img src="{{ asset('images/icons/menu_3.png') }}" class="w-18">
                                    {{ $activeCategory->get(2)->name ?? 'Category not found' }}
                                </div>
                                <span>
                                    <i class="fa-solid fa-angle-right"></i>
                                </span>
                            </div>

                            @include('parts.dropdown-content.dashakarma')

                        </div>

                        <div
                            class="py-3 px-6 text-sm border-b border-gray-300 sub-menu hover:cursor-pointer hover:bg-gray-100">

                            <div class=" w-full flex items-center justify-between">
                                <div class="flex gap-4">
                                    <img src="{{ asset('images/icons/menu_4.png') }}" class="w-18">
                                    {{ $activeCategory->get(3)->name ?? 'Category not found' }}
                                </div>
                                <span>
                                    <i class="fa-solid fa-angle-right"></i>
                                </span>
                            </div>

                            @include('parts.dropdown-content.handcraft')

                        </div>

                        <div
                            class="py-3 px-6 text-sm border-b border-gray-300 sub-menu hover:cursor-pointer hover:bg-gray-100">

                            <div class=" w-full flex items-center justify-between">
                                <div class="flex gap-4">
                                    <img src="{{ asset('images/icons/menu_5.png') }}" class="w-18">
                                    {{ $activeCategory->get(4)->name ?? 'Category not found' }}
                                </div>
                                <span>
                                    <i class="fa-solid fa-angle-right"></i>
                                </span>
                            </div>

                            @include('parts.dropdown-content.mens-grooming')

                        </div>

                        <div
                            class="py-3 px-6 text-sm border-b border-gray-300 sub-menu hover:cursor-pointer hover:bg-gray-100">

                            <div class=" w-full flex items-center justify-between">
                                <div class="flex gap-4">
                                    <img src="{{ asset('images/icons/menu_6.png') }}" class="w-18">
                                    {{ $activeCategory->get(5)->name ?? 'Category not found' }}
                                </div>
                                <span>
                                    <i class="fa-solid fa-angle-right"></i>
                                </span>
                            </div>

                            @include('parts.dropdown-content.machinery')

                        </div>

                        <div
                            class="py-3 px-6 text-sm border-b border-gray-300 sub-menu hover:cursor-pointer hover:bg-gray-100">

                            <div class=" w-full flex items-center justify-between">
                                <div class="flex gap-4">
                                    <img src="{{ asset('images/icons/plug.png') }}" class="w-18">
                                    {{ $activeCategory->get(6)->name ?? 'Category not found' }}
                                </div>
                                <span>
                                    <i class="fa-solid fa-angle-right"></i>
                                </span>
                            </div>

                            @include('parts.dropdown-content.electronics')
                        </div>

                    </div>
                </div>
            </div>


            <div class="md:w-auto flex justify-end items-center">

                <div class=" flex gap-6 items-center font-semibold text-sm">

                    <div class="menu-item text-white">
                        <a href="{{ route('seller_index') }}">Become a Seller</a>
                    </div>

                    <div class="menu-item text-white">
                        <a href="{{ route('sellers.index') }}">Shops</a>
                    </div>

                    <div class="menu-item text-white">
                        <a href="{{ route('about-us') }}">About Us</a>
                    </div>

                    <div class="menu-item text-white">
                        <a href="{{ route('blogs') }}">Blogs</a>
                    </div>

                    <div class="menu-item text-white">
                        <a href="{{ route('contact-us') }}">Contact US</a>
                    </div>

                </div>
            </div>
            <div class=" menu-item">
                @guest
                    <a href="{{ route('login') }}" class="px-5 py-1 border text-white">
                        <i class="fa-regular fa-user pr-2"> </i>
                        Login / Register
                    </a>
                @else
                    <div class=" dropdown text-white text-md  p-2 -m-2" style=" z-index: 9999999 !important; ">
                        {{ auth()->user()->firstname }}
                        <i class=" fa-solid fa-angle-down "> </i>

                        <div class="dropdown-content-profile" style=" z-index: 9999 !important; ">
                            <div class="w-full bg-white text-gray-700">
                                <div class="p-2 px-4 hover:cursor-pointer hover:bg-gray-100">
                                    <a href="{{ route('myprofile') }}">
                                        <div class="flex w-full items-center gap-2">
                                            <i class="fa-solid fa-user"></i>
                                            Profile
                                        </div>
                                    </a>

                                </div>
                                <div class="p-2 px-4 hover:cursor-pointer hover:bg-gray-100">

                                    <a href="{{ route('wishlist') }}">
                                        <div class="flex w-full items-center gap-2">
                                            <i class="fa-solid fa-heart"></i>
                                            Wishlist
                                        </div>
                                    </a>

                                </div>
                                <div class="p-2 px-4 hover:cursor-pointer hover:bg-gray-100">

                                    <a href="{{ route('myorders') }}">
                                        <div class="flex w-full items-center gap-2">
                                            <i class="fa fa-shopping-bag"></i>
                                            Orders
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2 px-4 hover:cursor-pointer hover:bg-gray-100">
                                    <div class="flex w-full items-center gap-2">
                                        <i class="fa fa-undo"></i>
                                        Return Items
                                    </div>
                                </div>

                                <div class="w-full border border-gray-200"> </div>

                                <div class="p-2 px-4 hover:cursor-pointer hover:bg-gray-100">
                                    <div class="flex w-full items-center gap-2 text-red-700"
                                        onclick=" document.getElementById('logout_form').submit();">
                                        <i class="fa fa-sign-out"></i>
                                        Logout
                                    </div>
                                    <form id="logout_form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                @endguest

            </div>
        </div>
    </div>

    {{-- Second Row End --}}
</header>
{{-- Third Row Start --}}

<div class="navbar bg-white shadow-lg hidden lg:flex justify-center">

    <div class="dropdown">
        <button class="group dropbtn menu-item1"> {{ $activeCategory->get(0)->name }}
            <i class="fa fa-caret-down ml-2 transform group-hover:rotate-180 transition-transform"></i>
            <div class="bottom-b"></div>
        </button>
        <div class="dropdown-content">

            <div class="row m-8 mt-4 ">

                <div class="w-full p-8 flex bg-white gap-8 z-9999 opacity-100">
                    @php
                        $subCategories = $activeCategory->get(0)->subCategories;
                        $randomSubCategories = $subCategories->shuffle()->take(6);
                        $cat_id = $activeCategory->get(0)->id;

                        use App\Models\CategoryHeaderImage;
                        $headerImageOne = CategoryHeaderImage::where('category_id', $activeCategory->get(0)->id)
                            ->where('sub_category', $subCategories[0]->id)
                            ->first();
                        $headerImageTwo = CategoryHeaderImage::where('category_id', $activeCategory->get(0)->id)
                            ->where('sub_category', $subCategories[1]->id)
                            ->first();
                        $headerImageThree = CategoryHeaderImage::where('category_id', $activeCategory->get(0)->id)
                            ->where('sub_category', $subCategories[2]->id)
                            ->first();
                        $headerImageFour = CategoryHeaderImage::where('category_id', $activeCategory->get(0)->id)
                            ->where('sub_category', $subCategories[3]->id)
                            ->first();
                    @endphp
                    <div class=" relative w-1/5   hover:cursor-pointer p-holder">
                        <a
                            href="/products?category={{ $activeCategory->get(0)->id }}&sub_category={{ $subCategories[0]->id }}">

                            <img src="{{ $headerImageOne
                                ? asset('user/uploads/category/header_image/' . $headerImageOne->title)
                                : asset('images/men_clothing.jpg') }}"
                                class="h-full w-full p-image" alt="mens product">
                            <div
                                class="absolute  top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text white z-10 w-[110%] bg-white py-4 text-center bg-opacity-80">
                                <div class="text-lg font-bold text-black">
                                    {{ $subCategories[0]->name }}
                                </div>
                                <div class="text-sm">
                                    @php
                                        $count_product = \App\Models\Product::where(
                                            'sub_category',
                                            $subCategories[0]->id,
                                        )->count();
                                    @endphp

                                    @if ($count_product == 1)
                                        1 product available
                                    @elseif ($count_product == 0)
                                        No product available
                                    @else
                                        {{ $count_product }} products available
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>


                    <div class=" relative w-1/5   hover:cursor-pointer p-holder">
                        <a
                            href="/products?category={{ $activeCategory->get(0)->id }}&sub_category={{ $subCategories[1]->id }}">
                            <img src="{{ $headerImageTwo
                                ? asset('user/uploads/category/header_image/' . $headerImageTwo->title)
                                : asset('images/men_clothing.jpg') }}"
                                class=" w-full p-image" alt="mens product">
                            <div
                                class="absolute  top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text white z-10 w-[110%] bg-white py-4 text-center bg-opacity-80">
                                <div class="text-lg font-bold text-black">
                                    {{ $subCategories[1]->name }}
                                </div>
                                <div class="text-sm">
                                    @php
                                        $count_product = \App\Models\Product::where(
                                            'sub_category',
                                            $subCategories[1]->id,
                                        )->count();

                                    @endphp

                                    @if ($count_product == 1)
                                        1 product available
                                    @elseif ($count_product == 0)
                                        No product available
                                    @else
                                        {{ $count_product }} products available
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class=" relative w-1/5  hover:cursor-pointer p-holder text-center">
                        <div cl[110%]"text-xl text-black font-bold pl-2 mb-6">
                            {{ $activeCategory->get(0)->name }}
                        </div>
                        @foreach ($randomSubCategories as $value)
                            <a
                                href="{{ url('/products') }}?category={{ $cat_id }}&sub_category={{ $value->id }}">
                                <div class="menu-item1 ">
                                    {{ $value->name }}
                                    <div class="bottom-b"></div>
                                </div>
                            </a>
                        @endforeach
                    </div>


                    <div class=" relative w-1/5  hover:cursor-pointer p-holder">
                        <a
                            href="/products?category={{ $activeCategory->get(0)->id }}&sub_category={{ $subCategories[2]->id }}">
                            <img src="{{ $headerImageThree
                                ? asset('user/uploads/category/header_image/' . $headerImageThree->title)
                                : asset('images/men_clothing.jpg') }}"
                                class=" w-full p-image " alt="mens product">
                            <div
                                class="absolute  top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text white z-10 w-[110%] bg-white py-4 text-center bg-opacity-80">
                                <div class="text-lg font-bold text-black">
                                    {{ $subCategories[2]->name }}
                                </div>
                                <div class="text-sm">
                                    @php
                                        $count_product = \App\Models\Product::where(
                                            'sub_category',
                                            $subCategories[2]->id,
                                        )->count();
                                    @endphp

                                    @if ($count_product == 1)
                                        1 product available
                                    @elseif ($count_product == 0)
                                        No product available
                                    @else
                                        {{ $count_product }} products available
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class=" relative w-1/5  hover:cursor-pointer p-holder">
                        <a
                            href="/products?category={{ $activeCategory->get(0)->id }}&sub_category={{ $subCategories[3]->id }}">

                            <img src="{{ $headerImageFour
                                ? asset('user/uploads/category/header_image/' . $headerImageFour->title)
                                : asset('images/men_clothing.jpg') }}"
                                class="h-full w-full p-image" alt="mens product">
                            <div
                                class="absolute  top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text white z-10 w-[110%] bg-white py-4 text-center bg-opacity-80">
                                <div class="text-lg font-bold text-black">
                                    {{ $subCategories[3]->name }}
                                </div>
                                <div class="text-sm">
                                    @php
                                        $count_product = \App\Models\Product::where(
                                            'sub_category',
                                            $subCategories[3]->id,
                                        )->count();
                                    @endphp

                                    @if ($count_product == 1)
                                        1 product available
                                    @elseif ($count_product == 0)
                                        No product available
                                    @else
                                        {{ $count_product }} products available
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="dropdown">
        <button class="dropbtn group menu-item1"> {{ $activeCategory->get(1)->name }}
            <i class="fa fa-caret-down ml-2 transform group-hover:rotate-180 transition-transform"></i>
            <div class="bottom-b"></div>
        </button>

        <div class="dropdown-content">

            <div class="row m-8 mt-4 ">

                <div class="w-full p-8 flex bg-white gap-8 z-9999 opacity-100">

                    <div class=" relative w-1/3 flex flex-col justify-between  hover:cursor-pointer p-holder">
                        <div>
                            <div class="text-xl font-bold text-black  pl-2 mb-6">
                                {{ $activeCategory->get(1)->name }}
                            </div>
                            @php
                                $secondSubCategories = $activeCategory->get(1)->subCategories;
                                $cat_id = $activeCategory->get(1)->id;
                                $randomSubCategories = $secondSubCategories->shuffle()->take(4);
                               
                                $TwoheaderImageOne = CategoryHeaderImage::where(
                                    'category_id',
                                    $activeCategory->get(1)->id,
                                )
                                    ->where('sub_category', $secondSubCategories[0]->id)
                                    ->first();
                                $TwoheaderImageTwo = CategoryHeaderImage::where(
                                    'category_id',
                                    $activeCategory->get(1)->id,
                                )
                                    ->where('sub_category', $secondSubCategories[1]->id)
                                    ->first();
                            @endphp
                            @foreach ($randomSubCategories as $value)
                                <a
                                    href="{{ url('/products') }}?category={{ $cat_id }}&sub_category={{ $value->id }}">
                                    <div class="menu-item1 ">
                                        {{ $value->name }}
                                        <div class="bottom-b"></div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <a href="mailto:info.bangabasi@gmail.com"
                            class="w-5/6 mx-auto py-4 border hover:bg-neutral-50 text-center"><i
                                class="fa fa-envelope px-4 text-lg "></i>Mail Us</a>
                    </div>
                    @if ($secondSubCategories->has(0))
                        <div class=" relative w-1/3 border h-[340px] shadow-lg hover:cursor-pointer p-holder ">
                            <img  src="{{ $TwoheaderImageOne
                            ? asset('user/uploads/category/header_image/' . $TwoheaderImageOne->title)
                            : asset('images/men_clothing.jpg') }}" class="h-full w-full p-image"
                                alt="mens product">
                            <div
                                class="absolute  top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text white z-10 w-[110%] bg-white py-4 text-center bg-opacity-80">
                                <div class="text-lg font-bold text-black">
                                    {{ $secondSubCategories[0]->name }}
                                </div>
                                <div class="text-sm ">
                                    <a href="{{ route('user.products', ['category' => $cat_id, 'sub_category' => $secondSubCategories[0]->id]) }}"
                                        class="text-orange-600"> Show More </a>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($secondSubCategories->has(1))
                        <div class=" relative w-1/3 border h-[340px] shadow-lg  hover:cursor-pointer p-holder">
                            <img src="{{ $TwoheaderImageTwo
                            ? asset('user/uploads/category/header_image/' . $TwoheaderImageTwo->title)
                            : asset('images/men_clothing.jpg') }}" class="h-full w-full p-image "
                                alt="mens product">
                            <div
                                class="absolute  top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text white z-10 w-[110%] bg-white py-4 text-center bg-opacity-80">
                                <div class="text-lg font-bold text-black">
                                    {{ $secondSubCategories[1]->name }}
                                </div>
                                <div class="text-sm">
                                    <a href="{{ route('user.products', ['category' => $cat_id, 'sub_category' => $secondSubCategories[1]->id]) }}"
                                        class="text-orange-600"> Show More </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>


    <div class="dropdown">
        <button class="dropbtn group menu-item1"> {{ $activeCategory->get(2)->name }}
            <i class="fa fa-caret-down ml-2 transform group-hover:rotate-180 transition-transform"></i>
            <div class="bottom-b"></div>
        </button>
        <div class="dropdown-content">
            @php
                $thirdSubCategories = $activeCategory->get(2)->subCategories;
                $category_id = $activeCategory->get(2)->id;
                $ThreeheaderImageOne = CategoryHeaderImage::where(
                                    'category_id',
                                    $activeCategory->get(2)->id,
                                )
                                    ->where('sub_category', $thirdSubCategories[0]->id)
                                    ->first();
                $ThreeheaderImageTwo = CategoryHeaderImage::where(
                                    'category_id',
                                    $activeCategory->get(2)->id,
                                )
                                    ->where('sub_category', $thirdSubCategories[1]->id)
                                    ->first();
                $ThreeheaderImageThree = CategoryHeaderImage::where(
                                    'category_id',
                                    $activeCategory->get(2)->id,
                                )
                                    ->where('sub_category', $thirdSubCategories[2]->id)
                                    ->first();
                $ThreeheaderImageFour = CategoryHeaderImage::where(
                                    'category_id',
                                    $activeCategory->get(2)->id,
                                )
                                    ->where('sub_category', $thirdSubCategories[3]->id)
                                    ->first();
                $ThreeheaderImageFive = CategoryHeaderImage::where(
                                    'category_id',
                                    $activeCategory->get(2)->id,
                                )
                                    ->where('sub_category', $thirdSubCategories[4]->id)
                                    ->first();
            @endphp
            <div class="row m-8 mt-4 ">

                <div class="w-full p-8 flex bg-white gap-8 z-9999 opacity-100">
                    @if ($thirdSubCategories->has(0))
                        <div class=" relative w-1/5 border  hover:cursor-pointer p-holder">
                            <img src="{{ $ThreeheaderImageOne
                            ? asset('user/uploads/category/header_image/' . $ThreeheaderImageOne->title)
                            : asset('images/men_clothing.jpg') }}"
                             class="h-full w-full p-image"
                                alt="mens product">
                            <a href="{{ route('user.products', ['category' => $category_id, 'sub_category' => $thirdSubCategories[0]->id]) }}"
                                class="absolute  top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text white z-10 w-[110%] bg-white py-4 text-center bg-opacity-80">
                                <div class="text-lg font-bold text-black">
                                    {{ $thirdSubCategories[0]->name }}
                                </div>

                                <div class="text-sm">
                                    @if ($thirdSubCategories[0]->products)
                                        {{ $thirdSubCategories[0]->products->count() }} products available
                                    @else
                                        No product available
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endif
                    @if ($thirdSubCategories->has(1))
                        <div class=" relative w-1/5 border hover:cursor-pointer p-holder">
                            <img src="{{ $ThreeheaderImageTwo
                            ? asset('user/uploads/category/header_image/' . $ThreeheaderImageTwo->title)
                            : asset('images/men_clothing.jpg') }}" class="h-full w-full p-image"
                                alt="mens product">
                            <a href="{{ route('user.products', ['category' => $category_id, 'sub_category' => $thirdSubCategories[1]->id]) }}"
                                class="absolute  top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text white z-10 w-[110%] bg-white py-4 text-center bg-opacity-80">
                                <div class="text-lg font-bold text-black">
                                    {{ $thirdSubCategories[1]->name }}
                                </div>

                                <div class="text-sm">
                                    @if ($thirdSubCategories[1]->products)
                                        {{ $thirdSubCategories[1]->products->count() }} products available
                                    @else
                                        No product available
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endif
                    @if ($thirdSubCategories->has(2))
                        <div class=" relative w-1/5 border hover:cursor-pointer p-holder">
                            <img src="{{ $ThreeheaderImageThree
                            ? asset('user/uploads/category/header_image/' . $ThreeheaderImageThree->title)
                            : asset('images/men_clothing.jpg') }}"  class="h-full w-full p-image"
                                alt="mens product">
                            <a href="{{ route('user.products', ['category' => $category_id, 'sub_category' => $thirdSubCategories[2]->id]) }}"
                                class="absolute  top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text white z-10 w-[110%] bg-white py-4 text-center bg-opacity-80">
                                <div class="text-lg font-bold text-black">
                                    {{ $thirdSubCategories[2]->name }}
                                </div>
                                <div class="text-sm">
                                    @if ($thirdSubCategories[2]->products)
                                        {{ $thirdSubCategories[2]->products->count() }} products available
                                    @else
                                        No product available
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endif
                    @if ($thirdSubCategories->has(0))
                        <div class=" relative w-1/5 border hover:cursor-pointer p-holder">
                            <img src="{{ $ThreeheaderImageFour
                            ? asset('user/uploads/category/header_image/' . $ThreeheaderImageFour->title)
                            : asset('images/men_clothing.jpg') }}"  class="h-full w-full p-image"
                                alt="mens product">
                            <a href="{{ route('user.products', ['category' => $category_id, 'sub_category' => $thirdSubCategories[3]->id]) }}"
                                class="absolute  top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text white z-10 w-[110%] bg-white py-4 text-center bg-opacity-80">
                                <div class="text-lg font-bold text-black">
                                    {{ $thirdSubCategories[3]->name }}
                                </div>
                                <div class="text-sm">
                                    @if ($thirdSubCategories[3]->products)
                                        {{ $thirdSubCategories[3]->products->count() }} products available
                                    @else
                                        No product available
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endif
                    @if ($thirdSubCategories->has(4))
                        <div class=" relative w-1/5 border hover:cursor-pointer p-holder">
                            <img src="{{ $ThreeheaderImageFive
                            ? asset('user/uploads/category/header_image/' . $ThreeheaderImageFive->title)
                            : asset('images/men_clothing.jpg') }}" class="h-full w-full p-image"
                                alt="mens product">
                            <a href="{{ route('user.products', ['category' => $category_id, 'sub_category' => $thirdSubCategories[4]->id]) }}"
                                class="absolute  top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text white z-10 w-[110%] bg-white py-4 text-center bg-opacity-80">
                                <div class="text-lg font-bold text-black">
                                    {{ $thirdSubCategories[4]->name }}
                                </div>
                                <div class="text-sm">
                                    @if ($thirdSubCategories[0]->products)
                                        {{ $thirdSubCategories[4]->products->count() }} products available
                                    @else
                                        No product available
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <div class="dropdown">
        <button class="dropbtn group menu-item1"> {{ $activeCategory->get(3)->name }}
            <i class="fa fa-caret-down ml-2 transform group-hover:rotate-180 transition-transform"></i>
            <div class="bottom-b"></div>
        </button>
        <div class="dropdown-content">
            <div class="row m-8 mt-4 ">

                <div class="w-full p-8 flex bg-white gap-8 z-9999 opacity-100">

                    <div class=" relative w-1/5  hover:cursor-pointer p-holder">
                        <div class="text-xl text-black font-bold pl-2 mb-6">
                            {{ $activeCategory->get(3)->name }}
                        </div>
                        @php
                            $subCategories = $activeCategory->get(3)->subCategories->take(6);
                            $cat_id = $activeCategory->get(3)->id;
                        @endphp
                        @foreach ($subCategories as $value)
                            <a
                                href="{{ url('/products') }}?category={{ $cat_id }}&sub_category={{ $value->id }}">
                                <div class="menu-item1 ">
                                    {{ $value->name }}
                                    <div class="bottom-b"></div>
                                </div>
                            </a>
                        @endforeach
                    </div>


                    <div class=" relative w-1/5  h-[340px]  hover:cursor-pointer p-holder ">
                        @php

                            $subCategories = $activeCategory->get(3)->subCategories->skip(6)->take(7);
                            $cat_id = $activeCategory->get(3)->id;
                        @endphp
                        @foreach ($subCategories as $value)
                            <a
                                href="{{ url('/products') }}?category={{ $cat_id }}&sub_category={{ $value->id }}">
                                <div class="menu-item1 ">
                                    {{ $value->name }}
                                    <div class="bottom-b"></div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class=" relative w-1/5  h-[340px]   hover:cursor-pointer p-holder">
                        @php
                            $subCategories = $activeCategory->get(3)->subCategories->skip(13)->take(7);
                            $cat_id = $activeCategory->get(3)->id;
                        @endphp
                        @foreach ($subCategories as $value)
                            <a
                                href="{{ url('/products') }}?category={{ $cat_id }}&sub_category={{ $value->id }}">
                                <div class="menu-item1 ">
                                    {{ $value->name }}
                                    <div class="bottom-b"></div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class=" relative w-1/5  h-[340px]   hover:cursor-pointer p-holder">
                        @php
                            $subCategories = $activeCategory->get(3)->subCategories->skip(20)->take(7);
                            $cat_id = $activeCategory->get(3)->id;
                        @endphp
                        @foreach ($subCategories as $value)
                            <a
                                href="{{ url('/products') }}?category={{ $cat_id }}&sub_category={{ $value->id }}">
                                <div class="menu-item1 ">
                                    {{ $value->name }}
                                    <div class="bottom-b"></div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                </div>

            </div>
        </div>
    </div>

    <a href="{{ route('products.sale') }}">
        <div class="leading-10 hover:border-b-2 hover:border-orange-600 cursor-pointer">
            <span class="uppercase text-sm p-1 bg-green-600 text-white">Sale</span>
        </div>
    </a>

    <div class="dropdown">
        <button class="dropbtn group menu-item1"> {{ $activeCategory->get(4)->name }}
            <i class="fa fa-caret-down ml-2 transform group-hover:rotate-180 transition-transform"></i>
            <div class="bottom-b"></div>
        </button>

        <div class="dropdown-content">
            @php
                $fourthSubCategories = $activeCategory->get(4)->subCategories;
                $fourth_category_id = $activeCategory->get(4)->id;

            @endphp
            <div class="row m-8 mt-4 ">

                <div class="w-full p-8 flex bg-white gap-8 z-9999 opacity-100">

                    <div class=" relative w-1/5 px-6 hover:cursor-pointer p-holder">
                        <div class="w-full py-4 h-full flex flex-col items-center justify-between">
                            <div class="w-full flex flex-col items-center justify-center py-3 gap-y-2">
                                <div>
                                    <img src="{{ asset('images/beauty_saloon.png') }}" class="w-4/6 mx-auto" />
                                </div>
                                <div class="text-center">
                                    {{ $fourthSubCategories[0]->name ?? '' }}
                                </div>
                            </div>

                            <div class="w-full flex flex-col items-center justify-center border-t border-b py-3 gap-y-2">
                                <div>
                                    <img src="{{ asset('images/badge.png') }}" class="w-4/6 mx-auto" />
                                </div>
                                <div class="text-center">
                                    {{ $fourthSubCategories[1]->name ?? '' }}
                                </div>
                            </div>

                            <div class="w-full flex flex-col items-center justify-center py-3 gap-y-2">
                                <div class="">
                                    <img src="{{ asset('images/surprise.png') }}" class="w-4/6 mx-auto" />
                                </div>
                                <div class="text-center">
                                    {{ $fourthSubCategories[2]->name ?? '' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=" relative w-1/3  hover:cursor-pointer p-holder">
                        <div class="h-full flex flex-col justify-evenly items-center ">
                            <a href="tel:+919476168391"
                                class="w-5/6 mx-auto py-2 border hover:bg-neutral-50 text-center"><i
                                    class="fa fa-phone px-4 text-lg"></i>Call Us</a href="tel:1234567890">
                            <div class="py-4">
                                <div class="text-xl text-black font-bold pl-2">
                                    {{ $activeCategory->get(4)->name }}
                                </div>
                                @php
                                    $subCategories = $activeCategory->get(4)->subCategories->take(3);
                                    $cat_id = $activeCategory->get(4)->id;
                                @endphp
                                @foreach ($subCategories as $value)
                                    <a
                                        href="{{ url('/products') }}?category={{ $cat_id }}&sub_category={{ $value->id }}">
                                        <div class="menu-item1 ">
                                            {{ $value->name }}
                                            <div class="bottom-b"></div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                            <a href="mailto:info.bangabasi@gmail.com"
                                class="w-5/6 mx-auto py-2 border hover:bg-neutral-50 text-center"><i
                                    class="fa fa-envelope px-4 text-lg"></i>Mail Us</a
                                href="mailto:info@starpactglobal.com">
                        </div>

                    </div>

                    <div class=" relative w-3/5 p-4 border  shadow-lg  hover:cursor-pointer p-holder">
                        <h3 class="text-xl font-bold text-black mb-2"> New Products </h3>
                        <x-combothree />
                    </div>

                </div>

            </div>
        </div>
    </div>


    <div class="dropdown">
        <button class="dropbtn group menu-item1"> {{ $activeCategory->get(5)->name }}
            <i class="fa fa-caret-down ml-2 transform group-hover:rotate-180 transition-transform"></i>
            <div class="bottom-b"></div>
        </button>
        <div class="dropdown-content">

            <div class="row m-8 mt-4 ">
                @php
                    $fifthSubCategories = $activeCategory->get(5)->subCategories->take(6);
                   
                    $cat_id = $activeCategory->get(3)->id;
                    if ($fifthSubCategories->has(0))
                    {
                        $FiveheaderImageOne = CategoryHeaderImage::where(
                                    'category_id',
                                    $activeCategory->get(5)->id,
                                )
                                    ->where('sub_category', $fifthSubCategories[0]->id)
                                    ->first();
                    }
                    if ($fifthSubCategories->has(1))
                    {
                        $FiveheaderImageTwo = CategoryHeaderImage::where(
                                    'category_id',
                                    $activeCategory->get(5)->id,
                                )
                                    ->where('sub_category', $fifthSubCategories[1]->id)
                                    ->first();
                    }
                    if ($fifthSubCategories->has(2))
                    {
                        $FiveheaderImageThree = CategoryHeaderImage::where(
                                    'category_id',
                                    $activeCategory->get(5)->id,
                                )
                                    ->where('sub_category', $fifthSubCategories[2]->id)
                                    ->first();
                    }
                    if ($fifthSubCategories->has(3))
                    {
                        $FiveheaderImageFour = CategoryHeaderImage::where(
                                    'category_id',
                                    $activeCategory->get(5)->id,
                                )
                                    ->where('sub_category', $fifthSubCategories[3]->id)
                                    ->first();
                    }
                    if ($fifthSubCategories->has(4))
                    {
                        $FiveheaderImageFive = CategoryHeaderImage::where(
                                    'category_id',
                                    $activeCategory->get(5)->id,
                                )
                                    ->where('sub_category', $fifthSubCategories[4]->id)
                                    ->first();
                    }
                    
                  
                @endphp
                <div class="w-full p-8 flex bg-white gap-8 z-9999 opacity-100">
                    <div class=" relative w-1/5   hover:cursor-pointer p-holder">
                        <img src="{{ $FiveheaderImageOne
                        ? asset('user/uploads/category/header_image/' . $FiveheaderImageOne->title)
                        : asset('images/men_clothing.jpg') }}" class=" w-full p-image"
                            alt="mens product">
                        <a href="{{ route('user.products', ['category' => $cat_id, 'sub_category' => $fifthSubCategories[0]->id]) }}"
                            class="absolute  top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text white z-10 w-[110%] bg-white py-4 text-center bg-opacity-80">
                            <div class="text-lg font-bold text-black">
                                {{ $fifthSubCategories[0]->name }}
                            </div>
                            <div class="text-sm">
                                @if ($fifthSubCategories[0]->products)
                                    {{ $fifthSubCategories[0]->products->count() }} products available
                                @else
                                    No product available
                                @endif

                            </div>
                        </a>
                    </div>
                    @if ($fifthSubCategories->has(1))
                        <div class=" relative w-1/5   hover:cursor-pointer p-holder">
                            <img src="{{ $FiveheaderImageTwo
                            ? asset('user/uploads/category/header_image/' . $FiveheaderImageTwo->title)
                            : asset('images/men_clothing.jpg') }}" class=" w-full p-image"
                                alt="mens product">
                            <a href="{{ route('user.products', ['category' => $cat_id, 'sub_category' => $fifthSubCategories[1]->id]) }}"
                                class="absolute  top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text white z-10 w-[110%] bg-white py-4 text-center bg-opacity-80">
                                <div class="text-lg font-bold text-black">
                                    {{ $fifthSubCategories[1]->name }}
                                </div>
                                <div class="text-sm">
                                    @if ($fifthSubCategories[1]->products)
                                        {{ $fifthSubCategories[1]->products->count() }} products available
                                    @else
                                        No product available
                                    @endif

                                </div>
                            </a>
                        </div>
                    @endif
                    @if ($fifthSubCategories->has(2))
                        <div class=" relative w-1/5   hover:cursor-pointer p-holder">
                            <img src="{{ $FiveheaderImageThree
                            ? asset('user/uploads/category/header_image/' . $FiveheaderImageThree->title)
                            : asset('images/men_clothing.jpg') }}" class="h-full w-full p-image"
                                alt="mens product">
                            <a href="{{ route('user.products', ['category' => $cat_id, 'sub_category' => $fifthSubCategories[2]->id]) }}"
                                class="absolute  top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text white z-10 w-[110%] bg-white py-4 text-center bg-opacity-80">
                                <div class="text-lg font-bold text-black">
                                    {{ $fifthSubCategories[2]->name }}
                                </div>
                                <div class="text-sm">
                                    @if ($fifthSubCategories[2]->products)
                                        {{ $fifthSubCategories[2]->products->count() }} products available
                                    @else
                                        No product available
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endif
                    @if ($fifthSubCategories->has(3))
                        <div class=" relative w-1/5   hover:cursor-pointer p-holder">
                            <img src="{{ $FiveheaderImageFour
                            ? asset('user/uploads/category/header_image/' . $FiveheaderImageFour->title)
                            : asset('images/men_clothing.jpg') }}" class="h-full w-full p-image"
                                alt="mens product">
                            <a href="{{ route('user.products', ['category' => $cat_id, 'sub_category' => $fifthSubCategories[3]->id]) }}"
                                class="absolute  top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text white z-10 w-[110%] bg-white py-4 text-center bg-opacity-80">
                                <div class="text-lg font-bold text-black">

                                    @if (isset($fifthSubCategories[3]))
                                        {{ $fifthSubCategories[3]->name }}
                                    @else
                                        <span>No subcategory found</span>
                                    @endif
                                </div>
                                <div class="text-sm">
                                    @if ($fifthSubCategories[3]->products)
                                        {{ $fifthSubCategories[3]->products->count() }} products available
                                    @else
                                        No product available
                                    @endif

                                </div>
                            </a>
                        </div>
                    @endif
                    @if ($fifthSubCategories->has(4))
                        <div class=" relative w-1/5 hover:cursor-pointer p-holder">
                            <img src="{{ $FiveheaderImageFive
                            ? asset('user/uploads/category/header_image/' . $FiveheaderImageFive->title)
                            : asset('images/men_clothing.jpg') }}" class="h-full w-full p-image"
                                alt="mens product">
                            <a href="{{ route('user.products', ['category' => $cat_id, 'sub_category' => $fifthSubCategories[4]->id]) }}"
                                class="absolute  top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text white z-10 w-[110%] bg-white py-4 text-center bg-opacity-80">
                                <div class="text-lg font-bold text-black">
                                    @if (isset($fifthSubCategories[4]))
                                        {{ $fifthSubCategories[4]->name }}
                                    @else
                                        <span>No subcategory found</span>
                                    @endif
                                </div>
                                <div class="text-sm">
                                    @if ($fifthSubCategories[4]->products)
                                        {{ $fifthSubCategories[4]->products->count() }} products available
                                    @else
                                        No product available
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <div class="dropdown">
        <button class="dropbtn group menu-item1"> {{ $activeCategory->get(6)->name }}
            <i class="fa fa-caret-down ml-2 transform group-hover:rotate-180 transition-transform"></i>
            <div class="bottom-b"></div>
        </button>
        <div class="dropdown-content">

            <div class="row m-8 mt-4 ">

                <div class="w-full p-8 flex bg-white gap-8 z-9999 opacity-100">
                    @php
                        $sixSubCategories = $activeCategory->get(6)->subCategories->take(5);
                        $cat_id = $activeCategory->get(6)->id;
                        if ($sixSubCategories->has(0))
                    {
                        $SixheaderImageOne = CategoryHeaderImage::where(
                                    'category_id',
                                    $activeCategory->get(6)->id,
                                )
                                    ->where('sub_category', $sixSubCategories[0]->id)
                                    ->first();
                    }
                        if ($sixSubCategories->has(1))
                    {
                        $SixheaderImageTwo= CategoryHeaderImage::where(
                                    'category_id',
                                    $activeCategory->get(6)->id,
                                )
                                    ->where('sub_category', $sixSubCategories[1]->id)
                                    ->first();
                    }
                    @endphp

                    <div class="relative w-1/3 border h-[340px] shadow-lg hover:cursor-pointer p-holder">
                        <img src="{{ $SixheaderImageOne
                        ? asset('user/uploads/category/header_image/' . $SixheaderImageOne->title)
                        : asset('images/men_clothing.jpg') }}" class="h-full w-full p-image"
                            alt="mens product">
                        <a href="{{ url('/products') }}?category={{ $cat_id }}&sub_category={{ $sixSubCategories[0]->id }}"
                            class="absolute block top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-10 w-[110%] bg-white py-4 text-center bg-opacity-80 border ">
                            <div class="text-lg font-bold text-black">
                                {{ $sixSubCategories[0]->name }}
                            </div>
                            <div class="text-sm">
                                <span class="text-orange-600"> Show More </span>
                            </div>
                        </a>
                    </div>


                    <div class=" relative w-1/3 border h-[340px] shadow-lg  hover:cursor-pointer p-holder">
                        <img src="{{ $SixheaderImageTwo
                        ? asset('user/uploads/category/header_image/' . $SixheaderImageTwo->title)
                        : asset('images/men_clothing.jpg') }}" class="h-full w-full p-image "
                            alt="mens product">
                        <a href="{{ url('/products') }}?category={{ $cat_id }}&sub_category={{ $sixSubCategories[1]->id }}"
                            class="absolute block top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text white z-10 w-full bg-white py-4 text-center bg-opacity-80">
                            <div class="text-lg font-bold text-black">
                                {{ $sixSubCategories[1]->name }}
                            </div>
                            <div class="text-sm">
                                <span class="text-orange-600"> Show More </span>
                            </div>
                        </a>
                    </div>
                    <div class=" relative w-1/3 flex flex-col justify-between  hover:cursor-pointer p-holder">
                        <div>
                            <div class="text-xl font-bold text-black  pl-2 mb-6">
                                {{ $activeCategory->get(6)->name }}
                            </div>

                            @foreach ($sixSubCategories as $value)
                                <a
                                    href="{{ url('/products') }}?category={{ $cat_id }}&sub_category={{ $value->id }}">
                                    <div class="menu-item1 ">
                                        {{ $value->name }}
                                        <div class="bottom-b"></div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <a href="mailto:info.bangabasi@gmail.com" class="w-5/6 mx-auto py-4 border hover:bg-neutral-50 text-center"><i class="fa fa-envelope px-4 text-lg"></i>Mail Us</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Third Row End --}}

@push('scripts')
    <script>
        function handleKeyPress(event) {
            if (event.key === 'Enter') {
                searchProducts();
            }
        }

        function searchProducts() {
            const query = document.getElementById('search_bar').value;
            console.log("Searching for:", query);
            // Add your search logic here...
        }
    </script>

    <script>
        $("#search_bar").focus(function() {
            $("#search_result").show();
        })

        $("#search_bar").blur(function() {
            $("#search_result").hide();
        })
    </script>

    <script>
        $(document).ready(function() {

            const placeholders = [
                " 🔥 Puja Thali",
                " 👦 Kids Corner",
                " 👚 Women",
                " 👕 Men"
            ];

            let currentIndex = 0;
            const inputField = $("#search_bar");

            function changePlaceholder() {

                // check if the input field is not focused and its not empty
                if (!inputField.is(":focus") && inputField.val().length == 0) {
                    // Fade out the placeholder
                    inputField.fadeOut(500, function() {
                        // Update the placeholder text
                        inputField.attr("placeholder", placeholders[currentIndex]);

                        // Fade in the new placeholder
                        inputField.fadeIn(500);

                        // Increment index or reset to 0 if at the end of the array
                        currentIndex = (currentIndex + 1) % placeholders.length;
                    });
                }

            }

            // Initial placeholder
            changePlaceholder();

            // Change placeholder every 4 seconds (including fade duration)
            setInterval(changePlaceholder, 2000);
        });
    </script>

    <script>
        $(document).ready(function() {
            $(".third-menu-item").hover(function() {
                const id = $(this).attr("id");
                const selector = `#third-menu-item-${id}`;

                $(selector).show();
            });


        });
    </script>
@endpush
