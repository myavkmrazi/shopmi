<?php

namespace App\Helpers\Cart;

use App\Models\Product;

class Cart
{
    public const MAX_QUANTITY = 99;

    public static function add2Cart(int $productId, int $quantity = 1): array
    {
        $product = Product::query()->find($productId);

        if (! $product) {
            return ['success' => false, 'message' => 'Товар не найден'];
        }

        if ((int) $product->stock <= 0) {
            return ['success' => false, 'message' => 'Товар отсутствует на складе'];
        }

        $maxAllowed = self::maxAllowedQuantity($product);
        $quantity = max(1, min($maxAllowed, $quantity));

        if (self::hasProductInCart($productId)) {
            $newQty = (int) session("cart.{$productId}.quantity") + $quantity;
            $newQty = max(1, min($maxAllowed, $newQty));
            session(["cart.{$productId}.quantity" => $newQty]);
        } else {
            session([
                "cart.{$productId}" => self::productPayload($product, $quantity),
            ]);
        }

        return ['success' => true, 'message' => 'Товар добавлен в корзину'];
    }

    public static function setQuantity(int $productId, int $quantity): array
    {
        if (! self::hasProductInCart($productId)) {
            return ['success' => false, 'message' => 'Товар не найден в корзине'];
        }

        $product = Product::query()->find($productId);

        if (! $product) {
            self::removeProductFromCart($productId);

            return ['success' => false, 'message' => 'Товар больше недоступен и удалён из корзины'];
        }

        if ((int) $product->stock <= 0) {
            self::removeProductFromCart($productId);

            return ['success' => false, 'message' => 'Товар отсутствует на складе'];
        }

        $maxAllowed = self::maxAllowedQuantity($product);
        $quantity = max(1, min($maxAllowed, $quantity));

        session(["cart.{$productId}.quantity" => $quantity]);

        return ['success' => true, 'message' => 'Количество обновлено'];
    }

    public static function sanitize(): array
    {
        $messages = [];
        $cart = self::getCart();

        foreach (array_keys($cart) as $productId) {
            $product = Product::query()->find((int) $productId);

            if (! $product) {
                self::removeProductFromCart((int) $productId);
                $messages[] = 'Некоторые товары удалены из корзины — больше не доступны';

                continue;
            }

            if ((int) $product->stock <= 0) {
                self::removeProductFromCart((int) $productId);
                $messages[] = "«{$product->title}» снят с продажи";

                continue;
            }

            $maxAllowed = self::maxAllowedQuantity($product);
            $currentQty = (int) ($cart[$productId]['quantity'] ?? 1);

            if ($currentQty > $maxAllowed) {
                session(["cart.{$productId}.quantity" => $maxAllowed]);
                $messages[] = "Количество «{$product->title}» уменьшено до {$maxAllowed}";
            }
        }

        return array_values(array_unique($messages));
    }

    public static function validateForCheckout(): array
    {
        $cart = self::getCart();

        if (empty($cart)) {
            return ['success' => false, 'errors' => ['Корзина пуста']];
        }

        $errors = self::sanitize();

        $cart = self::getCart();

        if (empty($cart)) {
            return ['success' => false, 'errors' => array_merge($errors, ['Корзина пуста'])];
        }

        foreach ($cart as $productId => $item) {
            $product = Product::query()->find((int) $productId);

            if (! $product) {
                $errors[] = 'В корзине есть недоступные товары';

                continue;
            }

            $qty = (int) ($item['quantity'] ?? 1);

            if ($qty < 1) {
                $errors[] = "Некорректное количество для «{$product->title}»";
            }

            if ($qty > self::maxAllowedQuantity($product)) {
                $errors[] = "Для «{$product->title}» доступно не более ".self::maxAllowedQuantity($product).' шт.';
            }
        }

        return [
            'success' => empty($errors),
            'errors' => array_values(array_unique($errors)),
        ];
    }

    public static function maxAllowedQuantity(Product $product): int
    {
        return min(self::MAX_QUANTITY, max(0, (int) $product->stock));
    }

    public static function hasProductInCart(int $productId): bool
    {
        return session()->has("cart.{$productId}");
    }

    public static function removeProductFromCart(int $productId): bool
    {
        if (self::hasProductInCart($productId)) {
            session()->forget("cart.{$productId}");

            return true;
        }

        return false;
    }

    public static function getCart(): array
    {
        return session('cart') ?: [];
    }

    public static function clearCart(): void
    {
        session(['cart' => []]);
    }

    public static function getTotalPrice(): int
    {
        $total = 0;

        foreach (self::getCart() as $item) {
            $total += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
        }

        return $total;
    }

    public static function getCartQuantityItems(): int
    {
        return count(self::getCart());
    }

    public static function getCartQuantityTotal(): int
    {
        return array_sum(array_column(self::getCart(), 'quantity'));
    }

    protected static function productPayload(Product $product, int $quantity): array
    {
        return [
            'title' => $product->title,
            'slug' => $product->slug,
            'image' => $product->getImage(),
            'price' => $product->price,
            'quantity' => $quantity,
            'stock' => (int) $product->stock,
        ];
    }
}
