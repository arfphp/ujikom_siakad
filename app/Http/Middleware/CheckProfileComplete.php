<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Dosen;
use App\Models\Mahasiswa;

class CheckProfileComplete
{
    // File: app/Http/Middleware/CheckProfileComplete.php
public function handle(Request $request, Closure $next): Response
{
    $user = auth()->user();

    // Skip middleware untuk route profile dan logout
    if ($request->routeIs('filament.admin.pages.profile') ||
        $request->routeIs('filament.admin.auth.logout')) {
        return $next($request);
    }

    if ($user && !$this->isProfileComplete($user)) {
        return redirect()->route('filament.admin.pages.profile');
    }

    return $next($request);
}

    private function isProfileComplete($user)
    {
        if($user->role === 'mahasiswa'){
            return Mahasiswa::where('user_id', $user->id)->exists();
        }

        if($user->role === 'dosen'){
            return Dosen::where('user_id', $user->id)->exists();
        }

        return true;
    }
}
