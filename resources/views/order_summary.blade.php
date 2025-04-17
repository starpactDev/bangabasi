@extends("layouts.master")
@section('head')
<title>Bangabasi | Order Summary {{$order->unique_id ?? ''}}</title>
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
            <p class="text-sm text-gray-500">Order ID: <span class="font-medium">{{ $order->unique_id ?? 'N/A' }}</span></p>
            <p class="text-sm text-gray-500">Order Date: <span class="font-medium">{{ optional($order->created_at)->format('d M Y, h:i A') ?? 'N/A' }}</span></p>
        </div>
        <div class="text-right">
            <p class="font-semibold capitalize">Status: <span class="text-blue-600">{{ $order->status ?? 'N/A' }}</span></p>
            <p class="text-sm text-gray-500">{{ ($order->payment_method ?? '') === 'prePaid' ? 'Prepaid' : 'Cash On Delivery' }}</p>
        </div>
    </div>

    <!-- Shipping / Billing Info -->
    <div class="grid md:grid-cols-2 gap-6 mb-6 text-sm">
        <div>
            <h2 class="font-semibold text-lg mb-2">Shipping Address</h2>
            @php $addr = $order->address; @endphp
            @if ($addr)
                <p><strong>{{ $addr->firstname ?? '' }} {{ $addr->lastname ?? '' }}</strong></p>
                <p><small class="text-neutral-700">Street Name : </small>{{ $addr->street_name ?? '—' }}</p>
                <p><small class="text-neutral-700">Apartment </small>{{ $addr->apartment ?? '—' }}</p>
                <p>{{ $addr->city ?? '' }}, {{ $addr->state ?? '' }} - {{ $addr->postal_code ?? '' }}</p>
                <p>Phone: {{ $addr->phone ?? '—' }}</p>
                <p>Email: {{ $addr->email ?? '—' }}</p>
                <p class="text-xs text-gray-400 mt-1 italic">{{ $addr->deleted_at ? '(Address was removed by user)' : '' }}</p>
            @else
                <p class="text-gray-500 italic">Address not available</p>
            @endif
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
                        <th class="p-3 border-b text-right">GST</th>
                        <th class="p-3 border-b text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems ?? [] as $item)
                    <tr>
                        <td class="p-3 border-b">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('user/uploads/products/images/' . ($item->product->productImages->first()->image ?? 'placeholder.jpg')) }}" alt="Product Image" class="w-12 h-12 object-cover rounded">
                                <span>{{ $item->product->name ?? 'Unnamed Product' }}</span>
                            </div>
                        </td>
                        <td class="p-3 border-b">{{ $item->sku ?? 'N/A' }}</td>
                        <td class="p-3 border-b text-right">{{ $item->quantity ?? 0 }}</td>
                        <td class="p-3 border-b text-right">₹{{ number_format($item->unit_price ?? 0, 2) }}</td>
                        <td class="p-3 border-b text-right">₹{{ number_format($item->gst ?? 0, 2) }}</td>
                        @php
                            $total = ($item->unit_price ?? 0) * ($item->quantity ?? 0) + ($item->gst ?? 0);
                        @endphp
                        <td class="p-3 border-b text-right">₹{{ number_format($total, 2) }}</td>
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
                <p><span class="font-medium">Total Paid by Customer:</span> ₹{{ number_format($order->amountBreakdown->total_paid_by_customer ?? 0, 2) }}</p>
                <p class="text-base font-semibold mt-4 border-t pt-2">
                    Grand Total: ₹{{ number_format($order->price ?? 0, 2) }}
                </p>
            </div>
            <div class="space-y-2 text-right">
                @php
                    $subtotal = collect($order->orderItems ?? [])->sum(function ($item) {
                        return (($item->unit_price ?? 0) * ($item->quantity ?? 0)) + ($item->gst ?? 0);
                    });
                @endphp
                <p><span class="font-medium">Subtotal (Incl. GST):</span> ₹{{ number_format($subtotal, 2) }}</p>
                <p><span class="font-medium">Coupon Discount:</span> -₹{{ number_format($order->amountBreakdown->coupon_discount ?? 0, 2) }}</p>
                <p><span class="font-medium">Shipping Charge:</span> ₹{{ number_format($order->amountBreakdown->shipping_charge ?? 0, 2) }}</p>
                <p><span class="font-medium">Platform Fee:</span> ₹{{ number_format($order->amountBreakdown->platform_fee ?? 0, 2) }}</p>
            </div>
        </div>
    </div>
</div>

<div class="mt-6 text-right max-w-4xl mx-auto">
    <button onclick="printReceipt()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-md shadow">
        🖨️ Print Receipt
    </button>
</div>
<!-- Hidden A5 Print Layout -->
<div id="printable-receipt" class="hidden print:block print:p-4 print:bg-white print:text-black text-sm font-sans">
    <div class="w-[148mm] mx-auto border p-4">
        <h2 class="text-center text-lg mb-2">Order Receipt</h2>
        <p><strong>Order ID:</strong> {{ $order->unique_id ?? 'N/A' }}</p>
        <p><strong>Date:</strong> {{ $order->created_at?->format('d M, Y h:i A') ?? 'N/A' }}</p>

        <hr class="my-2 border-dashed">

        <!-- Address -->
        <h3 class="font-semibold">Shipping Address</h3>
        @php $addr = $order->address; @endphp
        <div class="flex justify-between">
            <p class="mt-1">
                {{ $addr?->firstname.' '.$addr?->lastname ?? 'N/A' }}<br>
                {{ $addr?->street_name ?? '' }}, {{ $addr?->apartment ?? '' }}<br>
                {{ $addr?->city ?? '' }}, {{ $addr?->state ?? '' }}, {{ $addr?->pin ?? '' }}<br>
            </p>
            <div>
                <p><small class="text-neutral-700">Mobile: </small> {{ $addr?->phone ?? '—' }}</p>
                <p><small class="text-neutral-700">Email : </small> {{ $addr?->email ?? '—' }}</p>
                <p><small class="text-neutral-700">Country : </small>{{ $addr?->country ?? '—' }}</p>
            </div>
        </div>

        <hr class="my-4 border-dashed">

        <!-- Items Table -->
        <table class="w-full text-left mb-4">
            <thead>
                <tr class="border-b">
                    <th class="py-1">#</th>
                    <th class="py-1">Item</th>
                    <th class="py-1 text-right">SKU</th>
                    <th class="py-1 text-right">Qty</th>
                    <th class="py-1 text-right">Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems ?? [] as $i => $item)
                <tr>
                    <td class="py-1">{{ $i + 1 }}</td>
                    <td class="py-1">{{ $item->product->name ?? 'Unnamed Product' }}</td>
                    <td class="py-1 text-right">{{ $item->sku ?? 'N/A' }}</td>
                    <td class="py-1 text-right">{{ $item->quantity ?? 0 }}</td>
                    <td class="py-1 text-right">₹{{ number_format(($item->unit_price ?? 0) * ($item->quantity ?? 0), 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary -->
        <div class="text-right space-y-1">
            <p><strong>Subtotal:</strong> ₹{{ number_format(($order->orderItems ?? collect())->sum(fn($item) => ($item->unit_price ?? 0) * ($item->quantity ?? 0)), 2) }}</p>
            <p><strong>Discount:</strong> -₹{{ number_format($order->amountBreakdown->coupon_discount ?? 0, 2) }}</p>
            <p><strong>Shipping:</strong> ₹{{ number_format($order->amountBreakdown->shipping_charge ?? 0, 2) }}</p>
            <p><strong>Platform Fee:</strong> ₹{{ number_format($order->amountBreakdown->platform_fee ?? 0, 2) }}</p>
            <p><strong class="text-lg">Grand Total:</strong> ₹{{ number_format($order->price ?? 0, 2) }}</p>
        </div>

        <hr class="my-4 border-dashed">

        <p class="text-xs text-center text-gray-500 mt-6">Thank you for shopping with us!</p>
    </div>
</div>


@endsection

@push('scripts')
<script>
    function printReceipt() {
        const printContents = document.getElementById("printable-receipt").innerHTML;
        const originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload(); // Reload to restore event bindings
    }
</script>

@endpush