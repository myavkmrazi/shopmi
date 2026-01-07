<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;

class ChangeAccountComponent extends Component
{
    public string $name;
    public string $surname;
    public string $email;
    public string $password;

    public function mount()
    {

        $this->name = auth()->user()->name;
        $this->surname = auth()->user()->surname;
        $this->email = auth()->user()->email;
    }

    public function save()
    {
        $user = User::query()->findOrFail(auth()->id());
        $validated = $this->validate([
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'password' => 'nullable|min:6',
        ]);
        if(!$validated['password']){
            unset($validated['password']);
        }

        $user->update($validated);
          $this->js("toastr.success('Успешное изменение профиля')");
    }


    public function render()
    {
        return view('livewire.user.change-account-component');
    }
}
