<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;

class ForgotPassword extends Component
{
    public $email = '';

    protected $rules = [
        'email' => 'required|email',
    ];

    public function sendResetLink()
    {
        $this->validate();

        // Attempt to send the password reset link
        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('status', __($status));
            $this->email = ''; // Clear input on success
        } else {
            $this->addError('email', __($status));
        }
    }

    public function render()
    {
        // We use the same 'layouts.app' structure as the login page
        return view('livewire.auth.forgot-password')
            ->layout('layouts.auth', [
                'title' => 'Reset Password',
                'subtitle' => 'Recover access to your account'
            ]);
    }
}