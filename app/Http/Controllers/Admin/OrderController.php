<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function orders() {
        $orders = Order::where('status', 1)->get();
        return view('auth.orders.orders', compact('orders'));
    }
}
