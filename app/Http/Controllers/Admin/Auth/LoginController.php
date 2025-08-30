<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Owner; 

class LoginController extends Controller
{
    //Show Admin Login Form
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    //Admin Login
    public function login(Request $request)
    {
        $request->validate([
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        $credentials = $request->only('email', 'password');
        
        $admin = Owner::where('email', $credentials['email'])->first();

        if ($admin && $admin->password === hash('sha256', $credentials['password'])) {
            Auth::guard('admin')->login($admin);
            return redirect()->intended('/admin/home');
        }   
        return back()->withInput($request->only('email', 'remember'))
                     ->withErrors(['email' => 'รหัสผ่านหรืออีเมลไม่ถูกต้อง']);
    }

    //Admin Logout
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}