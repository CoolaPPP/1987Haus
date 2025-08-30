<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderCancel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderCancelController extends Controller
{
    public function selectOrder()
    {
        $unpaidOrders = Order::where('customer_id', Auth::id())
            ->where('order_status_id', 1) // 1 = สั่งสำเร็จ (ยังไม่จ่ายเงิน)
            ->get();
        return view('customer.cancels.select', compact('unpaidOrders'));
    }

    public function confirm(Request $request)
    {
        $order = Order::with('details.product')->findOrFail($request->order_id);
        abort_if($order->customer_id !== Auth::id() || $order->order_status_id != 1, 403);
        return view('customer.cancels.confirm', compact('order'));
    }

    public function destroy(Order $order)
    {
        abort_if($order->customer_id !== Auth::id() || $order->order_status_id != 1, 403);

        DB::transaction(function () use ($order) {
            $cancellation = OrderCancel::create([
                'customer_id' => $order->customer_id,
                'order_id' => $order->id,
                'cancel_price' => $order->order_price,
                'cancel_datetime' => now(),
            ]);
            foreach ($order->details as $detail) {
                $cancellation->details()->create([
                    'product_id' => $detail->product_id,
                    'product_price' => $detail->product_price,
                    'quantity' => $detail->quantity,
                    'total_price' => $detail->total_price,
                ]);
            }
            $order->update(['order_status_id' => 4]);
        });

        return redirect()->route('customer.dashboard')->with('success', 'การสั่ง #' . $order->id . ' ถูกยกเลิกแล้ว');
    }
}