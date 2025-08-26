<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderStatus;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    public function index()
    {
        $statuses = OrderStatus::latest()->get();
        return view('admin.order_statuses.index', compact('statuses'));
    }

    public function create()
    {
        return view('admin.order_statuses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'orderstatus_name' => 'required|string|max:255|unique:order_statuses',
        ]);
        OrderStatus::create($request->all());
        return redirect()->route('admin.order-statuses.index')->with('success', 'Order status created successfully.');
    }

    public function edit(OrderStatus $orderStatus)
    {
        return view('admin.order_statuses.edit', compact('orderStatus'));
    }

    public function update(Request $request, OrderStatus $orderStatus)
    {
        $request->validate([
            'orderstatus_name' => 'required|string|max:255|unique:order_statuses,orderstatus_name,' . $orderStatus->id,
        ]);
        $orderStatus->update($request->all());
        return redirect()->route('admin.order-statuses.index')->with('success', 'Order status updated successfully.');
    }

    public function destroy(OrderStatus $orderStatus)
    {
        $orderStatus->delete();
        return back()->with('success', 'Order status deleted successfully.');
    }
}