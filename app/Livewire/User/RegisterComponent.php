<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;

class RegisterComponent extends Component
{
    public string $name;
    public string $surname;
    public string $email;
    public string $password;

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6',
        ]);
        $user = User::query()->create($validated);
        session()->flash('success', 'Thanks for registrtion!');
        $this->redirectRoute('login', navigate: true);
    }
    public function render()
    {
        return view('livewire.user.register-component');
    }
}
