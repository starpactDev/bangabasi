@extends('layouts.master')
@section('head')
    <title>Bangabasi | Order Checkout</title>
@endsection
@section('content')
    @php
        $xpage = 'Check Out';
        $xprv = 'home';
        use Carbon\Carbon;
        $currentTime = Carbon::now();
        if($products->count() > 0){
            $cartAdded = $products[0]->updated_at;
            $diffInSeconds = $cartAdded->diffInSeconds($currentTime);
        }
    @endphp

    <x-bread-crumb :page="$xpage" :previousHref="$xprv" />
    <div class="flex flex-wrap justify-center gap-x-4 p-8 bg-slate-50 my-4">
        <div class="min-w-64 lg:min-w-80 text-center py-4">
            <a class="uppercase text-lg md:text-2xl text-gray-500 font-normal hover:text-gray-600"><span class="inline-block border rounded-full w-8 mx-4">1</span>Shopping Cart</a>
        </div>
        <div class="min-w-64 lg:min-w-80 text-center py-4 ">
            <a class="uppercase text-lg md:text-2xl font-normal hover:text-gray-600"><span class="inline-block bg-black text-white rounded-full w-8 mx-4">2</span>Checkout</a>
        </div>
        <div class="min-w-64 lg:min-w-80 text-center py-4 ">
            <a class="uppercase text-lg md:text-2xl font-normal text-gray-500 hover:text-gray-600"><span class="inline-block border rounded-full w-8 mx-4">3</span>Order Status</a>
        </div>
    </div>

    <div class="container flex justify-between gap-4 border-l-4 border-green-700 bg-green-600 text-white my-4 md:my-8 py-2 px-2 md:px-6">
        <p id="timer-message"></p>
        <a href="{{ route('cart') }}" class="min-w-fit underline hover:text-gray-100">Back to Cart</a>
    </div>

    <div class="container" >
        <div id="couponCont">
            <h6 class="">Have you a coupon? <span class="underline text-gray-700" onClick="toggleForm('coupon')">Click  here to enter</span></h6>
            <form class="py-4 space-y-4 hidden" id="couponForm" action="{{ route('checkout.coupon') }}" method="POST">
                @csrf
                <input type="text" name="coupon_code" class="w-72 md:w-96 px-4 leading-10 border focus:outline-none focus:border-black" placeholder="Coupon Code" required>
                <input type="submit" value="Apply" class="sm:mx-2 leading-10 bg-gray-400 hover:bg-orange-600 hover:text-slate-50 px-6">
            </form>
            <p class="text-red-500" id="coupan_alert"></p>

        </div>
        <div id="couponReset" class="hidden">
            <form action="{{ route('reset.coupon') }}" method="POST" class="py-4 space-y-4">
                @csrf
                <input type="submit" value="Reset Coupon" class="leading-10 bg-gray-400 hover:bg-orange-600 hover:text-slate-50 px-6">
            </form>
        </div>
    </div>

    <div class="container grid grid-cols-12 gap-8 py-8">

        <div class="col-span-12 lg:col-span-6">

            <div id="new_address" class=" {{ $address_type == 'new' ? 'block' : 'hidden' }} ">

                <div class="flex justify-between w-full">
                    <div>
                        <h3 class="text-lg uppercase font-medium py-2 border-b"><span class="border-b border-black py-2">Biling Details</span></h3>
                    </div>
                    <button id="saved_address" class=" bg-gray-400 hover:bg-gray-600 hover:text-slate-50 px-6 "> Select from saved addresses </button>
                </div>

                <form id="new_address_form" action=" {{ route('order.place') }} " method="POST">

                    @csrf
                    <input name="address_type" value="new" type="hidden">

                    <div class="flex justify-between gap-x-8 w-full">
                        <div class="flex-1">
                            <input type="text" name="firstname" value = "{{ old('firstname') }}" class="w-full inline focus:outline-none border my-4 leading-8 px-4" placeholder="First Name">
                            <p id="firstname_error" class="text-red-500 text-sm "></p>
                        </div>
                        <div class="flex-1 ">
                            <input type="text" name="lastname" value = "{{ old('lastname') }}" class="w-full inline focus:outline-none border my-4 leading-8 px-4" placeholder="Last Name">
                            <p id="lastname_error" class="text-red-500 text-sm "></p>
                        </div>
                    </div>
                    <select name="country" id="" class="w-full border leading-8 focus:outline-none py-2 px-4">
                        {{-- <option value="" class="">Country Name</option> --}}
                        <option value="India" class="" selected> India </option>
                    </select>
                    <input type="text" name="state" id="" value = "{{ old('state_name') }}"
                        class="w-full my-4 px-4 leading-8 border focus:outline-none"
                        placeholder="State Name">
                    <p id="state_name_error" class="text-red-500 text-sm "></p>
                    <input type="text" name="street_name" id="" value = "{{ old('street_name') }}"
                        class="w-full my-4 px-4 leading-8 border focus:outline-none"
                        placeholder="House number and street name">
                    <p id="street_name_error" class="text-red-500 text-sm "></p>
                    <input type="text" name="apartment" id="" value = "{{ old('apartment') }}"
                        class="w-full my-4 px-4 leading-8 border focus:outline-none"
                        placeholder="Apartment, suite, unit, etc (optional)">

                    <input type="text" name="city" id="" value = "{{ old('city') }}"
                        class="w-full my-4 px-4 leading-8 border focus:outline-none" placeholder="Town / City">
                    <p id="city_error" class="text-red-500 text-sm "></p>
                    {{-- <input type="text" name="apartment" id=""
                    class="w-full my-4 px-4 leading-8 border focus:outline-none" placeholder="Country (optional)"> --}}
                    <input type="tel" name="phone" id="" value = "{{ old('phone') }}"
                        class="w-full my-4 px-4 leading-8 border focus:outline-none" placeholder="Phone">
                    <p id="phone_error" class="text-red-500 text-sm "></p>
                    <input type="number" name="pin" id="" value = "{{ old('pin') }}"
                        class="w-full my-4 px-4 leading-8 border focus:outline-none" placeholder="Postcode">
                    <p id="pin_error" class="text-red-500 text-sm "></p>
                    <input type="email" name="email" id="" value = "{{ old('email') }}"
                        class="w-full my-4 px-4 leading-8 border focus:outline-none" placeholder="Email">
                    <p id="email_error" class="text-red-500 text-sm "></p>
                </form>
            </div>

            <div id="old_address" class=" {{ $address_type == 'old' ? 'block' : 'hidden' }}">
                <div class="flex justify-between w-full">
                    <div>
                        <h3 class="text-sm md:text-lg uppercase font-medium py-2 border-b"><span class="border-b border-black py-2">Select An Address </span></h3>
                    </div>
                    <button id="add_address" class=" bg-gray-400 hover:bg-gray-600 hover:text-slate-50 px-6 ">Add Address</button>
                </div>
                <div class="my-4">
                    <label >
                        <input type="checkbox" name="sameAddress" id="sameAddress" checked disabled class="text-blue-500">
                        Your shipping address and billing address will be the same.
                    </label>
                </div>

                @if ($user_addresses->isNotEmpty())
                    @foreach ($user_addresses as $k => $ad)
                        <div class="mt-4 p-8 w-full shadow-md">
                            <label class="flex gap-8 text-sm items-start">
                                <input type="radio" name="address" id="" value="{{ $ad->id }}" class="old_ad mt-1" {{ $k == 0 ? 'checked' : '' }}>
                                <div>
                                    <p> {{ $ad->firstname . ' ' . $ad->lastname }} </p>
                                    <p> {{ $ad->street_name }} </p>
                                    <p> {{ $ad->apartment }} </p>
                                    <p> {{ $ad->city }} </p>
                                    <p> {{ $ad->state }} </p>
                                    <p> {{ $ad->country }} </p>
                                    <p> {{ $ad->pin }} </p>
                                    <p> {{ $ad->phone . ' | ' . $ad->email }} </p>
                                </div>
                            </label>
                        </div>
                    @endforeach
                @endif


            </div>

            <div class="mt-4">
                <h3 class="text-lg Capitalize font-medium py-2 border-b"><span class="border-b border-black py-2">Additional Information</span></h3>
                <textarea name="" id="additional_info" class="w-full min-h-32 my-4 p-4 border focus:outline-none focus:border-b " placeholder="Notes about your order e.g. special notes for delivery"></textarea>
            </div>
        </div>
        <div class="col-span-12 lg:col-span-6">
            <div class="px-4 py-6 min-h-64 border-2 border-black ">
                <h3 class="text-lg uppercase font-medium py-2"><span class="border-b border-black py-2">Your Order</span></h3>
                <style>
					.break-words {
						word-wrap: break-word;
						overflow-wrap: break-word;
						white-space: normal; /* Prevents long text from stretching the cell */
					}

					.table-name-cell {
						white-space: nowrap; /* Keeps the product name in a single line if you prefer */
						text-overflow: ellipsis; /* Adds an ellipsis if the text is too long */
						overflow: hidden;
					}

				</style>
                <table class="w-full bg-white my-4">
					<thead class="border-b">
                        <tr>
							<th class="p-2 text-left">Thumbnail</th>
							<th class="p-2 text-center">Price</th>
							<th class="p-2 text-center">Size</th>
							<th class="p-2 text-center">Qty</th>
							<th class="p-2 text-right">Subtotal</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($products as $item)
							@php
								$product_id = $item['product_id'];
								$image = App\Models\ProductImage::where('product_id', $product_id)->first();
							@endphp
							<tr class="">
								<td class="p-2 text-center max-w-0">
									@if ($image)
										<img alt="Thumbnail" class="thumbnail-img mx-auto w-20 h-20" src="{{ asset('user/uploads/products/images/' . $image->image) }}">
									@endif
								</td>
								<td class="p-2 text-left  w-3/4 break-words" colspan="5"> {{ $item['name'] }} </td>
							</tr>
							<tr class="hover:shadow-sm border-b">
								<td class="p-2 text-left"></td>
								<td class="p-2 text-center text-neutral-500 whitespace-nowrap">₹ {{ $item['unit_price'] }}</td>
								<td class="p-2 text-center text-neutral-800"> {{ $item['sku'] }} </td>
								<td class="p-2 text-center text-neutral-800"> {{ $item['quantity'] }} </td>
								<td class="p-2 text-right text-neutral-600"> ₹ {{ $item['unit_price'] *  $item['quantity'] }} </td>
							</tr>

						@endforeach
					</tbody>
					<tfoot class="border-t-2">
                        <tr>
                            <td class="text-sm text-neutral-700" colspan="4">Price <span>({{count($products) }} {{ (count($products) > 1) ? 'items' : 'item'}})</span></td>
                            <td class="py-1 px-2 text-right text-sm text-neutral-800"> {{ '₹' . $original_price }} </td>
                        </tr>
                        <tr>
                            <td class="text-sm text-neutral-700" colspan="4">Discount</td>
                            <td class="py-1 px-2 text-right text-sm text-green-600">{{ '- ₹' .$original_price - $total_price }}</td>
                        </tr>
                        @if($coupon_discount > 0)
                        <tr>
                            <td class="text-sm text-neutral-700" colspan="4">Coupons for you </td>
                            <td class="py-1 px-2 text-right text-sm text-green-600"> {{ '-₹' . $coupon_discount }} </td>
                        </tr>
                        @endif
                        <tr>
                            <td class="text-sm text-neutral-700" colspan="4">Secured Packaging Fee</td>
                            <td class="py-1 px-2 text-right text-sm text-neutral-800"> {{ '₹' . $shipping_fee }} </td>
                        </tr>
                        <tr>
                            <td class="text-sm text-neutral-700" colspan="4">Platform Fee</td>
                            <td class="py-1 px-2 text-right text-sm text-neutral-800"> {{ '₹' . $platform_fee }} </td>
                        </tr>
						<tr class="border-t-2 border-neutral-300 border-dotted">
							<td class="p-2 text-left text-lg font-medium uppercase" colspan="4">Total Amount</td>
							<td class="p-2 text-right text-lg"> {{ ' ₹' . $total_amount }} </td>
						</tr>
					</tfoot>
				</table>
                <input type="radio" name="payments" id="prePaid" value="prePaid" class="my-2 mx-2" >
                <label for="prePaid" disabled>Online Payments</label>
                <br />
                <input type="radio" name="payments" id="postPaid" value="postPaid" class="my-2 mx-2" checked>
                <label for="postPaid">Cash on Delivery</label>
                <button id="place_order" class="w-full my-4 bg-neutral-800 text-white leading-10 hover:bg-neutral-950">Place Order</button>
                <p class="text-sm text-green-500">You have saved {{ '₹' .$original_price - $total_price + $coupon_discount }} on this order.</p>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

@if($products->count() > 0)
<script id="countDownScript">
    let diffInSeconds = {{ $diffInSeconds }};


    // Element to display the countdown or message
    const countdownElement = document.getElementById('timer-message');

    // If the time difference is within 5 minutes (300 seconds)
    if(countdownElement){
        if (diffInSeconds <= 900 ) {
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
    }
</script>
@endif

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
    const coupan_alert = document.getElementById('coupan_alert');


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
                // couponCont.innerHTML = `<p class="text-red-500">${data.message}</p>`;
                coupan_alert.textContent = data.message;
            }
        })
        .catch(error => {
            // Handle any errors during the fetch request
            console.error('Error applying coupon:', error);
            couponCont.innerHTML = `<p class="text-red-500">An error occurred while applying the coupon. Please try again.</p>`;
        });
    });
</script>

<script id="toggleAddressType">
    $("#add_address").click(function() {
        $("#old_address").hide();
        $("#new_address").show();
        address_type = "new";
    })
    $("#saved_address").click(function() {
        $("#old_address").show();
        $("#new_address").hide();
        address_type = "old";
    })
</script>

<script>
    let address_type = "old";
    let old_address_id = null;

    // Check if address_type is "old" and user_addresses is not empty
    @if($user_addresses->isNotEmpty())
        if (address_type === "old") {
            old_address_id = "{{ $user_addresses[0]->id }}";
        }
    @else
        address_type = "new";
    @endif


    $("#place_order").click(function() {

        let products = [];
        @foreach($products as $item)
        products.push({
            id: '{{ $item->product_id }}',
            size: '{{ $item->sku }}',
            quantity: {{ $item->quantity }}
        });
        @endforeach
        console.log(products);
        // Check availability
        $.ajax({
            url: "{{ route('order.checkAvailability') }}",
            type: "POST",
            data: {
                products: products,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                const allAvailable = response.availability.every(function(item) {
                    return item.available;
                });
                if(!allAvailable){
                    Swal.fire({
                        title: 'Out of Stock!',
                        text: 'One or more items are out of stock. Please adjust your order.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                // Proceed with the existing order submission logic
                var payment_type = document.querySelector('input[name="payments"]:checked').value;
                if (payment_type === "prePaid") {
                    // If prePaid is selected, initiate Razorpay payment
                    initiateRazorpay();
                } else {
                    if (address_type === "new") {
                        var new_address = $("#new_address_form").serialize();
                        new_address += "&payment_type=" + payment_type;
                        new_address += "&additional_info=" + $("#additional_info").val();
                        new_address += "&total_amount=" + "{{ $checkoutSession->total_amount }}";
                        new_address += "&checkout_session=" + "{{ $checkoutSession->id }}";
                        $.ajax({
                            url: "{{ route('order.place') }}",
                            type: "POST",
                            data: new_address,
                            success: function(response) {
                                console.log(response);
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: 'Order Placed!',
                                        text: 'Your order has been placed successfully. Click OK to view your orders.',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "/myorders";
                                        }
                                    });
                                }
                            },
                            error: function(xhr) {
                                if (xhr.status === 422) { // Validation error
                                    let errors = xhr.responseJSON.errors;
                                    $("#firstname_error").html(errors.firstname ? errors.firstname[0] : '');
                                    $("#lastname_error").html(errors.lastname ? errors.lastname[0] : '');
                                    $("#email_error").html(errors.email ? errors.email[0] : '');
                                    $("#phone_error").html(errors.phone ? errors.phone[0] : '');
                                    $("#street_name_error").html(errors.street_name ? errors.street_name[0] : '');
                                    $("#city_error").html(errors.city ? errors.city[0] : '');
                                    $("#pin_error").html(errors.pin ? errors.pin[0] : '');
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'An error occurred. Please try again later.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            }
                        });
                    } else if (address_type === "old") {
                        var old_address = "address_id=" + old_address_id;
                        old_address += "&payment_type=" + payment_type;
                        old_address += "&additional_info=" + $("#additional_info").val();
                        old_address += "&total_amount=" + "{{ $checkoutSession->total_amount }}";
                        old_address += "&address_type=old";
                        old_address += "&checkout_session=" + "{{ $checkoutSession->id }}";
                        old_address += "&_token={{ csrf_token() }}";
                        $.ajax({
                            url: "{{ route('order.place') }}",
                            type: "POST",
                            data: old_address,
                            success: function(response) {
                                console.log(response);
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: 'Order Placed!',
                                        text: 'Your order has been placed successfully. Click OK to view your orders.',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "/myorders";
                                        }
                                    });
                                }
                            },
                            error: function(error) {
                                console.log(error.responseJSON.errors);
                            }
                        });
                    }
                }
            },
            error: function(xhr) {
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while checking product availability. Please try again later.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
    $(".old_ad").change(function() {
        old_address_id = $(this).val();
    })

    function showAlert(title, text, icon, callback = null) {
        Swal.fire({
            title,
            text,
            icon,
            confirmButtonText: "OK"
        }).then(result => {
            if (result.isConfirmed && callback) callback();
        });
    }
</script>

<script id="razorPayMethods">
    function initiateRazorpay() {
        const total_price = "{{ $total_price }}"; // Fetch the total price
        // Make a request to your server to create the Razorpay order
        fetch("{{ route('order.createRazorpayOrder') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    total_price: total_price,
                    payment_type: "prePaid"
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    var options = {
                        key: "rzp_test_xsBQOyxcUmuo4d", // Razorpay Key
                        amount: data.order.amount, // Total price in paise
                        currency: data.order.currency,
                        name: "Bangabasi",
                        description: "Order Payment",
                        image: "/images/bangabasi_logo_short.png",
                        order_id: data.order.id,
                        handler: function(response) {
                            // Payment successful, send payment details to backend for verification
                            completeOrderPayment(response.razorpay_payment_id, response.razorpay_order_id);
                        },
                        prefill: {
                            name: "{{ Auth::user()->name }}",
                            email: "{{ Auth::user()->email }}",
                            contact: "{{ Auth::user()->phone }}"
                        },
                        theme: {
                            color: "#3399cc"
                        }
                    };
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
                } else {
                    showAlert("Error!", "Failed to create Razorpay order. Please try again later.", "error");
                }
            });
    }

    function completeOrderPayment(payment_id, order_id) {
        const formData = new FormData(document.getElementById("new_address_form"));
        const formValues = {
            firstname: formData.get("firstname"),
            lastname: formData.get("lastname"),
            email: formData.get("email"),
            apartment: formData.get("apartment"),
            street_name: formData.get("street_name"),
            city: formData.get("city"),
            state: formData.get("state"),
            country: formData.get("country"),
            phone: formData.get("phone"),
            pin: formData.get("pin"),
        };
        const requestBody = {
            payment_id: payment_id,
            order_id: order_id,
            payment_type: "prePaid", // or dynamically set it based on user input
            user_id: "{{ Auth::user()->id }}",
            additional_info: document.getElementById("additional_info").value,
            total_price: "{{ $total_price }}",
            address_type: address_type, // you may have this set already
            address_id: old_address_id, // you may have this set already
            ...formValues // Spreading the form values into the request body
        };
        // Send payment details to server to complete the order and update status
        fetch("{{ route('order.instantcompletePayment') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": '{{ csrf_token() }}'
                },
                body: JSON.stringify(requestBody)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    console.log('Hello');
                    showAlert("Order Placed!", "Your payment was successful, and your order is confirmed!", "success", function() {
                        window.location.href = "/myorders";
                    });
                } else {
                    showAlert("Error!", "Payment verification failed. Please try again.", "error");
                }
            })
            .catch(() => {
                showAlert("Error!", "An error occurred while processing payment. Please try again later.", "error");
            });
    }
</script>
@endpush
