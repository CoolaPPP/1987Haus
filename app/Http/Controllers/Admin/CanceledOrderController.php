<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class CanceledOrderController extends Controller
{
    public function index()
    {
        $canceledOrders = Order::where('order_status_id', 4)
            ->with('customer')
            ->latest('updated_at')
            ->paginate(15);
            
        return view('admin.canceled_orders.index', compact('canceledOrders'));
    }
}