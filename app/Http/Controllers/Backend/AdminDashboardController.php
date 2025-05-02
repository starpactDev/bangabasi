<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Bank;
use App\Models\User;
use App\Models\Order;
use App\Models\Seller;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\PickupAddress;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        $userCount = User::where('usertype', 'user')->count();

        $orderCount = Order::count();

        $totalSales = Order::sum('price');

        $purchasedProducts = OrderItem::with('product')->select('product_id', DB::raw('COUNT(*) as purchase_count'))
            ->groupBy('product_id') // Group by product
            ->orderBy('purchase_count', 'DESC') // Order by count
            ->take(3)
            ->get();


        $usersWithSalesAndPrice = Order::with('user') // Load user details from the Order model
        ->get()
        ->groupBy('user_id') // Group orders by user_id
        ->map(function ($orders, $userId) {
            // Compute the sales count for each user
            $salesCount = OrderItem::whereIn('order_id', $orders->pluck('id'))->count();
    
            // Compute the total price for this user
            $totalPrice = $orders->sum('price');
    
            // Get user details (from the first order, as all belong to the same user)
            $user = $orders->first()->user;
    
            // Add the computed sales count and total price as properties
            $user->sales = $salesCount;
            $user->total_price = $totalPrice;
    
            return $user;
        });

        $sellerCount = User::where('usertype', 'seller')->count();

        $newSellers = User::where('usertype', 'seller')->orderBy('created_at', 'DESC')->take(5)->get();

        foreach ($newSellers as $seller) {
            $seller->total_products = Product::where('user_id', $seller->id)->count();

            $seller->total_sales = OrderItem::whereIn('product_id', Product::where('user_id', $seller->id)->pluck('id'))->count();

            // Calculate the total sales price for the seller
            $totalSalePrice = OrderItem::whereIn('product_id', Product::where('user_id', $seller->id)->pluck('id'))
            ->get() // Get all the order items for the seller's products
            ->sum(function ($orderItem) {
                return $orderItem->quantity * $orderItem->unit_price; // Multiply quantity and unit_price for each order item
            });

            $seller->total_sale_price = $totalSalePrice;
        }

        $orders = Order::all();
        $orderItems = OrderItem::with('order')->take(5)->get();


        // Step 1: Define the date range (you can adjust start & end as needed)
        $startDate = Carbon::parse('2025-04-01');
        $endDate = Carbon::now();

        $allDates = collect();
        for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
            $allDates->push($date->toDateString());
        }

        // Step 2: Fetch sales grouped by date
        $orders = Order::selectRaw('DATE(created_at) as date, SUM(price) as total_sales')
            ->groupByRaw('DATE(created_at)')
            ->pluck('total_sales', 'date'); // returns [ '2024-01-01' => 100, '2024-01-02' => 0, ... ]

        // Step 3: Merge with full date range, fill missing with 0
        $salesByDate = $allDates->mapWithKeys(function ($date) use ($orders) {
            return [$date => $orders->get($date, 0)];
        })->reverse();


        return view('admin.pages.dashboard', compact('userCount', 'orderCount', 'totalSales', 'purchasedProducts', 'usersWithSalesAndPrice', 'sellerCount', 'newSellers',  'orders', 'orderItems', 'salesByDate'));
    }

    
    public function profile()
    {
        $user = Auth::user();
    
        $bank = null;
        $gst = null;
        $pickupAddress = null;
    
        if ($user->usertype === 'seller') {
            $seller = Seller::with(['bank', 'gstDetail', 'pickupAddress'])->where('user_id', $user->id)->first();
    
            $bank = $seller->bank;
            $gst = $seller->gstDetail;
            $pickupAddress = $seller->pickupAddress;
        }

        return view('superuser.profile.profile', compact('user', 'bank', 'gst', 'pickupAddress'));
    }
    
    
    public function updateProfile(Request $request)
    {
       
        $user = Auth::user();

        // Validate inputs
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'contact_number' => 'nullable|string|max:20',
            'phone_number' => 'nullable|string|max:20',

            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        // Update user details
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->contact_number = $request->contact_number;
        $user->phone_number = $request->phone_number;

        

        // Update store details
        $sellers = Seller::where('user_id',$user->id)->first();
        $sellers->store_name = $request->store_name;
        $sellers->email = $request->seller_email;
        $sellers->description = $request->description;
        

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoName = time() . '.' . $request->logo->extension();
            $request->logo->move(public_path('user/uploads/store_logo'), $logoName);
            $sellers->logo = $logoName;
        }

        $sellers->save();
        $bank = Bank::where('user_id',$user->id)->first();

        // Update bank details
        if ($request->filled('bank_name')) {
            $bank->bank_name = $request->bank_name;
        }
        if ($request->filled('branch_name')) {
            $bank->branch_name = $request->branch_name;
        }
        if ($request->filled('ifsc_code')) {
            $bank->ifsc_code = $request->ifsc_code;
        }
        if ($request->filled('account_number')) {
            $bank->account_number = $request->account_number;
        }
        if ($request->filled('account_holder_name')) {
            $bank->account_holder_name = $request->account_holder_name;
        }

        $bank->save();

        $address = PickupAddress::where('user_id',$user->id)->first();
         // Update pickup address
         if ($request->filled('building')) {
            $address->building = $request->building;
        }
        if ($request->filled('street')) {
            $address->street = $request->street;
        }
        if ($request->filled('locality')) {
            $address->locality = $request->locality;
        }
        if ($request->filled('landmark')) {
            $address->landmark = $request->landmark;
        }
        if ($request->filled('pincode')) {
            $address->pincode = $request->pincode;
        }
        if ($request->filled('city')) {
            $address->city = $request->city;
        }
        if ($request->filled('state')) {
            $address->state = $request->state;
        }

        $address->save();


        // Check if the old password is provided and matches
        if ($request->filled('old_password') && Hash::check($request->old_password, $user->password)) {
            // Update password

            $user->password = Hash::make($request->new_password);
        } elseif ($request->filled('new_password')) {
            // If old password is incorrect
            return response()->json(['success' => false, 'message' => 'Old password does not match.']);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('user/uploads/profile'), $imageName);
            $user->image = $imageName;
        }

        $user->save();

        return response()->json(['success' => true, 'message' => 'Profile updated successfully!']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flash('logout_message', 'You have been logged out successfully.');
        return redirect()->route('admin_login');
    }
}
