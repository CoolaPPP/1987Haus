<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function create()
    {
        return view('customer.addresses.create');
    }

    public function store(Request $request)
    {
        $request->validate(['address' => 'required|string']);
        
        Auth::user()->shippingAddresses()->create($request->all());
        
        return redirect()->route('customer.dashboard')->with('success', 'เพิ่มข้อมูลที่อยู่สำหรับจัดส่งสินค้าสำเร็จ');
    }

    public function edit(ShippingAddress $address)
    {
        // ป้องกันไม่ให้แก้ที่อยู่ของคนอื่น
        abort_if($address->customer_id !== Auth::id(), 403);
        return view('customer.addresses.edit', compact('address'));
    }

    public function update(Request $request, ShippingAddress $address)
    {
        abort_if($address->customer_id !== Auth::id(), 403);
        $request->validate(['address' => 'required|string']);
        $address->update($request->all());
        return redirect()->route('customer.dashboard')->with('success', 'แก้ไขข้อมูลที่อยู่สำหรับจัดส่งสินค้าสำเร็จ');
    }

    public function destroy(ShippingAddress $address)
    {
        abort_if($address->customer_id !== Auth::id(), 403);

        // เงื่อนไข: ต้องมีที่อยู่มากกว่า 1 ที่ถึงจะลบได้
        if (Auth::user()->shippingAddresses()->count() <= 1) {
            return back()->with('error', 'ไม่สามารถลบที่อยู่สำหรับจัดส่งสินค้าได้ เนื่องจากคุณต้องมีอย่างน้อย 1 ที่อยู่สำหรับจัดส่งสินค้า');
        }

        $address->delete();
        return back()->with('success', 'ลบข้อมูลที่อยู่สำหรับจัดส่งสินค้าสำเร็จ');
    }
}