<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $customer = Auth::user();
        return view('customer.profile.edit', compact('customer'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'tel' => 'nullable|string|max:20',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('customer')->ignore($customer->id), 
            ],
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->tel = $request->tel;

        if ($request->filled('password')) {
            $customer->password = hash('sha256', $request->password);
        }

        $customer->save();

        return back()->with('success', 'แก้ไขข้อมูลส่วนตัวสำเร็จ');
    }
}