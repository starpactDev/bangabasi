<?php

namespace App\Http\Controllers\Seller;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerOrderController extends Controller
{
    public function transaction()
    {
        $transactions = Order::all();
        return view('admin.pages.transaction.index', compact('transactions'));
    }
}
