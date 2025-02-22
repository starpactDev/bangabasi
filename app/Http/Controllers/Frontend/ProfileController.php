<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $saved_address = UserAddress::where('user_id', Auth::user()->id)->get();
        return view('myprofile', compact('saved_address'));
    }

    public function address_edit($id)
    {
        $address = UserAddress::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $address
        ]);
    }
  // Method to update an existing address
  public function address_update(Request $request, $id)
  {
      // Validation (same as store)
      $validator = Validator::make($request->all(), [
          'first_name' => 'required|string|max:255',
          'last_name' => 'required|string|max:255',
          'country' => 'required|string|max:255',
          'street_name' => 'required|string|max:255',
          'apartment' => 'nullable|string|max:255',
          'city' => 'required|string|max:255',
          'state' => 'required|string|max:255',
          'phone' => 'required|digits_between:10,15',
          'postcode' => 'required|numeric',
          'email' => 'required|email',
      ]);

      // If validation fails, return errors
      if ($validator->fails()) {
          return response()->json(['errors' => $validator->errors()], 422);
      }

      // Find the address by ID
      $address = UserAddress::findOrFail($id);

      // Update the address with the new data
      $address->update([
          'firstname' => $request->first_name,
          'lastname' => $request->last_name,
          'country' => $request->country,
          'street_name' => $request->street_name,
          'apartment' => $request->apartment,
          'city' => $request->city,
          'state' => $request->state,
          'phone' => $request->phone,
          'pin' => $request->postcode,
          'email' => $request->email,
      ]);

      return response()->json(['success' => true, 'message' => 'Address updated successfully.']);
  }
    public function address_store(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'street_name' => 'required|string|max:255',
            'apartment' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'postcode' => 'required|numeric',
            'email' => 'required|email|max:255',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Create a new address
        $address = new UserAddress();
        $address->user_id = Auth::user()->id;
        $address->firstname = $request->input('first_name');
        $address->lastname = $request->input('last_name');
        $address->country = $request->input('country');
        $address->street_name = $request->input('street_name');
        $address->apartment = $request->input('apartment');
        $address->city = $request->input('city');
        $address->phone = $request->input('phone');
        $address->state = $request->input('state');
        $address->pin = $request->input('postcode');
        $address->email = $request->input('email');
        $address->save();

        // Return success response
        return response()->json(['success' => true]);
    }


    public function address_destroy($id)
    {

        $address = UserAddress::find($id);

        if ($address) {

            $address->delete();
            return response()->json(['success' => 'Address deleted successfully']);
        } else {
            return response()->json(['error' => 'Address not found'], 404);
        }

    }
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validate inputs
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'contact_number' => 'nullable|string|max:20,',
            'phone_number' => 'nullable|string|max:10|unique:users,phone_number,' . $user->id,

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
            if ($request->old_password === $request->new_password) {
                return response()->json(['success' => false, 'message' => 'New password cannot be the same as the old password.']);
            }
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
}
