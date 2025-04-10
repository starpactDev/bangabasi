<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Product;
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
        return view('admin.pages.dashboard', compact('userCount', 'orderCount', 'totalSales', 'purchasedProducts', 'usersWithSalesAndPrice', 'sellerCount', 'newSellers',  'orders', 'orderItems'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('superuser.profile.profile', compact('user'));
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
