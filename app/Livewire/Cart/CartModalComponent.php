<?php

namespace App\Livewire\Cart;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Helpers\Cart\Cart;

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
        // we use add2Cart for increase by 1
        Cart::add2Cart($productId, 1);
        $this->refreshCart();
        $this->dispatch('cart-updated');
    }

    public function decrementQuantity($productId)
    {
        $cart = Cart::getCart();

        if (isset($cart[$productId])) {
            $currentQty = $cart[$productId]['quantity'];

            if ($currentQty > 1) {
                // reduce quantity by 1
                // that to need update session directly so that we havnt method update()
                $cart[$productId]['quantity'] = $currentQty - 1;
                session(['cart' => $cart]);
            } else {
                // if quantity = 1, delete product
                Cart::removeProductFromCart($productId);
            }

            $this->refreshCart();
            $this->dispatch('cart-updated');
        }
    }

    public function removeFromCart($productId)
    {
        Cart::removeProductFromCart($productId);
        $this->refreshCart();
        $this->dispatch('cart-updated');

        // if you use massege
        $this->dispatch('show-alert', [
            'type' => 'success',
            'message' => 'Товар удален из корзины!'
        ]);
    }

    public function clearCart()
    {
        // this is claer method for cart-update
        session(['cart' => []]);
        $this->refreshCart();
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        return view('livewire.cart.cart-modal-component');
    }
}
