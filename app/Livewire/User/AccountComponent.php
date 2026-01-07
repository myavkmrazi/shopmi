<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Order;

class AccountComponent extends Component
{
    public $ordersCount;

    public function mount()
    {
        // Получаем количество заказов текущего пользователя
        $this->ordersCount = Order::where('user_id', auth()->id())->count();
    }

    public function render()
    {
        return view('livewire.user.account-component', [
            'ordersCount' => $this->ordersCount
        ]);
    }
}
