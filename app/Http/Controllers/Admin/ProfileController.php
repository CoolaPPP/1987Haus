<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        $owner = Auth::guard('admin')->user();
        return view('admin.profile.show', compact('owner'));
    }

    public function edit()
    {
        $owner = Auth::guard('admin')->user();
        return view('admin.profile.edit', compact('owner'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\Owner $owner */ //
        $owner = Auth::guard('admin')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'tel' => 'nullable|string|max:20',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('owners')->ignore($owner->id),
            ],
            'password' => 'nullable|string|min:6|confirmed', 
        ]);

        $owner->name = $request->name;
        $owner->email = $request->email;
        $owner->tel = $request->tel;

        if ($request->filled('password')) {
            $owner->password = hash('sha256', $request->password);
        }

        $owner->save();

        return back()->with('success', 'แก้ไขข้อมูลส่วนตัวสำเร็จ');
    }
}