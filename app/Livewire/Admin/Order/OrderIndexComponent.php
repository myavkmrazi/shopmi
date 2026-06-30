<?php

namespace App\Livewire\Admin\Order;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Orders')]
class OrderIndexComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function deleteOrder(Order $order)
    {

        try {
            DB::beginTransaction();
            $order->orderProducts()->delete();
            $order->delete();
            DB::commit();
            $this->js("toastr.success('Order removed')");

            return;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->js("toastr.error('Error deleting order')");
        }
    }

    public function render()
    {
        $orders = Order::query()->orderBy('id', 'desc')->paginate(10);

        return view('livewire.admin.order.order-index-component', compact('orders'));
    }
}
