<?php

namespace App\Http\Controllers;

use App\Models\IstantBuy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstantBuyController extends Controller
{
    public function store(Request $request)
    {
        $products = $request->input('products');

        foreach ($products as $product) {
            IstantBuy::updateOrCreate(
                [
                    'user_id' => Auth::user()->id,
                    'product_id' => $product['id'],
                ],
                [
                    'sku' => $product['size'],
                    'quantity' => $product['quantity'],
                ]
            );
        }

        return response()->json(['message' => 'Products added successfully']);
    }
}
