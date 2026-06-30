<?php

namespace App\Helpers\Traits;

use App\Helpers\Cart\Cart;

trait CartTrait
{
    public int $quantity = 1;

    public function add2Cart(int $productId, $quantity = false): bool
    {
        $quantity = $quantity ?: $this->quantity;
        $quantity = max(1, (int) $quantity);

        $result = Cart::add2Cart($productId, $quantity);

        if ($result['success']) {
            $this->dispatch('cart-updated');
            $this->dispatch('open-cart');
            $this->dispatch('showToast', message: $result['message'], type: 'success');

            return true;
        }

        $this->dispatch('showToast', message: $result['message'], type: 'error');

        return false;
    }

    public function removeFromCart(int $productId): void
    {
        if (Cart::removeProductFromCart($productId)) {
            $this->dispatch('showToast', message: 'Товар удален из корзины', type: 'success');
            $this->dispatch('cart-updated');

            return;
        }

        $this->dispatch('showToast', message: 'Не удалось удалить товар', type: 'error');
    }
}
