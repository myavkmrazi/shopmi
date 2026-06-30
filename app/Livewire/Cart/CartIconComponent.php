<?php

namespace App\Livewire\Cart;

use App\Helpers\Cart\Cart;
use Livewire\Attributes\On;
use Livewire\Component;

class CartIconComponent extends Component
{
    public $cartCount = 0;

    public function mount()
    {
        $this->updateCartCount();
    }

    #[On('cart-updated')]
    public function updateCartCount()
    {
        $this->cartCount = Cart::getCartQuantityItems();
    }

    public function render()
    {
        return view('livewire.cart.cart-icon-component');
    }
}
