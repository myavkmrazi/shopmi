<?php

namespace App\Livewire\Cart;

use Livewire\Component;
use App\Helpers\Traits\CartTrait;
use App\Helpers\Cart\Cart as CartHelper; // Добавьте псевдоним

class Cart extends Component
{
    use CartTrait;

    //the base attributes
    public $cartItems = [];
    protected $listeners = ['cart-updated' => 'refreshCart'];

    public function mount()
    {
        $this->cartItems = CartHelper::getCart(); // Используйте CartHelper
    }

    //this is method for increase product quantity
    public function incrementQuantity($productId)
    {
        CartHelper::add2Cart($productId, 1); // Используйте CartHelper
        $this->refreshCart();
        $this->dispatch('cart-updated');
    }

    public function decrementQuantity($productId)
    {
        $cart = CartHelper::getCart(); // Используйте CartHelper

        if (isset($cart[$productId])) {
            $currentQty = $cart[$productId]['quantity'];

            if ($currentQty > 1) {
                $cart[$productId]['quantity'] = $currentQty - 1;
                session(['cart' => $cart]);
            } else {
                CartHelper::removeProductFromCart($productId); // Используйте CartHelper
            }
            $this->refreshCart();
            $this->dispatch('cart-updated');
        }
    }

    public function removeFromCart($productId)
    {
        CartHelper::removeProductFromCart($productId); // Используйте CartHelper
        $this->refreshCart();
        $this->dispatch('cart-updated');
    }

    public function clearCart()
    {
        session(['cart' => []]);
        $this->refreshCart();
        $this->dispatch('cart-updated');
    }

    public function refreshCart()
    {
        $this->cartItems = CartHelper::getCart(); // Используйте CartHelper
    }

    public function render()
    {
        return view('livewire.cart.cart');
    }
} 
