<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Create User')]
class UserCreateComponent extends Component
{
    public string $name = '';

    public string $surname = '';

    public string $email = '';

    public string $password = '';

    public bool $is_admin = false;

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8',
            'is_admin' => 'boolean',
        ]);

        $user = new User;
        $user->name = $validated['name'];
        $user->surname = $validated['surname'];
        $user->email = $validated['email'];
        $user->password = $validated['password'];
        $user->is_admin = $validated['is_admin'];
        $user->save();
        session()->flash('success', 'User created successfully');
        $this->redirectRoute('admin.users.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.user.user-create-component');
    }
}
