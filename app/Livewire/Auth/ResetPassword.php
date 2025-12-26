<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;

class ResetPassword extends Component
{
    public $token;
    public $email;
    public $password;
    public $password_confirmation;

    public function mount($token)
    {
        $this->token = $token;
        // Auto-fill email from the link query string
        $this->email = request()->query('email', '');
    }

    protected $rules = [
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ];

    public function resetPassword()
    {
        $this->validate();

        // Laravel's built-in password reset logic
        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('status', __($status));
            return redirect()->route('login');
        }

        $this->addError('email', __($status));
    }

    public function render()
    {
        return view('livewire.auth.reset-password')
            ->layout('layouts.auth', [ // Change to 'layouts.auth' if that is your layout name
                'title' => 'Reset Password', 
                'subtitle' => 'Create a new secure password'
            ]);
    }
}