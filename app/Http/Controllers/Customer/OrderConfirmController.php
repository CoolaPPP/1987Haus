<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderConfirm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderConfirmController extends Controller
{
    public function create(Order $order)
    {
        abort_if($order->customer_id !== Auth::id(), 403);
        abort_if($order->order_status_id != 3, 403, 'การสั่งซื้อนี้ไม่อยู่ในสถานะที่สามารถยืนยันการรับสินค้าได้!');
        
        $paymentTime = Carbon::parse($order->payment->payment_datetime);
        $confirmAvailableAt = $paymentTime->copy()->addMinutes(10);
        $canConfirm = now()->gte($confirmAvailableAt);

        return view('customer.confirms.create', [
            'order' => $order,
            'canConfirm' => $canConfirm,
            'confirmAvailableAt' => $confirmAvailableAt->format('d M Y, H:i:s'),
        ]);
    }

    public function store(Request $request, Order $order)
    {
        abort_if($order->customer_id !== Auth::id(), 403);
        
        // ตรวจสอบเงื่อนไขเวลาฝั่ง Server อีกครั้ง
        $paymentTime = Carbon::parse($order->payment->payment_datetime);
        if ($paymentTime->addMinutes(10)->isFuture()) {
            return back()->with('error', 'สามารถยืนยันรับสินค้าได้หลังจากชำระเงิน 10 นาที');
        }

        $request->validate(['orderconfirmed_status' => 'required|integer|in:1,2,3']);

        DB::transaction(function () use ($request, $order) {
            OrderConfirm::create([
                'payment_id' => $order->payment->id,
                'customer_id' => Auth::id(),
                'orderconfirmed_status' => $request->orderconfirmed_status,
                'orderconfirm_datetime' => now(),
            ]);
            $order->update(['order_status_id' => 5]);
        });

        return redirect()->route('customer.dashboard')->with('success', 'ขอบคุณสำหรับการยืนยันการรับสินค้า!');
    }
}