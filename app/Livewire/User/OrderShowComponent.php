<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Order;

class OrderShowComponent extends Component
{
    public $order;
    public $orderId;
    public $orderProducts = [];

    public function mount($id = null)
    {
        $this->orderId = $id;

        // Получаем заказ ВМЕСТЕ с товарами
        $this->order = Order::with('orderProducts')
            ->where('user_id', auth()->id())
            ->find($id);

        if ($this->order) {
            // Получаем товары из связанной таблицы
            $this->orderProducts = $this->order->orderProducts;


        } else {
            // Заглушка
            $this->order = (object) [
                'id' => $id ?? 1,
                'name' => 'Sabina',
                'email' => 'sabina@mail.com',
                'total' => 94980,
                'status' => 0,
                'created_at' => now(),
            ];

            // Статические товары для заглушки
            $this->orderProducts = [
                (object) [
                    'title' => 'Смартфон Samsung Galaxy S23',
                    'price' => 64990,
                    'quantity' => 1,
                ],
                (object) [
                    'title' => 'Наушники Sony WH-1000XM4',
                    'price' => 29990,
                    'quantity' => 1,
                ],
            ];


        }
    }

    public function render()
    {
        return view('livewire.user.order-show-component', [
            'order' => $this->order,
            'orderProducts' => $this->orderProducts
        ]);
    }
}
