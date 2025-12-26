<?php

use App\Livewire\Admin\SubAdmins;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Auth\Login;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    // 1. Not Logged In -> Login
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    // 2. Admin -> Admin Dash
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    // 3. Member -> Member Dash
    return redirect()->route('member.dashboard');
})->name('home');

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::redirect('/', '/login');
    Route::get('/login', Login::class)->name('login');
});
// Authenticated Routes
Route::middleware('auth')->group(function () {
    
    // Logout
    Route::post('/logout', fn() => Auth::logout() ?: redirect()->route('login'))->name('logout');

    // Admin Routes
    Route::prefix('admin')
        ->name('admin.')
        ->middleware('admin') // <--- FIXED: Use the string alias here
        ->group(function () {
            
           Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('dashboard')->middleware('can:view dashboard');
           Route::get('/settings', \App\Livewire\Admin\Settings::class)->name('settings')->middleware('can:view settings');
           Route::get('/users', \App\Livewire\Admin\Users::class)->name('users')->middleware('can:view users');
           Route::get('/projects', \App\Livewire\Admin\Projects::class)->name('projects')->middleware('can:view projects');
           Route::get('/earnings', \App\Livewire\Admin\Earnings::class)->name('earnings')->middleware('can:view earnings');
           Route::get('/sub-admins', SubAdmins::class)->name('sub-admins')->middleware('can:manage sub_admins');
    });
    // Member Routes

});