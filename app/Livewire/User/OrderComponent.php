<?php

namespace App\Livewire\User;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrderComponent extends Component
{
    use WithPagination;

    public function render()
    {
        $orders = Order::query()
            ->where('user_id', '=', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.user.order-component', [
            'orders' => $orders,
        ]);

    }
}
