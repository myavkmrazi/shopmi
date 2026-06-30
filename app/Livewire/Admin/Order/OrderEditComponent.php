<?php

namespace App\Livewire\Admin\Order;

use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Orders')]
class OrderEditComponent extends Component
{
    public Order $order;

    public string $status;

    public function mount(Order $order)
    {
        $this->order = $order;
        $this->status = $order->status ?: 'new';
    }

    public function updatedStatus()
    {
        $this->validate([
            'status' => 'required|in:'.implode(',', array_keys(Order::STATUSES)),
        ]);

        $this->order->setAttribute('status', $this->status)->save();
    }

    public function render()
    {
        return view('livewire.admin.order.order-edit-component', [
            'statuses' => Order::STATUSES,
        ]);
    }
}
