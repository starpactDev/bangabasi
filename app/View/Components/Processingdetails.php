<?php

namespace App\View\Components;

use Closure;
use App\Models\OrderResponse;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;

class Processingdetails extends Component
{
    public $item;
    public $orderResponse;
    public $shiprocketData;
    /**
     * Create a new component instance.
     */
    public function __construct($item)
    {
        $this->item = $item;
        $this->orderResponse = OrderResponse::where('order_item_id', $item->id)->first();

        // Fetch Shiprocket order details if shipment_id exists
        
        $this->shiprocketData = null;
        if ($this->orderResponse && $this->orderResponse->order_id) {
            $this->fetchShiprocketData($this->orderResponse->order_id);
        }

    }

    private function fetchShiprocketData($orderId)
    {
        $baseUrl = config('shiprocket.base_url');
        $apiToken = config('shiprocket.api_token');

        // Make the request to Shiprocket API
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
        ])->get("{$baseUrl}/orders/show/{$orderId}");

        // Check if the response was successful
        if ($response->successful()) {
            // Extract the data from the response
            $shiprocketData = (object) $response->json()['data'];

            // Update the local database with the fetched Shiprocket data
            $this->updateLocalDatabaseWithShiprocketData($orderId, $shiprocketData);

            // Set the shiprocketData to be the fetched data (remains the same structure as before)
            $this->shiprocketData = $shiprocketData;
        } else {
            $this->shiprocketData = null;
        }
    }

    private function updateLocalDatabaseWithShiprocketData($orderId, $shiprocketData)
    {
        // Assuming you're working with the OrderResponse model or similar
        $orderResponse = OrderResponse::where('order_id', $orderId)->first();

        if ($orderResponse) {
            // Update existing record with the latest Shiprocket data
            $orderResponse->update([
                'shipment_id' => $shiprocketData->shipments->id ?? null,
                'status' => $shiprocketData->status,
                'status_code' => $shiprocketData->status_code,
                'awb_code' => $shiprocketData->lshipments->awb ?? null,
                'courier_company_id' => $shiprocketData->shipments->courier_id ?? null,
                'courier_name' => $shiprocketData->shipments->courier ?? null,
                'updated_at' => now(),
            ]);
        } else {
            // If no existing record, you can create a new one (optional)
            OrderResponse::create([
                'order_id' => $orderId,
                'shipment_id' => $shiprocketData->shipments->id ?? null,
                'status' => $shiprocketData->status,
                'status_code' => $shiprocketData->status_code,
                'awb_code' => $shiprocketData->lshipments->awb ?? null,
                'courier_company_id' => $shiprocketData->shipments->courier_id ?? null,
                'courier_name' => $shiprocketData->shipments->courier ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        
        return view('components.processingdetails', [
            'shiprocketData' => $this->shiprocketData
        ]  );
    }
}
