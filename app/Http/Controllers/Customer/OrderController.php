<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function showReceipt(Order $order)
    {
        abort_if($order->customer_id !== Auth::id(), 403);

        $order->load(['details.product', 'shippingAddress', 'payment']);

        return view('customer.orders.receipt', compact('order'));
    }
}