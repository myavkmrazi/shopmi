<?php

namespace App\Helpers\Traits;

use App\Helpers\Wishlist\Wishlist;

trait WishlistTrait
{
    public function toggleWishlist(int $productId): void
    {
        $result = Wishlist::toggle($productId);

        $this->dispatch('wishlist-updated');

        $this->dispatch(
            'showToast',
            message: $result['message'],
            type: $result['success'] ? 'success' : 'error'
        );
    }

    public function isInWishlist(int $productId): bool
    {
        return Wishlist::has($productId);
    }
}
