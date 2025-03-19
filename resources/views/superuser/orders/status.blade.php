@extends('superuser.layouts.master')

@section('head')
	<!-- Data Tables -->


@endsection
@php
    $badgeClass = '';

    switch ($order->order_status) {
        case 'Delayed':
            $badgeClass = 'badge-primary';
            break;
        case 'On Hold':
            $badgeClass = 'badge-warning';
            break;
        case 'Completed':
            $badgeClass = 'badge-success';
            break;
        case 'Cancelled':
            $badgeClass = 'badge-danger';
            break;
        default:
            $badgeClass = 'badge-secondary'; // fallback for unknown status
            break;
    }
@endphp	

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-primary fw-bold">Order : <span class="text-info">{{ $order->unique_id }}</span> Details</h4>
                </div>
                <div class="card-body d-flex">
                    <div style="flex:1">
                        <h5 class="mb-3">Shipping Address</h5>
                        <address>
                            <strong class="my-2">{{ $order->address->firstname }} {{ $order->address->lastname }}</strong><br>
                            {{ $order->address->street_name }} {{ $order->address->apartment }}<br>
                            {{ $order->address->city }}, {{ $order->address->state }}<br>
                            {{ $order->address->country }} - {{ $order->address->pin }}<br>
                            Phone: {{ $order->address->phone }}<br>
                            Email: <a href="mailto:{{ $order->address->email }}">{{ $order->address->email }}</a>
                        </address>
                        <hr>
                        <h5>Order Details</h5>
                        <p>Order ID: <strong>{{ $order->id }}</strong></p>
                        <p>Order Item ID: <strong>{{ $orderItem->id }}</strong></p>
                        <p>Status: <span class="badge {{ $badgeClass }}">{{ $orderItem->status }}</span></p>
                        <p>Payment Method: <strong>{{ $order->payment_method }}</strong></p>
                    </div>
                    <div class="p-4" style="flex:1">
                        <img src="{{ isset($user->image) && $user->image ? '/user/uploads/profile/' . $user->image : '/user/uploads/profile/default_dp.png' }}" class="" alt="" style="width: 100%; height: auto; border-radius: 50%;">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 card">
            @if($productData)
                <h5 class="card-title pt-2 py-2">{{ $productData->name }}</h5>
                <div class=" d-flex flex-row">
                    <!-- Image section -->
                    <div class="d-flex " style="min-width: 10rem; height: 16rem; overflow: hidden; flex-shrink: 0;">
                        <img src="{{ asset('user/uploads/products/images/' . $productData->productImages->first()->image) }}" 
                            class="img-fluid" 
                            alt="{{ $productData->name }}" 
                            style="object-fit: contain; height: 100%; width: 100%;">
                    </div>

                    <!-- Text content section -->
                    <div class="card-body d-flex flex-column " style="flex-grow: 1; gap: 1rem;">
                        <p class="card-text">
                            <strong>Category:</strong> {{ $productData->category }}<br>
                            <strong>Sub-category:</strong> {{ $productData->sub_category }}
                        </p>
                        <p class="card-text">Size  : {{ $orderItem->sku }}</p>
                        <p class="card-text">
                            <strong>Price:</strong> ₹{{ number_format($productData->offer_price ?? $productData->original_price, 2) }}
                        </p>
                        <p class="card-text">
                            <strong>Status:</strong> {{ $productData->is_active ? 'Available' : 'Not Available' }}
                        </p>
                    </div>
                </div>
            @else
                <p>No product data found.</p>
            @endif
        </div>

    </div>
</div>

@if($orderItem->status == 0)
    <style>
        #order-message-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .alert {
            font-size: 16px;
            padding: 15px;
            margin-bottom: 10px;
        }
    </style>
    <!-- Initiate Order -->
    <div id="initiate-order-section" class="text-center my-4 container">
        <form id="initiate-order-form" action="{{ route('superuser_orders.initiate')}}" method="POST">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->unique_id }}">
            <input type="hidden" name="orderItem_id" value="{{ $orderItem->id}}">
            <input type="hidden" name="product_id" value="{{ $productData->id }}">
            
            <div class="d-flex w-full p-4" style="justify-content : space-between">
                <!-- Length input -->
                <div class="mb-3">
                    <label for="length" class="form-label">Length (in cms)</label>
                    <input type="number" id="length" name="length" class="form-control" step="0.1" min="0.5" required>
                    <small class="form-text text-muted">Length must be more than 0.5 cm.</small>
                </div>

                <!-- Breadth input -->
                <div class="mb-3">
                    <label for="breadth" class="form-label">Breadth (in cms)</label>
                    <input type="number" id="breadth" name="breadth" class="form-control" step="0.1" min="0.5" required>
                    <small class="form-text text-muted">Breadth must be more than 0.5 cm.</small>
                </div>

                <!-- Height input -->
                <div class="mb-3">
                    <label for="height" class="form-label">Height (in cms)</label>
                    <input type="number" id="height" name="height" class="form-control" step="0.1" min="0.5" required>
                    <small class="form-text text-muted">Height must be more than 0.5 cm.</small>
                </div>

                <!-- Weight input -->
                <div class="mb-3">
                    <label for="weight" class="form-label">Weight (in kgs)</label>
                    <input type="number" id="weight" name="weight" class="form-control" step="0.1" min="0.1" required>
                    <small class="form-text text-muted">Weight must be more than 0 kg.</small>
                </div>

                <!-- Volumetric Weight -->
                
            </div>
                    <!-- Volumetric Weight and Action Buttons -->
            <div class="" >
                <!-- Initiate Order Button -->
                <button type="submit" id="initiate-order-button" class="btn btn-lg btn-warning text-white fw-bold" >Initiate Order</button>
            </div>
            
        </form>
        <div id="order-message-container" class="mt-4"></div>
    </div>
    

    <script>
        document.getElementById('initiate-order-form').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent default form submission

            // Clear previous messages
            const messageContainer = document.getElementById('order-message-container');
            messageContainer.innerHTML = ''; // Clear previous messages

            // Collect form data
            const form = event.target;
            const formData = new FormData(form);

            //add the csrf to the formdata
            formData.append('_token', '{{ csrf_token() }}');

            // Convert FormData to JSON
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });

            // Send POST request using fetch
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for Laravel
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                const messageContainer = document.getElementById('order-message-container');

                if (result.success) {
                    // Success message
                    messageContainer.innerHTML = `<div class="alert alert-success">
                        <strong>Success!</strong> Order initiated successfully: ${result.message}
                    </div>`;

                    // Remove the initiate order section after 5 seconds
                    setTimeout(() => {
                        const initiateOrderSection = document.getElementById('initiate-order-section');
                        if (initiateOrderSection) {
                            initiateOrderSection.remove();
                        }
                    }, 5000);
                } else {
                    // Handle different types of failure
                    let errorMessage = 'Something went wrong.';

                    // Check if result has validation errors or specific failure message
                    if (result.errors) {
                        errorMessage = '<ul>';
                        for (const [key, messages] of Object.entries(result.errors)) {
                            messages.forEach(message => {
                                errorMessage += `<li><strong>${key}</strong>: ${message}</li>`;
                            });
                        }
                        errorMessage += '</ul>';
                    } else if (result.message) {
                        errorMessage = result.message;
                    }

                    messageContainer.innerHTML = `<div class="alert alert-danger">
                        <strong>Error!</strong> ${errorMessage}
                    </div>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const messageContainer = document.getElementById('order-message-container');
                messageContainer.innerHTML = `<div class="alert alert-danger">
                    <strong>Error!</strong> An error occurred while initiating the order.
                </div>`;
            });
        });

    </script>
@endif

@if($orderResponse)
    <div class="container mt-5">
        <h4 class="mb-4">Ship Rocket Last Order Response</h4>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card ">
                    <div class="card-header">
                        <strong>Order ID:</strong> {{ $orderResponse->id }} <br>
                        <strong>Channel Order ID:</strong> {{ $orderResponse->channel_order_id }}
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Order Item ID: {{ $orderResponse->order_item_id }}</h5>
                        
                        <p class="card-text"><strong>Status:</strong> {{ $orderResponse->status }}</p>
                        <p class="card-text"><strong>Status Code:</strong> {{ $orderResponse->status_code }}</p>
                        <p class="card-text"><strong>AWB Code:</strong> {{ $orderResponse->awb_code ?? 'N/A' }}</p>
                        <p class="card-text"><strong>Courier:</strong> {{ $orderResponse->courier_name ?? 'Not Available' }}</p>
                        <p class="card-text"><strong>Invoice No:</strong> {{ $orderResponse->invoice_no ?? 'N/A' }}</p>
                        <p class="card-text"><strong>Invoice Date:</strong> {{ $orderResponse->invoice_date ?? 'N/A' }}</p>
                        <h4 class="my-1">Shipment Details</h4>
                        <p class="card-text"><strong>Shipment ID:</strong> {{ $orderResponse->shipments->id ?? 'N/A' }}</p>
                        <p class="card-text"><strong>Shipment Cost:</strong> {{ $orderResponse->shipments->cost ?? 'N/A' }}</p>
                        <p class="card-text"><strong>Delivery Date:</strong> {{ $orderResponse->delivery->date ?? 'N/A' }}</p>
                        <p class="card-text"><strong>Dimension:</strong> {{ $orderResponse->shipments->dimensions ?? 'N/A' }} cm x cm x cm</p>
                        <p class="card-text"><strong>Weight:</strong> {{ $orderResponse->shipments->weight ?? 'N/A' }} kg</p>
                        <p class="card-text"><strong>Volumetric Weight:</strong> {{ isset($orderResponse->shipments->volumetric_weight) ? ($orderResponse->shipments->volumetric_weight * 1000) : 'N/A' }} gm</p>
                        <p class="card-text"><strong>Packaging Box Error:</strong> {{ $orderResponse->packaging_box_error ?? 'None' }}</p>
                    </div>
                    <div class="card-footer text-muted d-flex justify-content-between">
                        <small>Created at: {{ $orderResponse->created_at }}</small>
                        <small>Updated at: {{ $orderResponse->updated_at }}</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card rounded">
                    <div class="card-header">
                        <strong>Customer & Pickup Address</strong> 
                    </div>
                    <div class="card-body">
                        <p class="card-text"><strong>Customer Name:</strong> {{ $orderResponse->customer_name }}</p>
                        <p class="card-text"><strong>Customer Email:</strong> {{ $orderResponse->customer_email }}</p>
                        <p class="card-text"><strong>Customer Phone:</strong> {{ $orderResponse->customer_phone }}</p>
                        <div class="py-2"></div>
                        <p class="card-text"><strong>Customer Address 1:</strong> {{ $orderResponse->customer_address }}</p>
                        <p class="card-text"><strong>Customer Address 2:</strong> {{ $orderResponse->customer_address_2 }} , {{ $orderResponse->customer_pincode }}</p>
                        <p class="card-text"><strong>City:</strong> {{ $orderResponse->customer_city }}</p>
                        <p class="card-text"><strong>State:</strong> {{ $orderResponse->customer_state }}</p>
                        <hr>
                        <p class="card-text"><strong>Pickup Code:</strong> {{ $orderResponse->pickup_code }}</p>
                        <p class="card-text"><strong>Pickup Location:</strong> {{ $orderResponse->pickup_location }}</p>
                        <p class="card-text"><strong>Pickup Location ID:</strong> {{ $orderResponse->pickup_location_id }}</p>
                    </div>
                    <div class="card-footer text-muted d-flex justify-content-between">
                        <small style="text-transform: capitalize;">Address Category : {{ $orderResponse->address_category }}</small>
                        <small style="text-transform: capitalize">RTO Risk: {{ $orderResponse->rto_risk }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Courier Status Check -->
<section class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Courier Status Check</h5>
        </div>
        <div class="card-body">
            <form>
                <div class="mb-3">
                    <label for="shippingId" class="form-label">Shipping ID</label>
                    <input type="text" class="form-control" id="shippingId" placeholder="Enter your shipping ID" required>
                </div>
                <div class="mb-3">
                    <label for="serviceProvider" class="form-label">Service Provider</label>
                    <select class="form-select" id="serviceProvider" required>
                        <option value="" disabled selected>Select Service Provider</option>
                        <option value="dhl">DHL</option>
                        <option value="fedex">FedEx</option>
                        <option value="ups">UPS</option>
                        <option value="usps">USPS</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success w-100">Check Status</button>
            </form>
        </div>
    </div>
</section>



@endsection
