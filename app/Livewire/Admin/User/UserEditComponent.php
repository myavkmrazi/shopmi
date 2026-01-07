<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Edit User')]
class UserEditComponent extends Component
{

    use WithPagination;

    public User $user;
    public $name;
    public $email;
    public $password;
    public bool $is_admin;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->is_admin = $user->is_admin;
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user->id,
            'password' => 'nullable|min:6',
            'is_admin' => 'boolean',
        ]);

        $this->user->name = $validated['name'];
        $this->user->email = $validated['email'];
        $this->user->is_admin = $validated['is_admin'];
        if ($validated['password']) {
            $this->user->password = $validated['password'];
        }
        $this->user->save();
        session()->flash('success', 'User updated successfully');
        $this->redirectRoute('admin.users.index', navigate: true);
    }

    public function render()
    {
        $user_orders = $this->user->orders()->paginate();
        return view('livewire.admin.user.user-edit-component', compact('user_orders'));
    }
}
