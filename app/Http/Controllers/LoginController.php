<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nim_nis' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'nim_nis' => $request->nim_nis,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect based on role
            if ($user->isAdmin()) {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->isMahasiswa()) {
                return redirect()->intended('/mahasiswa/dashboard');
            } elseif ($user->isPembimbing()) {
                return redirect()->intended('/pembimbing/dashboard');
            }
        }

        return back()->withErrors([
            'nim_nis' => 'NIM/NIS atau password salah.',
        ])->onlyInput('nim_nis');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
