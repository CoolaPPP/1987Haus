<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderConfirm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //new orders
    public function index()
    {
        $newOrders = Order::whereIn('order_status_id', [2,6])
            ->with('customer','payment')
            ->latest('order_datetime')
            ->paginate(15);
            
        return view('admin.orders.index', compact('newOrders'));
    }

    //shipping
    public function shipping()
    {
        $shippingOrders = Order::where('order_status_id', 3)
            ->with('customer')
            ->latest('updated_at')
            ->paginate(15);
            
        return view('admin.orders.shipping', compact('shippingOrders'));
    }
    
    //successful delivery
    public function delivered()
    {
        $deliveredOrders = Order::where('order_status_id', 5)
            ->with('customer')
            ->latest('updated_at')
            ->paginate(15);

        return view('admin.orders.delivered', compact('deliveredOrders'));
    }

    // public function canceled()
    // {
    //     $canceledOrders = Order::where('order_status_id', 4)
    //         ->with('customer')
    //         ->latest('updated_at')
    //         ->paginate(15);
            
    //     return view('admin.orders.canceled', compact('canceledOrders'));
    // }

    public function show(Order $order)
    {
        $order->load(['customer', 'shippingAddress', 'promotion', 'details.product', 'payment', 'confirmation','cancellation']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * แสดงหน้าใบเสร็จตัวอย่าง (Preview)
     */
    public function showReceipt(Order $order)
    {
        $owner = Auth::guard('admin')->user();
        $order->load(['customer', 'shippingAddress', 'promotion', 'details.product']);
        return view('admin.orders.receipt', compact('order', 'owner'));
    }

    public function updateStatus(Order $order)
    {
        if ($order->order_status_id < 3) {
            $order->update(['order_status_id' => 3]);
        }
        return response()->json(['success' => true, 'redirect_url' => route('admin.orders.new')]);
    }

    //Order Confirmation
    public function confirmations()
    {
        $confirmations = OrderConfirm::with(['customer', 'payment.order'])->latest()->paginate(15);
        return view('admin.order_confirms.index', compact('confirmations'));
    }

    public function prepare(Order $order)
    {
        // อัปเดตสถานะเฉพาะเมื่อสถานะปัจจุบันคือ "ชำระเงินสำเร็จ"
        if ($order->order_status_id == 2) {
            $order->update(['order_status_id' => 6]);
            return back()->with('success', 'การสั่งนี้กำลังจัดเตรียม".');
        }
        return back()->with('error', 'การสั่งนี้ไม่สามารถจัดเตรียมได้ในสถานะปัจจุบัน.');
    }
}