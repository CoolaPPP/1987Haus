<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class DashboardController extends Controller
{

    public function index()
    {
        /** @var \App\Models\Customer $customer */ // 
        $customer = Auth::user();

        $addresses = $customer->shippingAddresses()->latest()->get();

        $orders = $customer->orders() // <--- แก้ไขเป็น orders()
                   ->with(['status', 'payment'])
                   ->latest('order_datetime')
                   ->paginate(10);
    
        //  เพิ่มการดึงข้อมูลรายการที่ถูกยกเลิก
       $cancellations = $customer->orders()
                                ->where('order_status_id', 4)
                                ->latest('order_datetime')
                                ->get();

    // vvv และแก้ไขใน compact() ให้ตรงกัน vvv
    return view('customer.dashboard', compact('customer', 'addresses', 'orders', 'cancellations'));
}

}