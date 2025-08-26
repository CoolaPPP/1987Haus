<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

class CheckoutController extends Controller
{
    public function addressForm()
    {
        $addresses = Auth::user()->shippingAddresses;
        return view('checkout.address', compact('addresses'));
    }

    public function storeAddress(Request $request)
    {
        $request->validate(['shippingaddress_id' => 'required|exists:shipping_addresses,id']);
        session()->put('checkout_address_id', $request->shippingaddress_id);
        return redirect()->route('checkout.place-order-form'); 
    }

    public function placeOrder(Request $request)
    {
        $cart = session('cart');
        $promo = session('promo');
        $address_id = $request->input('shippingaddress_id'); 

        if (!$cart || !$address_id) {
            return redirect()->route('cart.index')->with('error', 'ตะกร้าสินค้าของคุณว่างเปล่าหรือคุณไม่ได้เลือกที่อยู่จัดส่ง');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $discount = $promo['discount'] ?? 0;
        $netTotal = $subtotal - $discount;

        // --- เริ่ม Transaction ---
        $order = DB::transaction(function () use ($cart, $promo, $address_id, $subtotal, $netTotal, $request) {
            // 1. สร้าง Order
            $order = Order::create([
                'customer_id' => Auth::id(),
                'shippingaddress_id' => $address_id,
                'order_status_id' => 1, 
                'promotion_id' => $promo['id'] ?? null,
                'order_price' => $subtotal,
                'net_price' => $netTotal,
                'order_note' => $request->input('order_note'), // อาจจะต้องส่งมาจากฟอร์มก่อนหน้า
            ]);

            // 2. สร้าง Order Details
            foreach ($cart as $product_id => $details) {
                $order->details()->create([
                    'product_id' => $product_id,
                    'product_price' => $details['price'],
                    'quantity' => $details['quantity'],
                    'total_price' => $details['price'] * $details['quantity'],
                ]);
            }
            return $order;
        });
        session()->forget(['cart', 'promo', 'checkout_address_id']);

        return redirect()->route('order.complete', $order->id);
    }

    public function complete(Order $order)
    {
        return view('checkout.complete', compact('order'));
    }
}