<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MahasiswaLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.mahasiswa.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'NIM' => 'required|string',
            'password' => 'required',
        ]);

        if (Auth::guard('mahasiswa')->attempt($credentials)) {
            return redirect()->intended('/mahasiswa/dashboard');
        }

        return back()->withErrors(['NIM' => 'NIM tidak valid']);
    }
}
