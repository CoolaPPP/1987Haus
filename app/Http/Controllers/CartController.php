<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request, Product $product)
    {
        $quantity = $request->input('quantity', 1);
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                "name" => $product->product_name,
                "quantity" => $quantity,
                "price" => $product->product_price,
                "pic" => $product->product_pic,
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'สินค้าได้ถูกเพิ่มลงในตะกร้าเรียบร้อยแล้ว!');
    }

    public function index()
    {
        return view('cart.index');
    }

    public function update(Request $request, Product $product)
    {
        $cart = session()->get('cart');
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return back()->with('success', 'อัปเดตจำนวนสินค้าในตะกร้าเรียบร้อยแล้ว!');
        }
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart');
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
            return back()->with('success', 'สินค้าได้ถูกลบออกจากตะกร้าเรียบร้อยแล้ว!');
        }
    }

    public function applyPromo(Request $request)
    {
        $promoCode = $request->input('promo_code');
        if (!$promoCode) {
            return back(); // ถ้าไม่มีการกรอกโค้ด ก็กลับไปเฉยๆ
        }

        // 1. หาโปรโมชันด้วยรหัสก่อน
        $promo = Promotion::find($promoCode);

        // 2. ตรวจสอบเงื่อนไขต่างๆ
        if (!$promo) {
            // กรณี: ไม่พบรหัสโปรโมชันนี้ในระบบ
            return back()->with('alert-message', 'ไม่พบรหัสโปรโมชันนี้');
        }

        $today = now()->startOfDay(); // ใช้วันที่ปัจจุบันโดยไม่นับเวลา

        if ($today->lt($promo->promotion_start)) {
            // กรณี: โปรโมชันยังไม่เริ่ม
            return back()->with('alert-message', 'โปรโมชันนี้ยังไม่ถึงวันที่สามารถใช้ได้');
        }

        if ($today->gt($promo->promotion_end)) {
            // กรณี: โปรโมชันหมดอายุแล้ว
            return back()->with('alert-message', 'โปรโมชันนี้หมดอายุแล้ว');
        }

        // 3. หากทุกอย่างถูกต้อง
        session()->put('promo', [
            'id' => $promo->id,
            'discount' => $promo->promotion_discount
        ]);

        return back()->with('alert-message', 'ใช้โปรโมชันสำเร็จ!');
    }
}