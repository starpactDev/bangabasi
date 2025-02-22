@php
$bgClass = $item->status == 5 ? 'bg-orange-500' : 'bg-red-500'; 
@endphp
<div class="relative pl-6">
    <div class="absolute left-0 top-2 w-2 h-2 rounded-full  {{ $bgClass }}"></div>
    <p class="text-sm text-gray-600 cursor-pointer" id="toggleShipped">Order Processed <span class="text-gray-500">- {{ $shiprocketData->created_at ?? '' }}</span></p>

    <!-- Shipment Details (Hidden by default) -->
    <div id="shipmentDetails" class="hidden mt-4 p-4 bg-white border rounded-md shadow">
        <h3 class="font-semibold text-lg mb-2">Processing Details</h3>
        <div class="space-y-2">
            @if(isset($shiprocketData) && !is_null($shiprocketData->status_code))
                @if($shiprocketData->status_code > 0)
                <div class="relative">
                    <p class="text-sm font-semibold text-gray-800">Order Created</p>
                    <p class="text-xs text-gray-500">{{ $shiprocketData->created_at }}</p>
                </div>
                @endif

                @if($shiprocketData->status_code > 1)
                <div class="relative">
                    <p class="text-sm font-semibold text-gray-800">Invoiced {{$shiprocketData->invoice_no ?? ''}}</p>
                    <p class="text-xs text-gray-500">{{ $shiprocketData->invoice_date ?? '' }}</p>
                </div>
                @endif

                @if($shiprocketData->status_code > 2)
                <div class="relative">
                    <p class="text-sm font-semibold text-gray-800">Ready to Ship</p>
                    <p class="text-xs text-gray-500">{{ $shiprocketData->status_code == 2 ? $shiprocketData->updated_at : '' }}</p>
                </div>
                @endif

                @if($shiprocketData->status_code > 3)
                <div class="relative">
                    <p class="text-sm font-semibold text-gray-800">Pickup Scheduled</p>
                    <p class="text-xs text-gray-500">{{ $shiprocketData->shipments->pickup_scheduled_date }}</p>
                </div>
                @endif

                @if($shiprocketData->status_code > 7)
                <div class="relative">
                    <p class="text-sm font-semibold text-gray-800">Current Status: {{ $shiprocketData->status}}</p>
                    <p class="text-xs text-gray-500 capitalize">{{ $shiprocketData->updated_at }}</p>
                </div>
                @endif
            @endif
        </div>

    </div>
</div>