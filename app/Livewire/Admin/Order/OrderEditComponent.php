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
    public bool $status;

    public function mount(Order $order){
        $this->order = $order;
        $this->status = $order->status;
    }
    public function updatedStatus()
    {
       $this->order->setAttribute('status',$this->status)->save();
    }
    public function render()
    {
        return view('livewire.admin.order.order-edit-component');
    }
}
