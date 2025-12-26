<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    // Rules for validation
    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function login()
    {   
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            
            $user = Auth::user();

            // Force redirect to specific dashboard based on role
            // We remove 'intended' to stop it from trying to go back to '/' and triggering the logic again
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('member.dashboard');
        }

        $this->addError('email', 'These credentials do not match our records.');
    }

    public function render()
    {
        // Notice how we point to the layout created above
        return view('livewire.auth.login')
            ->layout('layouts.auth', [
                'title' => 'Sign in to your account',
                'subtitle' => 'Access your dashboard'
            ]);
    }
}