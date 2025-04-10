@extends('layouts.master')
@section('head')
    <title>Bangabasi | Shopping Cart</title>
@endsection
@section('content')
    @php
        $xpage = 'Cart';
        $xprv = 'home';
        use Carbon\Carbon;
        $currentTime = Carbon::now();
        if($products->isNotEmpty()){
            $cartAdded = $products[0]->updated_at;
            $diffInSeconds = $cartAdded->diffInSeconds($currentTime);
        }
    @endphp
    <x-bread-crumb :page="$xpage" :previousHref="$xprv" />
    <div class="flex flex-wrap justify-center gap-4 p-8 bg-slate-50 my-4">
        <div class="min-w-48 lg:min-w-80 text-center py-4">
            <a class="uppercase text-lg md:text-2xl font-normal hover:text-gray-600"><span class="inline-block bg-black text-white rounded-full w-8 mx-4">1</span>Shopping Cart</a>
        </div>
        <div class="min-w-48 lg:min-w-80 text-center py-4 ">
            <a class="uppercase text-lg md:text-2xl font-normal text-gray-500 hover:text-gray-600"><span class="inline-block border rounded-full w-8 mx-4">2</span>Checkout</a>
        </div>
        <div class="min-w-48 lg:min-w-80 text-center py-4 ">
            <a class="uppercase text-lg md:text-2xl font-normal text-gray-500 hover:text-gray-600"><span class="inline-block border rounded-full w-8 mx-4">3</span>Order Status</a>
        </div>
    </div>
    
    <div class="container grid grid-cols-12 gap-8 my-8">
    
        <div class="hidden lg:block lg:col-span-8">

            @if (count($products) == 0)
                <h1 class="text-3xl font-bold text-center text-gray-500">Your cart is empty!</h1>
            @else
                <table class="w-full bg-white border-b">
                    <thead class="border-b ">
                        <tr class="">
                            <th class="px-4 py-2 text-left">Thumbnail</th>
                            <th class="px-4 py-2 text-left">Product Name</th>
                            <th class="px-4 py-2 text-center">Price</th>
                            <th class="px-4 py-2 text-center">Size</th>
                            <th class="px-4 py-2 text-center">Quantity</th>
                            <th class="px-4 py-2 text-center">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                      
                        @foreach ($products as $product)

                            <tr class=" hover:shadow-sm ">
                                <td class="px-4 py-2 text-center max-w-0">
                                    @php
                                        $pro = App\Models\Product::where('id', $product->product_id)->first();
                                    @endphp
                                    @if ($pro->productImages->isNotEmpty())
                                        <img alt="Thumbnail" class="thumbnail-img mx-auto w-20 h-20" src="{{ asset('user/uploads/products/images/' . $pro->productImages->first()->image) }}">
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-left font-medium"> {{ $product->name }}
                                    <button onclick="document.getElementById('delete-form-{{ $product->cart_id }}').submit()" type="button" class="mx-4 text-red-500">Remove</button>
                                    <form id="delete-form-{{ $product->cart_id }}"
                                        action="{{ route('cart.delete', $product->cart_id) }}" method="POST">
                                        @csrf
                                    </form>
                                </td>
                                <td class="px-4 py-2 text-center text-neutral-500"> ₹{{ $product->unit_price }} </td>
                                <td class="px-4 py-2 text-center text-neutral-700"> {{ $product->sku }} </td>
                                <td class="px-4 py-2 text-center ">
                                    <div class="flex gap-x-1">
                                        <button class="downCount w-fit border p-1" data-cart-id="{{ $product->cart_id }}" data-unit-price="{{ $product->unit_price }}" data-product-id="{{ $product->product_id }}" data-sku="{{ $product->sku }}">-</button>
                                        <div class="w-1/4 text-center p-1" id="quantity_{{ $product->cart_id }}"> {{ $product->quantity }} </div>
                                        <button class="upCount w-fit  border p-1" data-cart-id="{{ $product->cart_id }}" data-unit-price="{{ $product->unit_price }}" data-product-id="{{ $product->product_id }}" data-sku="{{ $product->sku }}">+</button>
                                    </div>
                                </td>
                                <td class="px-4 py-2 text-center text-neutral-500">₹ <span id="subtotal_{{ $product->cart_id }}">{{ round($product->unit_price * $product->quantity) }}</span> </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            @endif
        </div>
        <div class="col-span-12 lg:hidden">
            @if (count($products) == 0)
                <h1 class="text-2xl font-bold text-center text-gray-500">Your cart is empty!</h1>
            @else
                <div class="space-y-4">
                    @foreach ($products as $product)
                        @php
                            $pro = App\Models\Product::where('id', $product->product_id)->first();
                        @endphp
                        <div class="bg-white p-4 rounded-lg shadow-md">
                            <div class="flex items-center gap-4">
                                @if ($pro->productImages->isNotEmpty())
                                    <img alt="Thumbnail" class="w-20 h-20 object-cover" src="{{ asset('user/uploads/products/images/' . $pro->productImages->first()->image) }}">
                                @endif
                                <div class="flex-1">
                                    <h2 class="text-lg font-semibold">{{ $product->name }}</h2>
                                    <p class="text-gray-600">Size: {{ $product->sku }}</p>
                                    <p class="text-gray-500">₹{{ $product->unit_price }}</p>
                                    <div class="flex items-center mt-2 gap-x-2">
                                        <button class="downCount border px-2 py-1" data-cart-id="{{ $product->cart_id }}" data-unit-price="{{ $product->unit_price }}" data-product-id="{{ $product->product_id }}" data-sku="{{ $product->sku }}">-</button>
                                        <span id="quantity_{{ $product->cart_id }}" class="px-3">{{ $product->quantity }}</span>
                                        <button class="upCount border px-2 py-1" data-cart-id="{{ $product->cart_id }}" data-unit-price="{{ $product->unit_price }}" data-product-id="{{ $product->product_id }}" data-sku="{{ $product->sku }}">+</button>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between mt-4">
                                <p class="text-gray-700 font-medium">Subtotal: ₹<span id="subtotal_{{ $product->cart_id }}">{{ round($product->unit_price * $product->quantity) }}</span></p>
                                <button onclick="document.getElementById('delete-form-{{ $product->cart_id }}').submit()" class="text-red-500">Remove</button>
                            </div>
                            <form id="delete-form-{{ $product->cart_id }}" action="{{ route('cart.delete', $product->cart_id) }}" method="POST">
                                @csrf
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="col-span-12 lg:col-span-4 border-2 border-black p-2 md:p-6">
            <h3 class="text-lg font-medium border-b py-2 uppercase">Cart Totals</h3>
            <table class="w-full">
                <tbody>
                    <tr class="flex justify-between items-center border-b py-2">
                        <td class="flex-1 text-left text-neutral-500">Subtotal</td>
                        <td id="sub_total" class="flex-1 text-right text-neutral-500 show"> ₹ {{ $total_price }} </td>
                        <td id="sub_total_loading" class="loading hidden">
                            <img src="/images/loader/loader.gif" alt="" class="w-6">
                        </td>
                    </tr>
                    <tr class="flex justify-between items-center border-b py-2">
                        <td class="flex-1 text-left text-lg">Total</td>
                        <td id="total" class="flex-1 text-right text-lg show"> ₹ {{ $total_price }} </td>
                        <td id="total_loading" class="loading hidden">
                            <img src="/images/loader/loader.gif" alt="" class="w-6">
                        </td>
                    </tr>
                </tbody>
            </table>
            @if ($products->count() == 0)
                <button class="w-full bg-gray-400 text-slate-50 py-2 my-4 hover:cursor-not-allowed  " disabled> Proceed To Checkout </button>
            @else
                <a href="{{ route('checkout') }}" class="">
                    <button class="w-full bg-orange-700 text-slate-50 py-2 my-4 hover:bg-orange-600  "> Proceed To Checkout </button>
                </a>
                <p id="timer-message"></p>
            @endif
            <a href="{{ route('home') }}"> <button class="w-full border-2 border-black py-2 my-4 hover:bg-gray-800 text-gray-900 hover:text-slate-100">Continue Shopping</button></a>
        </div>
        <div class="col-span-12 lg:col-span-8">
            <div class="flex justify-between py-4 flex-wrap gap-4">
                <div class=" w-fit leading-10">
                    <div id="couponCont">
                        <h6 class="">Have you a coupon? <span class="underline text-gray-700" onClick="toggleForm('coupon')">Click  here to enter</span></h6>
                        <form class="py-4 space-y-4 hidden" id="couponForm" action="{{ route('checkout.coupon') }}" method="POST">
                            @csrf
                            <input type="text" name="coupon_code" class="w-72 md:w-96 px-4 leading-10 border focus:outline-none focus:border-black" placeholder="Coupon Code" required>
                            <input type="submit" value="Apply" class="sm:mx-2 leading-10 bg-gray-400 hover:bg-orange-600 hover:text-slate-50 px-6">
                        </form>
                    </div>
                    <div id="couponReset" class="hidden">
                        <form action="{{ route('reset.coupon') }}" method="POST" class="py-4 space-y-4">
                            @csrf
                            <input type="submit" value="Reset Coupon" class="leading-10 bg-gray-400 hover:bg-orange-600 hover:text-slate-50 px-6">
                        </form>
                    </div>
                </div>
                <button onclick="toggleModal()" class="border-2 border-black px-4 leading-10 hover:bg-gray-800 hover:text-gray-100"><span class="text-red-500 mr-2">⮿</span>Clear Shopping Cart</button>
            </div>
        </div>
        <div class="col-span-12 lg:col-span-4">
            <h4 class="text-center text-xl text-gray-900 font-noraml ">Payment Security</h4>
            <p class="text-gray-700 text-center my-2">Encryption ensures increased transaction security. SSL technology
                protects data linked to personal and payment info.</p>
            <ul class="flex justify-center py-4 gap-4">
                <li class="flex-1 max-w-12">
                    <img src="/images/icons/visa.svg" alt="">
                </li>
                <li class="flex-1 max-w-12">
                    <img src="/images/icons/american_express.svg" alt="">
                </li>
                <li class="flex-1 max-w-12">
                    <img src="/images/icons/master_card.svg" alt="">
                </li>
                <li class="flex-1 max-w-12">
                    <img src="/images/icons/paypal.svg" alt="">
                </li>
            </ul>
        </div>
    </div>

    @if (isset($interestedProducts) && $interestedProducts->isNotEmpty())
        <div class="container py-8">
            <h2 class="text-2xl font-semibold text-gray-900 my-2">You may be interested in…</h2>
            <div class="swiper9 may-interest overflow-hidden">
                <div class="swiper-wrapper">

                    @foreach ($interestedProducts as $product)
                        @php
                            // Calculate average rating using Laravel's avg method or fallback to 0 if no reviews
                            $ratings = $product->reviews->avg('rating') ?: 0;
                            // Get the first product image or set default
                            $image = $product->productImages->first()->image ?? null;
                        @endphp

                        <div class="swiper-slide">
                            <x-product-card :image="$image" :category="$product->categoryDetails->name" :title="$product['name']" :rating="$ratings"
                                :originalPrice="$product['original_price']" :discountedPrice="$product['offer_price']" :id="$product->id" :inStock="$product->in_stock" :discountThreshold="$discountThreshold" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif


    <div id="modal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden z-10">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md mx-auto">
            <h2 class="text-xl font-bold mb-4">Are you sure?</h2>
            <p class="mb-6">Do you really want to empty the cart? This action cannot be undone.</p>
            <div class="flex justify-end space-x-4">
                <button class="bg-gray-200 text-gray-700 py-2 px-4 rounded" onclick="toggleModal()">Cancel</button>
                <button onclick="$('#empty-cart-form').submit()" class="bg-red-500 text-white py-2 px-4 rounded">Empty
                    Cart</button>
                <form id="empty-cart-form" action= " {{ route('cart.empty-cart') }} " method="POST">
                    @csrf
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script id="toggleForm">
    function toggleForm(id){
        const form = document.getElementById(`${id}Form`);
        if(form){
            form.classList.toggle('hidden');
        }
    }
</script>

<script id="couponSubmit">
    const couponCont = document.getElementById('couponCont');
    const couponForm = document.getElementById('couponForm');
    const couponInput = couponForm.querySelector('[name="coupon_code"]');
    const couponReset = document.getElementById('couponReset');

    couponForm.addEventListener('submit', function(e) {

        e.preventDefault();
        const couponCode = couponInput.value;
        if (!couponCode) {
            return;
        }

        // Prepare the data to be sent with the request
        const formData = new FormData();
        formData.append('coupon_code', couponCode);

        // Use fetch to send the data
        fetch(couponForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json',
                // Include CSRF token if needed
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            // Handle the response data here (e.g., display a success message)
            if (data.success && couponCont) {
                // Clear previous messages
                couponCont.innerHTML = '';

                // Create a new element to display the success message
                const successMessage = document.createElement('p');
                successMessage.classList.add('text-green-500');
                successMessage.textContent = `${data.message} Refresh the page if you want to proceed with this coupon.`; // Coupon applied successfully

                // Append the success message to couponCont
                couponCont.appendChild(successMessage);
                couponReset.classList.remove('hidden');
                // Check if discount_amount or discount_percentage is available and display accordingly
                if (data.discount_amount) {
                    const discountAmount = document.createElement('p');
                    discountAmount.classList.add('text-green800');
                    discountAmount.textContent = `You will get ₹ ${data.discount_amount} discount on the final amount.`; // Displaying amount with ₹
                    couponCont.appendChild(discountAmount);
                } else if (data.discount_percentage) {
                    const discountPercentage = document.createElement('p');
                    discountPercentage.classList.add('text-green-800');
                    discountPercentage.textContent = `You will get ${data.discount_percentage}% discount on the total of offer price.`; // Displaying percentage
                    couponCont.appendChild(discountPercentage);
                }
            } else {
                // Optionally display an error message if the coupon is invalid
                couponCont.innerHTML = `<p class="text-red-500">${data.message}</p>`;
            }
        })
        .catch(error => {
            // Handle any errors during the fetch request
            console.error('Error applying coupon:', error);
            couponCont.innerHTML = `<p class="text-red-500">An error occurred while applying the coupon. Please try again.</p>`;
        });
    });
</script>
    
    @if($products->isNotEmpty())
        <script id="countDown">
            let diffInSeconds = {{ $diffInSeconds }};

            // Element to display the countdown or message
            const countdownElement = document.getElementById('timer-message');

            // If the time difference is within 5 minutes (300 seconds)
            if (diffInSeconds <= 900) {
                // Timer countdown logic
                let countdown = setInterval(() => {
                    // Calculate remaining time
                    let remainingTime = 900 - diffInSeconds;

                    // If time is up
                    if (remainingTime <= 0) {
                        countdownElement.innerHTML = "You are out of time! Checkout now to avoid losing your order!";
                        clearInterval(countdown); // Stop the countdown
                    } else {
                        // Calculate minutes and seconds
                        const minutes = Math.floor(remainingTime / 60);
                        let seconds = remainingTime % 60;

                        // Format minutes and seconds to always show two digits
                        const formattedMinutes = minutes < 10 ? `0${minutes}` : minutes;
                        const formattedSeconds = seconds < 10 ? `0${Math.round(seconds)}` : Math.round(seconds);
                        // Update the countdown element with formatted time (MM:SS)
                        countdownElement.innerHTML = ` Hurry up, these products are limited, checkout within ${formattedMinutes}:${formattedSeconds}`;
                    }

                    // Decrease the remaining time every second
                    diffInSeconds++;
                }, 1000); // Update every second
            } else {
                // If the time has passed 5 minutes, show the message directly
                countdownElement.innerHTML = "You are out of time! Checkout now to avoid losing your order!";
            }


        </script>
    @endif

    <script>
        var debounce = null;

        function updateQuantity(cartId, unitPrice, newQuantity, callback) {
            // Update the quantity and subtotal on the UI
            $('#quantity_' + cartId).text(newQuantity);
            $('#subtotal_' + cartId).text((unitPrice * newQuantity).toFixed(2));

            // AJAX call to update the cart on the server
            clearTimeout(debounce);

            debounce = setTimeout(function() {
                $(".show").hide();
                $(".loading").show();
                $.ajax({
                    type: "POST",
                    url: "/cart/update",
                    data: {
                        _token: "{{ csrf_token() }}",
                        cart_id: cartId,
                        quantity: newQuantity
                    },
                    success: function(response) {
                        console.log(response.total_price);
                        $("#sub_total").text("₹" + response.total_price);
                        $("#total").text("₹" + response.total_price);
                        $(".show").show();
                        $(".loading").hide();
                        if (callback) callback();
                    },
                    error: function(error) {
                        console.log(error);
                        $(".show").show();
                        $(".loading").hide();
                    }
                });
            }, 600);
        }

        document.querySelectorAll('.upCount, .downCount').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const cartId = this.getAttribute('data-cart-id');
                const unitPrice = parseFloat(this.getAttribute('data-unit-price'));
                let quantityElement = document.getElementById(`quantity_${cartId}`);
                let currentQuantity = parseInt(quantityElement.innerText);
                let newQuantity = currentQuantity;

                if (this.classList.contains('upCount')) {
                    newQuantity++; // Increase quantity
                } else if (this.classList.contains('downCount') && currentQuantity > 1) {
                    newQuantity--; // Decrease quantity, but prevent going below 1
                }

                const productId = this.getAttribute('data-product-id'); // Dynamically get product ID
                const sku = this.getAttribute('data-sku');

                // AJAX call to check available stock for the selected product and size (sku)
                fetch('{{ route('cart.checkStock') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            sku: sku
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.available_quantity && newQuantity <= data.available_quantity) {
                            // Proceed with updating the quantity and subtotal
                            updateQuantity(cartId, unitPrice, newQuantity);
                        } else {
                            // Show an error if the quantity exceeds available stock
                            Swal.fire({
                                icon: 'error',
                                title: 'Quantity Exceeded',
                                text: `The available stock for this product is ${data.available_quantity}. Please adjust your quantity.`,
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error checking stock:', error);
                    });
            });
        });
    </script>

    <script>
        function toggleModal() {
            const modal = document.getElementById('modal');
            modal.classList.toggle('hidden');
        }
    </script>
@endpush
