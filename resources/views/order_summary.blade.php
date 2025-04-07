@extends("layouts.master")
@section('head')
<title>Bangabasi | My Orders</title>
@endsection
@section('content')
@php
    $xpage = "myorders";
    $xprv = "home";
@endphp
<x-bread-crumb :page="$xpage" :previousHref="$xprv" />
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-md my-8 p-6 text-gray-800">
    <div class="flex justify-between items-center border-b pb-4 mb-4">
        <div>
            <h1 class="text-2xl font-bold">Order Summary</h1>
            <p class="text-sm text-gray-500">Order ID: <span class="font-medium">{{ $order->unique_id }}</span></p>
            <p class="text-sm text-gray-500">Order Date: <span class="font-medium">{{ $order->created_at->format('d M Y, h:i A') }}</span></p>
        </div>
        <div class="text-right">
            <p class="font-semibold capitalize">Status: <span class="text-blue-600">{{ $order->status }}</span></p>
            <p class="text-sm text-gray-500">{{ $order->payment_method === 'prePaid' ? 'Prepaid' : 'Cash On Delivery' }}</p>
        </div>
    </div>

    <!-- Shipping / Billing Info -->
    <div class="grid md:grid-cols-2 gap-6 mb-6 text-sm">
        <div>
            <h2 class="font-semibold text-lg mb-2">Shipping Address</h2>
            @php $addr = $order->address; @endphp
            <p><strong>{{ $addr->firstname.' '.$addr->lastname }}</strong></p>
            <p><small class="text-neutral-700">Street Name : </small>{{ $addr->street_name }}</p>
            <p><small class="text-neutral-700">Apartment </small>{{ $addr->apartment }}</p>
            <p>{{ $addr->address_line }}</p>
            <p>{{ $addr->city }}, {{ $addr->state }} - {{ $addr->postal_code }}</p>
            <p>Phone: {{ $addr->phone }}</p>
            <p>Email: {{ $addr->email ?? '—' }}</p>
            <p class="text-xs text-gray-400 mt-1 italic">{{ $addr->deleted_at ? '(Address was removed by user)' : '' }}</p>
        </div>        
        <div>
            <h2 class="font-semibold text-lg mb-2">Additional Info</h2>
            <p>{{ $order->additional_info ?? '—' }}</p>
        </div>
    </div>

    <!-- Items -->
    <div class="mb-6">
        <h2 class="font-semibold text-lg mb-2">Items Purchased</h2>
        <div class="border rounded-md overflow-hidden">
            <table class="min-w-full text-sm table-auto border-collapse">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="p-3 border-b">Product</th>
                        <th class="p-3 border-b">SKU</th>
                        <th class="p-3 border-b text-right">Quantity</th>
                        <th class="p-3 border-b text-right">Unit Price</th>
                        <th class="p-3 border-b text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $item)
                    <tr>
                        <td class="p-3 border-b">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('user/uploads/products/images/' . $item->product->productImages->first()->image) }}" alt="Product Image" class="w-12 h-12 object-cover rounded">
                                <span>{{ $item->product->name }}</span>
                            </div>
                        </td>
                        <td class="p-3 border-b">{{ $item->sku ?? 'N/A' }}</td>
                        <td class="p-3 border-b text-right">{{ $item->quantity }}</td>
                        <td class="p-3 border-b text-right">₹{{ number_format($item->unit_price, 2) }}</td>
                        <td class="p-3 border-b text-right">₹{{ number_format($item->unit_price * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Order Total Summary -->
    <div class="bg-gray-50 border rounded-lg p-4 mt-6 shadow-sm">
        

        <div class="grid md:grid-cols-2 gap-6 text-sm">


            <div class="space-y-2">
                <h2 class="text-lg font-semibold mb-4 text-gray-700">Order Summary</h2>
                <p><span class="font-medium">Total Paid by Customer:</span> ₹{{ number_format($order->amountBreakdown->total_paid_by_customer, 2) }}</p>
                
                <p class="text-base font-semibold mt-4 border-t pt-2">
                    Grand Total: ₹{{ number_format($order->price, 2) }}
                </p>
            </div>
            <div class="space-y-2 text-right">
                <p><span class="font-medium">Subtotal:</span> ₹{{ number_format($order->orderItems->sum(fn($item) => $item->unit_price * $item->quantity), 2) }}</p>
                <p><span class="font-medium">Coupon Discount:</span> -₹{{ number_format($order->amountBreakdown->coupon_discount ?? 0, 2) }}</p>
                <p><span class="font-medium">Shipping Charge:</span> ₹{{ number_format($order->amountBreakdown->shipping_charge ?? 0, 2) }}</p>
                <p><span class="font-medium">Platform Fee:</span> ₹{{ number_format($order->amountBreakdown->platform_fee ?? 0, 2) }}</p>
            </div>
        </div>
    </div>


</div>
@endsection