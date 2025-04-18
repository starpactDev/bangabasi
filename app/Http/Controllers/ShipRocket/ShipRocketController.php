<?php

namespace App\Http\Controllers\ShipRocket;

use Illuminate\Http\Request;
use App\Services\ShiprocketAPI;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ShipRocketController extends Controller
{
    public function serviceAbility(Request $request, ShiprocketAPI $shiprocketAPI){

        // Validate the incoming request data
        $validatedData = $request->validate([
            'pickup_postcode' => 'required|numeric|digits:6', // Validate that pickup_postcode is numeric and 6 digits long
            'delivery_postcode' => 'required|numeric|digits:6', // Validate that delivery_postcode is numeric and 6 digits long
        ]);

        try {
            // Define the request parameters using the validated data
            $queryParams = [
                'pickup_postcode' => $validatedData['pickup_postcode'],
                'delivery_postcode' => $validatedData['delivery_postcode'],
                'cod' => 1, // Set to 1 for COD serviceability check
                'weight' => 1, 
            ];

            // Make the API call
            $response = $shiprocketAPI->request('get', "/courier/serviceability/", $queryParams);
    
            // Return the full API response as JSON
            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json([
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function fetchOrder(ShiprocketAPI $shiprocketAPI)
    {
        $orderId = 748247766; // Hardcoded for now, can be dynamic if needed
    
        $response = $shiprocketAPI->request('get', "/orders/show/{$orderId}");
    
        return response()->json($response->json());
    }
    public function fetchShipment(){
        $baseUrl = config('shiprocket.base_url');
        $apiToken = config('shiprocket.api_token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
        ])->get("{$baseUrl}/shipments/744763526 ", );

        return $response->json();


    }

    public function fetchTracking(){
        $baseUrl = config('shiprocket.base_url');
        $apiToken = config('shiprocket.api_token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
        ])->get("{$baseUrl}/courier/track/awb/788830567028", );

        return $response->json();


    }
}
