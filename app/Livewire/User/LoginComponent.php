<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginComponent extends Component
{
    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    public function login()
    {
        $validated = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ], $this->remember)) {
            session()->regenerate();
            session()->flash('success', 'Login successful');
            $this->redirectRoute('account', navigate: true);
        } else {
            $this->js("toastr.error('Login failed')");
            $this->reset('password');
        }
    }

    public function render()
    {
        return view('livewire.user.login-component');
    }
}
