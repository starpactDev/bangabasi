<?php

namespace App\Http\Controllers\SuperUser;

use App\Models\User;
use App\Models\Order;

use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\OrderResponse;
use App\Models\PickupAddress;
use App\Services\ShiprocketAPI;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Support\ValidatedData;

class SuperUserOrderController extends Controller
{
    public function myOrders(){

        $user = Auth::user();

        $orderItems = OrderItem::with('order', 'product') // Eager load both 'order' and 'product' relationships
        ->whereHas('product', function ($query) use ($user) { // Pass $user into the closure
            $query->where('user_id', $user->id); 
        })
        ->latest()->get();
            
        return view('superuser.orders.index', compact('orderItems'));
    }



    public function shipRocketlogin() {
        $response = Http::post('https://apiv2.shiprocket.in/v1/external/auth/login', [
            'email' => 'developers.starpact@gmail.com',
            'password' => 'Bangabasi@com$24',
        ]);
        
        if ($response->successful()) {
            $apiToken = $response->json('token');
            // Save this token to your .env file or database for future use
            return $apiToken;
        } else {
            return $response->json();
        }
    }

    public function show($id) {
        $user = Auth::user();

        // Fetch the order item and associated order with address using the passed $id
        $orderItem = OrderItem::with('order.address') // Eager load the associated order and address
            ->findOrFail($id); // Find the order item by its ID
        $productData = Product::whereHas('orderItems', function ($query) use ($id) {
            $query->where('id', $id); // Filter order_item by the passed order_item ID
        })
        ->with('productImages') // Eager load the productImages relationship
        ->first(); // Retrieve the first matching product

        //dd($productData->productImages[0]->image);

        $order = $orderItem->order; // Get the associated order
        $address = $order->address; // Get the associated address from the order

        $user = User::where('id', $order->user_id)->first();
        
        // Fetch the pickup pin code for the logged-in user
        $pickupPinCode = PickupAddress::where('user_id', $user->id)->value('pincode');

        // Get the delivery pin code from the order's address
        $deliveryPinCode = $address->pin;

        // Determine the payment method (assuming 'payment_method' is a column in the order)
        $paymentMethod = $order->payment_method;

        // Send request to Shiprocket API to check service availability
        $baseUrl = config('shiprocket.base_url');
        $apiToken = config('shiprocket.api_token');

        $orderResponse = [];

        if($orderItem->status > 0) {
            $orderResponse = OrderResponse::where('order_item_id', $orderItem->id)->first();

            if($orderResponse){    
                $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $apiToken,
                    ])->get("{$baseUrl}/orders/show/{$orderResponse->order_id}", );
                    
                if($response->successful()) {
                    $orderResponse = json_decode($response->body());
                    $orderResponse = $orderResponse->data;
                    $orderResponse->order_item_id = $orderItem->id;

                    $orderResponseRecord = OrderResponse::where('order_item_id', $orderItem->id)->first();

                    if ($orderResponseRecord) {
                        // Update the fields from the API response
                        $orderResponseRecord->shipment_id = $orderResponse->shipments->id ?? null; // If shipment_id is null in response, set it to null
                        $orderResponseRecord->status = $orderResponse->status;
                        $orderResponseRecord->status_code = $orderResponse->status_code;
                        $orderResponseRecord->awb_code = $orderResponse->lshipments->awb ?? null; // Set AWB to null if it's not available
                        $orderResponseRecord->courier_company_id = $orderResponse->shipments->courier_id ?? null; // Set courier name as company id or null
                        $orderResponseRecord->courier_name = $orderResponse->shipments->courier ?? null;
                
                        // Set the updated_at field to the current time (optional, if you want to update it)
                        $orderResponseRecord->updated_at = $orderResponse->updated_at;
                
                        // Save the changes to the database
                        $orderResponseRecord->save();
                    }
                }
            }
            
        }


        // Return the order details along with the serviceability check
        return view('superuser.orders.status', compact( 'orderItem','order', 'user', 'productData', 'address', 'orderResponse'));
    }

    public function initiateOrder(Request $request) {

        $validatedData = $request->validate([
            'order_id' => 'required|string',
            'orderItem_id' => 'required|integer',
            'product_id' => 'required|integer',

            'length' => 'required|numeric|min:0.5',
            'breadth' => 'required|numeric|min:0.5',
            'height' => 'required|numeric|min:0.5',
            'weight' => 'required|numeric|min:0.1',
        ]);
    
        // Retrieve the specific order item for the given product and order
        $orderItem = OrderItem::with(['order.address'])
            ->where('id', $validatedData['orderItem_id']) // Match the orderItem ID
            ->where('product_id', $validatedData['product_id']) // Match the product ID
            ->whereHas('order', function ($query) use ($validatedData) {
                $query->where('unique_id', $validatedData['order_id']); // Match the order ID
            })->first(); // Get a single row


        if (!$orderItem) { // Check if no orderItem is found
            return response()->json([
                'success' => false,
                'message' => 'Order or item not found.',
            ]);
        }

        $order = $orderItem->order; // Access the related order
        $address = $order->address;


        // Prepare Shiprocket Order Data
        $shiprocketOrderData = [
            "order_id" =>  $order->unique_id . '-' . $orderItem->product_id,
            "order_date" => $order->created_at->format('Y-m-d H:i'),
            "pickup_location" => "Primary", // Static for now
            "billing_customer_name" => $address->firstname,
            "billing_last_name" => $address->lastname,
            "billing_address" => $address->street_name,
            "billing_address_2" => $address->apartment,
            "billing_city" => $address->city,
            "billing_pincode" => $address->pin,
            "billing_state" => $address->state,
            "billing_country" => $address->country,
            "billing_email" => $address->email,
            "billing_phone" => $address->phone,
            "shipping_is_billing" => true,
            "order_items" => [
                [
                    "name" => $orderItem->product->name,        // Assuming relationship with Product
                    "sku" => $orderItem->sku,                  // SKU from OrderItem
                    "units" => $orderItem->quantity,           // Quantity from OrderItem
                    "selling_price" => $orderItem->unit_price, // Price from OrderItem
                    "hsn" => $orderItem->product->hsn ?? '0000', // Assuming HSN is available in Product
                ],
            ],
            "payment_method" => $order->payment_method,
            "shipping_charges" => 50,  // Example shipping charges
            "sub_total" => $orderItem->unit_price, // Single item's unit price
            "length" => $validatedData['length'], 
            "breadth" => $validatedData['breadth'], 
            "height" => $validatedData['height'],
            "weight" => $validatedData['weight'], 
            "courier_company_id" => "10", // Example courier company ID
        ];

        try {
            // Send API request to Shiprocket
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . env('SHIPROCKET_API_TOKEN'),
            ])->post(env('SHIPROCKET_API_BASE_URL') . '/orders/create/adhoc', $shiprocketOrderData);
    
            // Check the response
            if ($response->successful()) {
                $responseData = $response->json();
                
                // Store the response in the order_responses table
                OrderResponse::create([
                    'order_id' => $responseData['order_id'] ?? $shiprocketOrderData['order_id'],
                    'order_item_id' => $orderItem->id,
                    'channel_order_id' => $responseData['channel_order_id'] ?? $shiprocketOrderData['order_id'],
                    'shipment_id' => $responseData['shipment_id'] ?? null,
                    'status' => $responseData['status'] ?? 'unknown',
                    'status_code' => $responseData['status_code'] ?? 0,
                    'onboarding_completed_now' => $responseData['onboarding_completed_now'] ?? false,
                    'awb_code' => $responseData['awb_code'] ?? null,
                    'courier_company_id' => $responseData['courier_company_id'] ?? null,
                    'courier_name' => $responseData['courier_name'] ?? null,
                    'new_channel' => $responseData['new_channel'] ?? false,
                    'packaging_box_error' => $responseData['packaging_box_error'] ?? null,
                ]);

                OrderItem::where('id', $validatedData['orderItem_id'])
                    ->update([
                        'status' => $responseData['status_code'],
                        'order_status' => 'initiated', // You can map status_code to a meaningful order_status
                    ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Order created successfully in Shiprocket.',
                    'data' => $response->json(),
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create order in Shiprocket.',
                    'data' => $response->json(),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ]);
        }

        // Return everything with dd() for debugging
        return response()->json([
            'success' => true,
            'message' => 'Order retrieved successfully.',
            'data' => [
                'shiprocketOrderData' => $shiprocketOrderData,
                'orderItem' => $orderItem
            ],
        ]);
    }

    public function shiprocketShowOrder(Request $request, ShiprocketAPI $shiprocketAPI) {

        // Validate input
        $validated = $request->validate([
            'order_id' => 'required|string', // Ensure the order_id is provided
        ]);


        try {
            $response = $shiprocketAPI->request('get', "/orders/show/{$validated['order_id']}");

            // Check if the response is successful
            if ($response->successful()) {
                // Parse the response
                $orderDetails = $response->json();

                // Return the order details as JSON response
                return response()->json([
                    'success' => true,
                    'order_details' => $orderDetails,
                ]);
            } else {
                // Handle API errors
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to fetch order details from Shiprocket.',
                    'error' => $response->body(),
                ], $response->status());
            }
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching order details.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
           
    public function createAdHocOrder() {
        $orderData = [
            "order_id" => "ORD-1010",
            "pickup_location" => "Primary",
            "billing_customer_name" => "John",
            "billing_last_name" => "Doe",
            "billing_address" => "123 Main Street",
            "billing_address_2" => "Near Park",
            "billing_city" => "Bishnupur",
            "billing_pincode" => "722122",
            "billing_state" => "West Bengal",
            "billing_country" => "India",
            "billing_email" => "johndoe@example.com",
            "billing_phone" => "9876543210",
            "order_items" => [
                [
                    "name" => "Product 1",
                    "sku" => "PROD123",
                    "units" => 2,
                    "selling_price" => 500,
                    "hsn" => 123456,
                ],
            ],
            "payment_method" => "Prepaid",
            "shipping_charges" => 50,
            "sub_total" => 1000,
            "length" => 10,
            "breadth" => 10,
            "height" => 5,
            "weight" => 1.5,
            "courier_id"=> 4
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . env('SHIPROCKET_API_TOKEN'),
            ])->post(env('SHIPROCKET_API_BASE_URL') . '/orders/create/adhoc', [
                "order_id" => $orderData['order_id'],
                "order_date" => now()->format('Y-m-d H:i'),
                "pickup_location" => $orderData['pickup_location'],
                "billing_customer_name" => $orderData['billing_customer_name'],
                "billing_last_name" => $orderData['billing_last_name'],
                "billing_address" => $orderData['billing_address'],
                "billing_address_2" => $orderData['billing_address_2'] ?? '',
                "billing_city" => $orderData['billing_city'],
                "billing_pincode" => $orderData['billing_pincode'],
                "billing_state" => $orderData['billing_state'],
                "billing_country" => $orderData['billing_country'],
                "billing_email" => $orderData['billing_email'],
                "billing_phone" => $orderData['billing_phone'],
                "shipping_is_billing" => true,
                "order_items" => $orderData['order_items'],
                "payment_method" => $orderData['payment_method'],
                "shipping_charges" => $orderData['shipping_charges'],
                "giftwrap_charges" => $orderData['giftwrap_charges'] ?? 0,
                "transaction_charges" => $orderData['transaction_charges'] ?? 0,
                "total_discount" => $orderData['total_discount'] ?? 0,
                "sub_total" => $orderData['sub_total'],
                "length" => $orderData['length'],
                "breadth" => $orderData['breadth'],
                "height" => $orderData['height'],
                "weight" => $orderData['weight'],
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            return [
                'success' => false,
                'message' => $response->json()['message'] ?? 'Something went wrong!',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function submitPrimaryLocation(Request $request)
    {
        // Fetch Shiprocket API configuration
        $baseUrl = config('shiprocket.base_url');
        $apiToken = config('shiprocket.api_token');

        // Define the primary location details
        $pickupLocationData = [
            "pickup_location" => "PrimaryLocation", // Unique identifier for the location
            "name" => "Arnal Das",
            "email" => "arnal.kol@gmail.com",
            "phone" => "6297735948",
            "address" => "Balgona, Mirepara",
            "city" => "Purba Bardhaman",
            "state" => "West Bengal",
            "country" => "India",
            "pin_code" => "713125",
        ];

        // Make the API request to add the pickup location
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
        ])->post("{$baseUrl}/settings/company/addpickup", $pickupLocationData);

        // Handle the response
        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'message' => 'Primary location submitted successfully!',
                'data' => $response->json(),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit the primary location.',
                'error' => $response->json(),
            ], $response->status());
        }
    }
    public function fetchPickupLocations()
    {
        // Fetch Shiprocket API configuration
        $baseUrl = config('shiprocket.base_url');
        $apiToken = config('shiprocket.api_token');
    
        try {
            // Make the API request to fetch pickup locations
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiToken,
            ])->get("{$baseUrl}/settings/company/pickup");
    
            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pickup locations fetched successfully!',
                    'data' => $response->json(),
                ]);
            }
    
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch pickup locations.',
                'error' => $response->json(),
            ], $response->status());
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching pickup locations.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}