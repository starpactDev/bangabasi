<?php

namespace App\View\Components;

use Closure;
use App\Models\OrderResponse;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;

class shippingdetails extends Component
{
    public $item;
    public $orderResponse;
    public $tracking;
    /**
     * Create a new component instance.
     */
    public function __construct($item)
    {
        $this->item = $item;

        // Fetch Shiprocket order details if shipment_id exists
        $this->tracking = [];
        if ($this->orderResponse && $this->orderResponse->awb_code) {

            $this->fetchShiprocketData($this->orderResponse->awb_code);
        }
    }


    private function fetchShiprocketData($awb_code)
    {
        $baseUrl = config('shiprocket.base_url');
        $apiToken = config('shiprocket.api_token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
        ])->get("{$baseUrl}/courier/track/awb/{$awb_code}", );



        if ($response->successful()) {
            $this->tracking = (object) $response->json()['data'];  // Directly accessing the 'data' key
        } else {
            $this->tracking = null;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        return view('components.shippingdetails', [
            'tracking' => $this->tracking
        ]);
    }
}