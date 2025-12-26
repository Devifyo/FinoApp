<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {   
        // 1. Ensure user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. STRICT CHECK: If user is NOT 'admin', block them immediately.
        // We do not care what the route name is. If this middleware is running, 
        // the user MUST be an admin.
        $user = Auth::user();
        if ($user->role === 'admin' || $user->role === 'sub_admin') {
            return $next($request);
        }

        // 3. User IS admin, let them pass.
        return $next($request);
    }
}