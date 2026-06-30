<?php

namespace App\Livewire\User;

use App\Models\Order;
use Livewire\Component;

class AccountComponent extends Component
{
    public $ordersCount;

    public function mount(): void
    {
        $this->ordersCount = Order::where('user_id', auth()->id())->count();
    }

    public function render()
    {
        $recentOrders = Order::query()
            ->where('user_id', auth()->id())
            ->latest()
            ->limit(3)
            ->get();

        return view('livewire.user.account-component', [
            'ordersCount' => $this->ordersCount,
            'recentOrders' => $recentOrders,
        ]);
    }
}
