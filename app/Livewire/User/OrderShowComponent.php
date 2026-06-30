<?php

namespace App\Livewire\User;

use App\Models\Order;
use Livewire\Component;

class OrderShowComponent extends Component
{
    public $order;

    public $orderId;

    public $orderProducts = [];

    public function mount($id = null)
    {
        $this->orderId = $id;

        $this->order = Order::with('orderProducts')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        $this->orderProducts = $this->order->orderProducts;
    }

    public function render()
    {
        return view('livewire.user.order-show-component', [
            'order' => $this->order,
            'orderProducts' => $this->orderProducts,
        ]);
    }
}
