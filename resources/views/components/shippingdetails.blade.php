<div class="relative pl-6">
    <div class="absolute left-0 top-2 w-2 h-2 bg-orange-500 rounded-full"></div>
    <p class="text-sm text-gray-600 cursor-pointer" id="toggleShipped">Shipped 
        <span class="text-gray-500">- Jan 27, 2025</span>
    </p>

    <!-- Shipment Tracking (Hidden by default) -->
    <div id="shipmentDetails" class="hidden mt-4 p-4 bg-white border rounded-md shadow">
        <h3 class="font-semibold text-lg mb-2">Shipment Tracking</h3>
        
        <!-- Vertical Progress Bar -->
        <div class="relative border-l-4 border-gray-300 pl-4 space-y-4">
            <div class="absolute top-0 -left-1 h-full border-l-4 border-green-500 animate-progress"></div>
            @foreach($tracking->shipment_track_activities as $activity)
                <div class="relative">
                    <div class="w-3 h-3 bg-green-500 rounded-full absolute -left-6 top-1"></div>
                    <p class="text-sm font-semibold text-gray-800">{{ $activity->activity }}</p>
                    <p class="text-xs text-gray-500">{{$activity->date ?? ''}}, {{$activity->location ?? ''}}</p>
                </div>
            @endforeach
            

            <div class="relative">
                <div class="w-3 h-3 bg-green-500 rounded-full absolute -left-6 top-1"></div>
                <p class="text-sm font-semibold text-gray-800">Out for Delivery</p>
                <p class="text-xs text-gray-500">Jul 19, 2022 - 08:57 AM, Madanapalli, Andhra Pradesh</p>
            </div>

            <div class="relative">
                <div class="w-3 h-3 bg-green-500 rounded-full absolute -left-6 top-1"></div>
                <p class="text-sm font-semibold text-gray-800">Delivered</p>
                <p class="text-xs text-gray-500">Jul 19, 2022 - 11:37 AM, Madanapalli, Andhra Pradesh</p>
            </div>
        </div>
    </div>
</div>