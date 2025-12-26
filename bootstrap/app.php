<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            // Register Member Routes
            Route::middleware(['web', \App\Http\Middleware\MemberMiddleware::class])
                ->prefix('portal')
                ->name('member.')
                ->group(base_path('routes/member.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);

        // Fix the loop for "Already Logged In" users
        $middleware->redirectUsersTo(function (Request $request) {
            $user = Auth::user();
            if ($user && $user->role === 'admin') {
                return route('admin.dashboard');
            }
            return route('member.dashboard');
        });

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();