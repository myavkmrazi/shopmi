<?php
namespace App\Helpers\Cart;

use App\Models\Product;

class Cart
{

    // add product to Cart
    public static function add2Cart(int $productId, int $quantity = 1): bool
    {
        if (self::hasProductInCart($productId)) {

            session(["cart.{$productId}.quantity" => session("cart.{$productId}.quantity") + $quantity]);
            return true;
        } else {

            $product = Product::find($productId);
            if ($product) {
                session([
                    "cart.{$productId}" => [
                        'title' => $product->title,
                        'slug' => $product->slug,
                        'image' => $product->getImage(),
                        'price' => $product->price,
                        'quantity' => $quantity,
                    ]
                ]);
                return true;
            }
        }
        return false;
    }
    //has product in Cart
    public static function hasProductInCart(int $productId): bool
    {
        return session()->has("cart.$productId");
    }
    //remove product from cart
    public static function removeProductFromCart(int $productId): bool
    {
        if (self::hasProductInCart($productId)) {
            session()->forget("cart.{$productId}");
            return true;
        }
        return false;
    }

    //get cart
    public static function getCart(): array
    {
        return session('cart') ?: [];
    }

    //clear cart
    public function clearCart()
    {
        session(['cart' => []]);
        $this->refreshCart();
        $this->dispatch('cart-updated');
    }
    //get cart total sum
    public static function getTotalPrice(): int
    {
        $cart = self::getCart();
        $total = 0;

        foreach ($cart as $item) {
            $total += ($item['price'] * $item['quantity']);
        }

        return $total;
    }

    //get cat items
    public static function getCartQuantityItems(): int
    {
        return count(self::getCart());
    }
    //get cart quantity
    public static function getCartQuantityTotal(): int
    {
        $cart = self::getCart();
        return array_sum(array_column($cart, 'quantity'));
    }
}
