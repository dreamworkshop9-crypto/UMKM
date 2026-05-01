<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (auth()->check()) return $this->redirectByRole();
        return view('pages.auth.login');
    }

    public function showRegister()
    {
        if (auth()->check()) return $this->redirectByRole();
        return view('pages.auth.register');
    }

    public function login(Request $request)
    {
        $request->validate(['email' => 'required|email', 'password' => 'required']);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            return $this->redirectByRole()->with('success', 'Selamat datang kembali!');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'phone'    => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
            'role'     => 'pelanggan',
        ]);

        Auth::login($user);
        return redirect()->route('pelanggan.dashboard')->with('success', 'Akun berhasil dibuat!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Berhasil keluar.');
    }

    private function redirectByRole()
    {
        $userRole = auth()->user()->role;

        switch ($userRole) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'pelanggan':
                return redirect()->route('pelanggan.dashboard');
            case 'penjual':
                // Jika ada dashboard penjual, redirect ke sana
                return redirect()->route('penjual.dashboard'); // Asumsikan ada route ini
            case 'pembeli':
                // Jika ada dashboard pembeli, redirect ke sana
                return redirect()->route('pembeli.dashboard'); // Asumsikan ada route ini
            default:
                return redirect()->route('home');
        }
    }
}
