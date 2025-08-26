<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderCancel;
use Illuminate\Http\Request;

class OrderCancelController extends Controller
{
    public function index()
    {
        $cancellations = OrderCancel::with(['customer', 'order'])
            ->latest('cancel_datetime')
            ->paginate(15);
            
        return view('admin.order_cancels.index', compact('cancellations'));
    }

    public function show(OrderCancel $orderCancel)
    {
        $orderCancel->load('details.product');
        return view('admin.order_cancels.show', compact('orderCancel'));
    }
}