<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Vendor;

class VendorAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('vendor.login');
    }

    public function showRegistrationForm()
    {
        return view('vendor.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:vendors',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $vendor = Vendor::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Show success message and redirect to login page
        return redirect()->route('vendor.login')
            ->with('success', 'Registered successfully! You are now a vendor. Please login.');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (auth()->guard('vendor')->attempt($credentials)) {
            return redirect()->route('vendor.dashboard');
        }
        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function logout()
    {
        Auth::guard('vendor')->logout();
        return redirect('/vendor/login');
    }
}
