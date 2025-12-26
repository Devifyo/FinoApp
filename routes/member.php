<?php

use App\Livewire\Member\ProjectDetails;
use App\Livewire\Member\Projects;
use Illuminate\Support\Facades\Route;
use App\Livewire\Member\Dashboard;

/*
|--------------------------------------------------------------------------
| Member Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the bootstrap/app.php file.
| They are protected by the 'web', 'auth', and 'member' middleware.
|
*/
// The prefix '/portal' is set in bootstrap/app.php, so this becomes /portal/dashboard
Route::get('/dashboard', Dashboard::class)->name('dashboard');
Route::get('/projects', Projects::class)->name('projects');
Route::get('/projects/{project}', ProjectDetails::class)->name('project.show');
