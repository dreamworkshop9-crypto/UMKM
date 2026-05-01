<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login.login');
    }

    public function daftar()
    {
        return view('auth.register.register');
    }

    // 🔐 PROSES LOGIN
    public function prosesLogin(Request $request)
    {
        $data = $request->only('email', 'password');

        if (Auth::attempt($data)) {
            return redirect('/dashboard');
        }

        return back()->with('error', 'Email atau password salah');
    }

    // 📝 PROSES DAFTAR
    public function prosesDaftar(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect('/login')->with('success', 'Berhasil daftar, silakan login');
    }

    // 🚪 LOGOUT
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}