<?php

namespace App\Livewire\Admin\Order;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Order;
#[Layout('components.layouts.admin')]
#[Title('Orders')]
class OrderEditComponent extends Component
{
    public Order $order;
    public string $status;

    public function mount(Order $order){
        $this->order = $order;
        $this->status = $order->status ?: 'new';
    }
    public function updatedStatus()
    {
        $this->validate([
            'status' => 'required|in:' . implode(',', array_keys(Order::STATUSES)),
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
