@extends("layouts.master")
@section('head')
    <title>Bangabasi | Order Status</title>
@endsection
@section('content')
	@php
        $xpage = "Status";
        $xprv = "home";
    @endphp
    <x-bread-crumb :page="$xpage" :previousHref="$xprv" />


            <div class="flex flex-wrap justify-center items-center gap-4 p-8 bg-slate-50 my-4">
                <div class="min-w-80 text-center py-4 ">
                    <a class="uppercase text-2xl font-normal text-gray-500 hover:text-gray-600"><span class="inline-block   rounded-full w-8 mx-4">1</span>Shopping Cart</a>
                </div>
                <div class="min-w-80 text-center py-4 ">
                    <a class="uppercase text-2xl font-normal text-gray-500 hover:text-gray-600"><span class="inline-block border rounded-full w-8 mx-4">2</span>Checkout</a>
                </div>
                <div class="min-w-80 text-center py-4 ">
                    <a class="uppercase text-2xl font-normal  hover:text-gray-600"><span class="inline-block bg-black text-white border rounded-full w-8 mx-4">3</span>Order Status</a>
                </div>
            </div>

            <div class="container grid grid-cols-12 min-h-64 gap-4 items-center shadow-lg">
                <div class="col-span-12 md:col-span-12 flex flex-col justify-center items-center ">
                    <div class="h-52 overflow-hidden flex justify-center items-center">
                        <img src="/images/icons/done-512.png" alt="" class="h-36 animate-ping-once">

                    </div>
                    <h1 class="text-3xl md:text-6xl font-bold my-8">Thank You for your order.</h1>
                    <p class="text-lg font-normal">Your order confirmation mail will be sent to your registered email with a link to track progress.</p>
                    <h2 class="text-md font-md px-4 py-2 border border-neutral-700 my-6 bg-neutral-100 rounded-full cursor-pointer">Your Order Id is <span class="text-blue-800 font-medium">#1234567890</span></h2>
                </div>
                <div class="col-span-12 lg:col-span-12 p-6 items-center">
                    <!-- <h2 class="text-2xl font-semibold mb-8 ">Order Success</h2> -->
                    <div class="grid grid-cols-2 ">
                        <div class="col-span-2 lg:col-span-1">
                            <div class="mb-4">
                                <h3 class="text-xl font-medium">Order Details</h3>
                                <p class="text-gray-700 mt-1"><strong>Order ID:</strong> #123456789</p>
                                <p class="text-gray-700 mt-1"><strong>Order Date:</strong> September 9, 2024</p>
                            </div>

                            <div class="mb-4">
                                <h3 class="text-xl font-medium">Payment Information</h3>
                                <p class="text-gray-700 mt-1"><strong>Payment Method:</strong> Credit Card</p>
                            </div>
                        </div>
                        <div class="col-span-2 lg:col-span-1">
                            <div class="mb-4">
                                <h3 class="text-xl font-medium">Shipping Address</h3>
                                <p class="text-gray-700 mt-1"><strong>Name:</strong> John Doe</p>
                                <p class="text-gray-700 mt-1"><strong>Address:</strong> 1234 Elm Street, Apt 56, Springfield, IL 62704</p>
                            </div>

                            <div>
                                <h3 class="text-xl font-medium">Order Summary</h3>
                                <p class="text-gray-700 mt-1"><strong>Total Billing Price:</strong> ₹129.99</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="container hidden grid-cols-12 min-h-64 gap-6 ">
                <div class="col-span-12 md:col-span-12 flex flex-col justify-center items-center py-18 md:py-36">
                    <div class="h-52 overflow-hidden flex justify-center items-center">
                        <img src="/images/icons/failed.png" alt="" class="h-36 animate-ping-once-red">
                    </div>
                    <p class="text-lg font-medium">Your order could not be placed successfully.</p>
                </div>
            </div>

    </div>

    <x-combothree />
@endsection
