<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class MemberMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // If Admin tries to access member area -> Kick to Admin Dash
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // If Member is here -> LET THEM PASS (Do not redirect again!)
        return $next($request);
    }
}