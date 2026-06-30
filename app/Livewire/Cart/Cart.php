<?php

namespace App\Livewire\Cart;

use App\Helpers\Cart\Cart as CartHelper;
use App\Helpers\Traits\CartTrait;
use Livewire\Component;

class Cart extends Component
{
    use CartTrait;

    public $cartItems = [];

    protected $listeners = ['cart-updated' => 'refreshCart'];

    public function mount()
    {
        CartHelper::sanitize();
        $this->cartItems = CartHelper::getCart();
    }

    public function incrementQuantity($productId)
    {
        $cart = CartHelper::getCart();

        if (! isset($cart[$productId])) {
            return;
        }

        $result = CartHelper::setQuantity((int) $productId, (int) $cart[$productId]['quantity'] + 1);

        if (! $result['success']) {
            $this->dispatch('showToast', message: $result['message'], type: 'error');
        }

        $this->refreshCart();
        $this->dispatch('cart-updated');
    }

    public function decrementQuantity($productId)
    {
        $cart = CartHelper::getCart();

        if (! isset($cart[$productId])) {
            return;
        }

        $currentQty = (int) $cart[$productId]['quantity'];

        if ($currentQty <= 1) {
            CartHelper::removeProductFromCart((int) $productId);
        } else {
            CartHelper::setQuantity((int) $productId, $currentQty - 1);
        }

        $this->refreshCart();
        $this->dispatch('cart-updated');
    }

    public function removeFromCart($productId)
    {
        CartHelper::removeProductFromCart($productId);
        $this->refreshCart();
        $this->dispatch('cart-updated');
    }

    public function clearCart()
    {
        CartHelper::clearCart();
        $this->refreshCart();
        $this->dispatch('cart-updated');
    }

    public function refreshCart()
    {
        $this->cartItems = CartHelper::getCart();
    }

    public function render()
    {
        return view('livewire.cart.cart');
    }
}
