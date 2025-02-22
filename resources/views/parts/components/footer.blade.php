<div class="w-full bg-gradient-to-r from-orange-500 to-orange-400 py-4 px-12 mt-12">

    <div class="w-full flex justify-between items-center">
        <div class="flex gap-8 text-2xl">
            <a href=""><i class="fa-brands fa-facebook-f"></i></a>
            <a href=""><i class="fa-brands fa-whatsapp"></i></a>
            <a href=""><i class="fa-brands fa-instagram"></i></a>
            <a href=""><i class="fa-brands fa-pinterest-p"></i></a>
            <a href=""><i class="fa-brands fa-youtube"></i></a>
            <a href=""><i class="fa-solid fa-map-marker-alt"></i></a>
        </div>

        <div class="flex gap-4 justify-end items-center">
            <div class="text-white text-2xl font-200">
                Get the latest <b> deals </b> and more
            </div>

            <div class=" flex ">
                <input title="Enter your email address to subscribe to our newsletter" type="text"
                    placeholder="Enter your email address" class="py-2 px-4 outline-none">
                <button title="Subscribe" class="bg-gray-200 text-orange-500 px-4 py-2">
                    <i class="fa-solid fa-bell"></i>
                </button>
            </div>
        </div>
    </div>

</div>

<div class="w-full flex justify-between px-12 py-12 color-white bg-black ">

    <div class="w-1/6 text-white">
        <div class="text-lg font-bold">
            Information
        </div>

        <div class="text-sm mt-6">
            <div class="menu-item1">
                About Us
                <div class="bottom-b"></div>
            </div>

            <div class="menu-item1">
                Delivery Information
                <div class="bottom-b"></div>
            </div>

            <div class="menu-item1">
                Privacy Ploicy
                <div class="bottom-b"></div>
            </div>

            <div class="menu-item1">
                Terms & Conditions
                <div class="bottom-b"></div>
            </div>


        </div>
    </div>

    <div class="w-1/6 text-white">
        <div class="text-lg font-bold">
            Customer Services
        </div>

        <div class="text-sm mt-6">
            <div class="menu-item1">
                Contact Us
                <div class="bottom-b"></div>
            </div>

            <div class="menu-item1">
                Return Policy
                <div class="bottom-b"></div>
            </div>

            <div class="menu-item1">
                Site Map
                <div class="bottom-b"></div>
            </div>

            <div class="menu-item1">
                Affiliate Program
                <div class="bottom-b"></div>
            </div>

        </div>
    </div>

    <div class="w-1/6 text-white">
        <div class="text-lg font-bold">
            My Account
        </div>

        <div class="text-sm mt-6">

            <div class="menu-item1">
                My Account
                <div class="bottom-b"></div>
            </div>

            <div class="menu-item1">
                Order History
                <div class="bottom-b"></div>
            </div>

            <div class="menu-item1">
                Wish List
                <div class="bottom-b"></div>
            </div>

            <div class="menu-item1">
                News Letter
                <div class="bottom-b"></div>
            </div>

        </div>
    </div>


    <div class="w-1/6 text-white">
        <div class="text-lg font-bold">
            Categories
        </div>

        <div class="text-sm mt-6">
            @foreach ($activeCategories->take(4) as $category)
                <div class="menu-item1">
                    {{ $category->name }}
                    <div class="bottom-b"></div>
                </div>
            @endforeach
        </div>
    </div>
    
</div>


<div class=" w-full bg-orange-600 flex justify-between items-center py-2 px-12  ">
    <div class="flex items-center gap-4">
        @if(isset($logos['2']))
            <img src="{{ asset('user/uploads/logos/' . $logos['1']->image_path) }}" class="w-48">
        @endif
        <img src="{{ asset('images/svg/msme_icon_circle.png') }}" class="w-8">
    </div>

    <div>
        <p class="text-gray-100">GSTIN0123456789</p>
    </div>

    <div class="flex items-center gap-4">
        <div>
            <div class="text-neutral-100">
                Need Help ? Call Us : <a href="tel:+91 123 456 7890" class="font-bold"> +91 9476 168 391 </a>
            </div>
            <div class=" mt-2 text-gray-100">
                
            </div>
        </div>
    </div>

    <div class="flex items-center gap-4">
        <img src="{{ asset('images/svg/visa.png') }}" class="w-8">
        <img src="{{ asset('images/svg/master-card.png') }}" class="w-8">
        <img src="{{ asset('images/svg/paypal.png') }}" class="w-8">
        <img src="{{ asset('images/svg/american-express.png') }}" class="w-8">
    </div>
</div>

<div class="w-full py-3 px-12 text-sm text-center text-gray-100 bg-gradient-to-r from-gray-600 to-gray-800">

    &copy; 2024 Bangobashi. All Rights Reserved. Build by <a href="https://starpactglobal.com/"> Starpact Global Services </a>

</div>


@push('scripts')
    {{-- <script>
    $( function() {
      $( document ).tooltip();
    } );
    </script>
    <style>
    label {
      display: inline-block;
      width: 5em;
    }
    </style> --}}
@endpush