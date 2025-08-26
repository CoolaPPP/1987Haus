<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingAddress;

class CustomerAddressController extends Controller
{
    public function index()
    {
        $addresses = ShippingAddress::with('customer')->latest()->paginate(20);
        return view('admin.shipping_addresses.index', compact('addresses'));
    }
}