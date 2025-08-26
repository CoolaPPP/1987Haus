<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash; 

class CustomerAuthController extends Controller
{
    //Register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customer', 
            'tel' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed', 
        ]);

        if ($validator->fails()) {
            return redirect('register')
                        ->withErrors($validator)
                        ->withInput();
        }

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'tel' => $request->tel,
            'password' => hash('sha256', $request->password), // Hash รหัสผ่านด้วย SHA-256
        ]);

        Auth::login($customer);
        return redirect()->route('customer.dashboard');
    }

    //Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        $customer = Customer::where('email', $credentials['email'])->first();
        if ($customer && $customer->password === hash('sha256', $credentials['password'])) {
            Auth::login($customer);
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }
        return back()->with('error', 'ไม่พบข้อมูล กรุณาตรวจสอบ Email และรหัสผ่านอีกครั้ง');
    }

    //Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}