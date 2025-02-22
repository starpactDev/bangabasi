<div class="col-span-12 md:col-span-3 p-4 ">
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
    <input type="text" name="" id=""
        class="w-full leading-8 border px-4 focus:outline-none focus:border-black"
        placeholder="Find a category">
    <div class="h-80 overflow-y-auto py-4 my-4">   

        @foreach ($filterSubCategories as $category)
            <div class="my-1">
                <input type="checkbox" name="sub_categories[]" id="subcategory-{{ $category->id }}" value="{{ $category->id }}">
                <label for="subcategory-{{ $category->id }}" class="mx-4 text-gray-600 capitalize">
                    {{ $category->name }}
                </label>
            </div>
        @endforeach


    </div>
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
        <input type="number" name="" id="" class="w-1/4 border px-2 leading-8 "
            placeholder="min">
        <input type="number" name="" id="" class="w-1/4 border px-2 leading-8 mx-4"
            placeholder="max">
        <input type="submit" value="Apply"
            class="w-4/12 text-white cursor-pointer bg-red-200 hover:bg-red-500 leading-8">
    </div>
    <h3 class="text-gray-700 text-sm font-semibold uppercase my-4 py-4 border-b-2">Product Status</h3>
    <div class="my-2">
        <input type="checkbox" name="inStock" id="inStock">
        <label for="inStock" class="mx-4 text-gray-600 capitalize">in Stock</label>
    </div>
    <div class="my-2">
        <input type="checkbox" name="outStock" id="outStock">
        <label for="outStock" class="mx-4 text-gray-600 capitalize">Out of Stock</label>
    </div>
    <div class="my-2">
        <input type="checkbox" name="onSale" id="onSale">
        <label for="onSale" class="mx-4 text-gray-600 capitalize">On Sale</label>
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