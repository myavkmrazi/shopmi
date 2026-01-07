<?php

namespace App\Livewire\Cart;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Helpers\Cart\Cart;

class CartIconComponent extends Component
{
    public $cartCount = 0;

    public function mount()
    {
        $this->updateCartCount();
    }

    #[On('cart-updated')] // ← ТОЛЬКО ЭТОТ ПОДХОД
    public function updateCartCount()
    {
        $this->cartCount = Cart::getCartQuantityItems();
    }

    public function render()
    {
        return view('livewire.cart.cart-icon-component');
    }
}
