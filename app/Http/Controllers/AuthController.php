<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 1. Fungsi untuk menampilkan halaman Landing Page / Login
    public function index()
    {
        // Jika user sudah login, langsung lempar ke Dashboard
        if (Auth::check()) {
            return redirect()->route('stunting.index');
        }
        return view('welcome'); // Pastikan nama file landing page-mu adalah welcome.blade.php
    }

    // 2. Fungsi untuk memproses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('stunting');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // 3. Fungsi untuk memproses Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:6'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Langsung login-kan setelah berhasil register
        Auth::login($user);
        
        return redirect()->route('stunting.index');
    }

    // 4. Fungsi untuk memproses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}