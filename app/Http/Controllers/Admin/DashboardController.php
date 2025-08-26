<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $newOrdersCount = Order::where('order_status_id', 2)->count();
        
        return view('admin.dashboard');
    }
}