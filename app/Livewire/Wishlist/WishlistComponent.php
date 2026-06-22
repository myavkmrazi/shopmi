<?php

namespace App\Livewire\Wishlist;

use App\Helpers\Traits\CartTrait;
use App\Helpers\Traits\WishlistTrait;
use App\Helpers\Wishlist\Wishlist;
use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;

class WishlistComponent extends Component
{
    use CartTrait, WishlistTrait;

    public array $items = [];

    #[On('wishlist-updated')]
    public function refreshWishlist(): void
    {
        $this->items = Wishlist::get();
    }

    public function mount(): void
    {
        $this->refreshWishlist();
    }

    public function removeFromWishlist(int $productId): void
    {
        Wishlist::remove($productId);
        $this->refreshWishlist();
        $this->dispatch('wishlist-updated');
        $this->dispatch('showToast', message: 'Удалено из избранного', type: 'success');
    }

    public function render()
    {
        $products = Product::query()
            ->whereIn('id', array_keys($this->items))
            ->get()
            ->keyBy('id');

        return view('livewire.wishlist.wishlist-component', [
            'products' => $products,
        ]);
    }
}
