<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DosenLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.dosen.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'NIM' => 'required|string',
            'password' => 'required',
        ]);

        if (Auth::guard('dosen')->attempt($credentials)) {
            return redirect()->intended('/dosen/dashboard');
        }

        return back()->withErrors(['NIP' => 'NIP tidak valid']);
    }
}
