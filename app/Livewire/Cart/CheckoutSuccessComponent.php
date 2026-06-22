<?php

namespace App\Livewire\Cart;

use App\Models\Order;
use Livewire\Component;

class CheckoutSuccessComponent extends Component
{
    public ?Order $order = null;

    public function mount(): void
    {
        $orderId = session()->pull('checkout_success_order_id');

        if (! $orderId) {
            $this->redirectRoute('home', navigate: true);

            return;
        }

        $order = Order::with('orderProducts')->find($orderId);

        if (! $order) {
            $this->redirectRoute('home', navigate: true);

            return;
        }

        if (auth()->check() && $order->user_id && (int) $order->user_id !== (int) auth()->id()) {
            abort(403);
        }

        $this->order = $order;
    }

    public function paymentLabel(): string
    {
        return match ($this->order?->payment_method) {
            'card' => 'Банковская карта онлайн',
            'cash' => 'Наличными при получении',
            default => $this->order?->payment_method ?? '—',
        };
    }

    public function render()
    {
        return view('livewire.cart.checkout-success-component');
    }
}
