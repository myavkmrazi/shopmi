<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\User;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

#[Layout('components.layouts.admin')]
#[Title('Dashboard')]
class HomeComponent extends Component
{

    public function render()
    {
        $products_cnt = Product::query()->count();
        $users_cnt = User::query()->count();
        $orders_cnt = Order::query()->count();
        $orders_total = Order::query()->sum('total');
        return view('livewire.admin.home-component', compact('products_cnt', 'users_cnt', 'orders_cnt', 'orders_total'));
    }
}
