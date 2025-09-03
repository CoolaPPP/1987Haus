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
        $cart = session('cart', []);
        return view('checkout.address', compact('addresses','cart'));
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
            return redirect()->route('cart.index')
                ->with('error', 'ตะกร้าสินค้าของคุณว่างเปล่าหรือคุณไม่ได้เลือกที่อยู่จัดส่ง');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $discount = $promo['discount'] ?? 0;
        $netTotal = $subtotal - $discount;

        // ✅ สร้างข้อความ order_note ที่รวมคั่ว/ความหวาน
        $note = "";
        if ($request->has('items')) {
            foreach ($request->items as $productIndex => $cups) {
                foreach ($cups as $cupIndex => $cup) {
                    // ดึงชื่อสินค้าในตะกร้า
                    $productName = $cart[$productIndex]['name'] ?? 'สินค้า';
                    
                    $note .= $productName . " แก้วที่ " . $cupIndex;

                    if (isset($cup['roast'])) {
                        $note .= " - " . $cup['roast'];
                    }
                    if (isset($cup['sweetness'])) {
                        $note .= " - " . $cup['sweetness'];
                    }
                    $note .= "\n";
                }
            }
        }

        // รวมกับข้อความเพิ่มเติมจากลูกค้า
        if ($request->order_note) {
            $note .= "--- ข้อความเพิ่มเติม ---\n" . $request->order_note;
        }

        // --- เริ่ม Transaction ---
        $order = DB::transaction(function () use ($cart, $promo, $address_id, $subtotal, $netTotal, $note) {
            // 1. สร้าง Order
            $order = Order::create([
                'customer_id' => Auth::id(),
                'shippingaddress_id' => $address_id,
                'order_status_id' => 1, 
                'promotion_id' => $promo['id'] ?? null,
                'order_price' => $subtotal,
                'net_price' => $netTotal,
                'order_note' => $note, // ✅ บันทึก note ที่รวมรายละเอียดแก้วด้วย
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