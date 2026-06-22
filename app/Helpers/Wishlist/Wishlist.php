<?php

namespace App\Helpers\Wishlist;

use App\Models\Product;

class Wishlist
{
    public static function toggle(int $productId): array
    {
        if (self::has($productId)) {
            self::remove($productId);

            return ['success' => true, 'added' => false, 'message' => 'Удалено из избранного'];
        }

        if (! self::add($productId)) {
            return ['success' => false, 'added' => false, 'message' => 'Товар не найден'];
        }

        return ['success' => true, 'added' => true, 'message' => 'Добавлено в избранное'];
    }

    public static function add(int $productId): bool
    {
        $product = Product::query()->find($productId);

        if (! $product) {
            return false;
        }

        session([
            "wishlist.{$productId}" => [
                'title' => $product->title,
                'slug' => $product->slug,
                'price' => $product->price,
                'image' => $product->getImage(),
            ],
        ]);

        return true;
    }

    public static function remove(int $productId): void
    {
        session()->forget("wishlist.{$productId}");
    }

    public static function has(int $productId): bool
    {
        return session()->has("wishlist.{$productId}");
    }

    public static function get(): array
    {
        return session('wishlist') ?: [];
    }

    public static function count(): int
    {
        return count(self::get());
    }
}
