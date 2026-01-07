<?php
namespace App\Helpers\Traits;

use App\Helpers\Cart\Cart;

trait CartTrait
{
    public int $quantity = 1;

    public function add2Cart(int $productId, $quantity = false)
    {
        $quantity = $quantity ?: $this->quantity;

        if ($quantity < 1)
            $quantity = 1;

        if (Cart::add2Cart($productId, $quantity)) {
            // Обновляем ВСЕ компоненты корзины
            $this->dispatch('cartUpdated');

            // НОВЫЙ СИНТАКСИС Livewire 3 - убрали 'show-toast'
            $this->dispatch(
                'showToast',
                message: 'Товар успешно добавлен в корзину!',
                type: 'success'
            );

            return true;
        }

        return false;
    }
    public function removeFromCart(int $productId): void
    {
        if (Cart::removeProductFromCart($productId)) {
            $this->js("toastr.success('Product removed to cart successfuly')");
            $this->dispatch('cart-updated');
        } else {
            $this->js("toastr.error('Oops! Something went wrong')");
        }
    }
}
