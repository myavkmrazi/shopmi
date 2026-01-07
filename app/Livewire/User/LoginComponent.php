<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginComponent extends Component
{
    public string $email;
    public string $password;
    public bool $remember = false;
    public function login()
    {
        $validated = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt($validated)) {
            session()->flash('success', 'Login successful');
            $this->redirectRoute('account', navigate: true);
        } else {
            $this->js("toastr.error('Login failed')");
            $this->reset();
        }
    }
    public function render()
    {
        return view('livewire.user.login-component');
    }
}
