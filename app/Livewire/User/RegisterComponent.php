<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;

class RegisterComponent extends Component
{
    public string $name = '';
    public string $surname = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $terms = false;

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'terms' => 'accepted',
        ]);

        unset($validated['terms']);

        User::query()->create($validated);

        session()->flash('success', 'Thanks for registration!');
        $this->redirectRoute('login', navigate: true);
    }

    public function render()
    {
        return view('livewire.user.register-component');
    }
}
