@extends("layouts.master")
@section('head')
<title>Bangabasi | My Orders</title>
@endsection
@section('content')
@php
    $xpage = "myorders";
    $xprv = "home";
    use Carbon\Carbon;

    function formatTimeAgo($createdAt) {
        $now = Carbon::now();
        $createdAt = Carbon::parse($createdAt);

        // Define the time threshold for switching to full date format
        $threshold = 7; // 7 days; after this threshold, show the actual date

        // Check if the difference is more than the threshold (in days)
        if ($createdAt->diffInDays($now) >= $threshold) {
            return $createdAt->format('d-m-Y'); // Format as day-month-year
        }

        // Use Carbon's diffForHumans for relative times
        return $createdAt->diffForHumans($now);
    }
@endphp
<style>
    @keyframes progressFill {
        from { height: 0; }
        to { height: 100%; }
    }
    .animate-progress {
        animation: progressFill 1.5s ease-out forwards;
    }
</style>
<x-bread-crumb :page="$xpage" :previousHref="$xprv" />
<x-navigation-tabs />
<section id="orders" class="p-6 bg-gray-100 ">
    <div class="container mx-auto max-w-4xl space-y-6">

        <!-- Order Card: Pending -->
        @if($orders->isEmpty())
            <div class="text-center p-6 text-red-600 text-2xl">
                No orders placed yet.
            </div>
        @endif

        @foreach ($orders as $order)
            
            <div class="shadow-sm bg-gray-50 border-l border-l-blue-500">
                <div class="flex justify-between items-center text-white p-2 text-sm md:text-lg font-semibold {{ $order->status === 'canceled' ? 'bg-red-500' : 'bg-blue-500' }} ">
                    <a href="{{ route('order.summary', ['uniqueId' => $order->unique_id]) }}" class="cursor-pointer hover:text-orange-600"><span>Order ID: {{ $order->unique_id }}</span></a>
                    <span>Status: {{ ucfirst($order->status) }}</span>
                </div>
                @foreach ($order->orderItems as $item)
                    <div class="flex pb-16 md:pb-4 p-4 border-t border-gray-200 relative" >
                        <!-- Product Thumbnail -->
                        <img src="{{ asset('user/uploads/products/images/' . $item->product->productImages->first()->image) }}" alt="Product Thumbnail" class="w-24 h-24 object-cover rounded-md">
                        <div class="ml-4 flex-1 flex flex-col justify-center">
                            <!-- Product Details -->
                            <h2 class="text-lg font-semibold hover:text-orange-500 "><a href="{{ route('user.product.details', $id=$item->product->id) }}">{{ $item->product->name }}</a></h2>
                            <h3 class="text-gray-700">₹{{ number_format($item->unit_price, 2) }}</h3>
                            <div class="mt-2 text-gray-600">
                                <div><strong>Quantity:</strong> {{ $item->quantity }} x {{ $item->sku }}</div>
                                <div><strong>Subtotal:</strong> ₹{{ number_format($item->quantity * $item->unit_price, 2) }}</div>
                            </div>
                        </div>
                        @if($item->status <= 1)
                            <button class="absolute bottom-4 right-4 border-2 border-red-500 text-red-500 hover:text-white px-2 md:px-4 py-1 md:py-2 hover:bg-red-600 cancel-order-item-btn" data-order-item-id="{{ $item->id }}">Cancel</button>
                        @endif
                    </div>
                    <div class="pb-6 px-6 pt-2 bg-sky-50">
                        <h2 class="text-xl font-semibold mb-4">Order Tracking</h2>
                        @php
                            if( $item->status == 5){
                               $bgClass = 'bg-red-500'; 
                            }else{
                                $bgClass = 'bg-orange-500'; 
                            }
                            
                            // Set the width class based on the item status
                            if ($item->status == 0) {
                                $widthClass = 'w-2.5';  // Default width for status 0
                            } elseif ($item->status >= 1 && $item->status <= 5) {
                                $widthClass = 'w-1/4';  // For statuses 1 to 5
                            } elseif ($item->status == 6) {
                                $widthClass = 'w-2/4';  // For status 6
                            } elseif ($item->status == 7) {
                                $widthClass = 'w-full';  // For status 7 (full width)
                            } elseif ($item->status == 19) {
                                $widthClass = 'w-3/4';  // For status 19
                            } else {
                                $widthClass = 'w-2.5';  // Default width for any unrecognized status
                            }
                        @endphp
                        <!-- Order Progress Bar -->
                        <div class="relative">
                            <div class="flex justify-between text-sm font-medium text-gray-600 mb-2">
                                <span class="hidden md:inline">Placed</span>
                                <span class="md:hidden" title="Placed">↓</span>
                                <span class="hidden md:inline">Processing</span>
                                <span class="md:hidden" title="Processing">↓</span>
                                <span class="hidden md:inline">Shipped</span>
                                <span class="md:hidden" title="Shipped">↓</span>
                                <span class="hidden md:inline">Out for Delivery</span>
                                <span class="md:hidden" title="Out for Delivery">↓</span>
                                <span class="hidden md:inline">Delivered</span>
                                <span class="md:hidden" title="Delivered">↓</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="{{ $widthClass }} {{ $bgClass }} h-2.5 rounded-full"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Timeline -->
                        <div class="mt-6 space-y-4">
                            <!-- Order Placed -->
                            <div class="relative pl-6">
                                <div class="absolute left-0 top-2 w-2 h-2 rounded-full {{ $bgClass }} "></div>
                                <p class="text-sm text-gray-600">Order Placed <span class="text-gray-500">- Jan 25, 2025</span></p>
                            </div>

                            <!-- Order Processed with Shipment Tracking -->
                            @if ($item->status >= 1)
                                <x-processingdetails  :item="$item" />
                            @endif

                            <!-- Order Canceled -->
                            @if ($item->status == 5)
                                <div class="relative pl-6">
                                    <div class="absolute left-0 top-2 w-2 h-2 rounded-full {{ $bgClass }}"></div>
                                    <p class="text-sm text-gray-600">Cancelled <span class="text-gray-500">- Jan 29, 2025</span></p>
                                </div>
                            @endif

                            <!-- Order Shipped -->
                            @if ($item->status >= 6)
                                <x-shippingdetails :item="$item"/>
                            @endif

                            <!-- Out for Delivery -->
                            @if ($item->status == 19)
                            <div class="relative pl-6">
                                <div class="absolute left-0 top-2 w-2 h-2 bg-gray-400 rounded-full"></div>
                                <p class="text-sm text-gray-500">Out for Delivery</p>
                            </div>
                            @endif

                            <!-- Delivered -->
                            @if ($item->status == 7)
                            <div class="relative pl-6">
                                <div class="absolute left-0 top-2 w-2 h-2 bg-gray-400 rounded-full"></div>
                                <p class="text-sm text-gray-500">Delivered</p>
                            </div>
                            @endif
                        </div>
                    </div>

                @endforeach
                <div class="flex justify-between items-center px-4 py-2 ">
                    <div title="{{ $order->created_at->format('d-m-Y H:i') }}"> {{ formatTimeAgo($order->created_at) }} </div>
                    <a href="{{ route('order.summary', ['uniqueId' => $order->unique_id]) }}" class="cursor-pointer px-2 py-1 bg-orange-600 text-white rounded hover:bg-orange-800">Summary</a>
                    <div class="capitalize"> 
                        <span>Total Amount : ₹{{ $order->price }} | </span>
                        <span>{{ $order->payment_method == 'prePaid' ? 'Prepaid' : '' }} {{ $order->payment_method == 'postPaid' ? 'Cash On Delivery' : '' }}</span>
                    </div>
                </div>
            </div>
        @endforeach
        @if(!$orders->isEmpty())
        <div class="my-4 py-4 text-center border-b-4 border-b-orange-500">No More Orders</div>
        @endif


        {{-- <!-- Order Card: Rejected -->
        <div class="bg-white shadow-lg overflow-hidden border border-gray-300">
			<div class="flex justify-between items-center bg-red-500 text-white p-2 text-lg font-semibold">
				<span>Order ID: #67890</span>
				<span>Status: Rejected</span>
			</div>
			<div class="flex p-4">
				<!-- Product Thumbnail -->
				<img src="/images/products/6.png" alt="Product Thumbnail" class="w-24 h-24 object-cover rounded-md">
				<div class="ml-4 flex-1 flex flex-col justify-center">
					<!-- Product Details -->
					<div class="text-lg font-semibold">Another Product</div>
					<div class="text-gray-700">$49.99</div>
					<div class="mt-2 text-gray-600">
						<div><strong>Order Date:</strong> August 25, 2024</div>
						<div><strong>Delivery Date:</strong> August 30, 2024</div>
					</div>
				</div>
			</div>
		</div>

        <!-- Order Card: Delivered -->
        <div class="bg-white shadow-lg overflow-hidden border border-gray-300">
			<div class="flex justify-between items-center bg-green-500 text-white p-2 text-lg font-semibold">
				<span>Order ID: #54321</span>
				<span>Status: Delivered</span>
			</div>
			<div class="flex p-4">
				<!-- Product Thumbnail -->
				<img src="/images/products/9.png" alt="Product Thumbnail" class="w-24 h-24 object-cover rounded-md">
				<div class="ml-4 flex-1 flex flex-col justify-center">
					<!-- Product Details -->
					<div class="text-lg font-semibold">Third Product</div>
					<div class="text-gray-700">$19.99</div>
					<div class="mt-2 text-gray-600">
						<div><strong>Order Date:</strong> September 2, 2024</div>
						<div><strong>Delivery Date:</strong> September 4, 2024</div>
					</div>
				</div>
			</div>
		</div> --}}

    </div>
</section>


@endsection
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleShipped = document.querySelectorAll("#toggleShipped");
        if(toggleShipped.length > 0){
            toggleShipped.forEach(button => {
                button.addEventListener("click", function () {
                    let details = this.parentElement.querySelector("#shipmentDetails");
                    details.classList.toggle("hidden");
                });
            })
        }
    });
</script>

<script id="cancelOrderItem">
    $(document).on('click', '.cancel-order-item-btn', function() {
        let orderItemId = $(this).data('order-item-id');
        let button = $(this);

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, cancel it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('cancelOrderItem') }}", // Replace with the correct route name
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        order_item_id: orderItemId
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            if (button) {
                                    button.text('Cancelled') ;
                                }
                            Swal.fire(
                                'Canceled!',
                                'Your order has been canceled.',
                                'success'
                            );
                            

                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'An error occurred. Please try again.', 'error');
                    }
                });
            }
        });
    });
</script>
@endpush