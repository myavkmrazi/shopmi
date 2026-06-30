<?php

namespace App\Livewire\Cart;

use App\Helpers\Cart\Cart;
use Livewire\Attributes\On;
use Livewire\Component;

class CartModalComponent extends Component
{
    public $cartItems = [];

    #[On('cart-updated')]
    public function refreshCart()
    {
        $this->cartItems = Cart::getCart();
    }

    public function mount()
    {
        $this->refreshCart();
    }

    public function incrementQuantity($productId)
    {
        $cart = Cart::getCart();

        if (! isset($cart[$productId])) {
            return;
        }

        $result = Cart::setQuantity((int) $productId, (int) $cart[$productId]['quantity'] + 1);

        if (! $result['success']) {
            $this->dispatch('showToast', message: $result['message'], type: 'error');
        }

        $this->refreshCart();
        $this->dispatch('cart-updated');
    }

    public function decrementQuantity($productId)
    {
        $cart = Cart::getCart();

        if (! isset($cart[$productId])) {
            return;
        }

        $currentQty = (int) $cart[$productId]['quantity'];

        if ($currentQty <= 1) {
            Cart::removeProductFromCart((int) $productId);
        } else {
            Cart::setQuantity((int) $productId, $currentQty - 1);
        }

        $this->refreshCart();
        $this->dispatch('cart-updated');
    }

    public function removeFromCart($productId)
    {
        Cart::removeProductFromCart($productId);
        $this->refreshCart();
        $this->dispatch('cart-updated');

        $this->dispatch('show-alert', [
            'type' => 'success',
            'message' => 'Товар удален из корзины!',
        ]);
    }

    public function clearCart()
    {
        Cart::clearCart();
        $this->refreshCart();
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        return view('livewire.cart.cart-modal-component');
    }
}
