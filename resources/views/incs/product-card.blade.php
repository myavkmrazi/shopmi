<div class="item h-100" wire:key="product-card-{{ $product->id }}">
    <article class="shopmi-product-card">
        <a class="shopmi-product-media" href="{{ route('product', $product->slug) }}" wire:navigate>
            @if ($product->is_hit)
                <span class="shopmi-ribbon">HIT</span>
            @elseif ($product->is_new)
                <span class="shopmi-ribbon new">NEW</span>
            @endif

            <button
                type="button"
                class="shopmi-wishlist-btn @if ($this->isInWishlist($product->id)) is-active @endif"
                wire:click.prevent="toggleWishlist({{ $product->id }})"
                title="В избранное"
                aria-label="Добавить в избранное"
            >
                <i class="fas fa-heart"></i>
            </button>

            <img src="{{ $product->getImage() }}" alt="{{ $product->title }}" loading="lazy">
        </a>

        <div class="shopmi-product-body">
            <a href="{{ route('product', $product->slug) }}" wire:navigate>
                <h3 class="shopmi-card-title">{{ $product->title }}</h3>
            </a>

            <div class="shopmi-price">
                <span>${{ number_format($product->price, 2) }}</span>
                @if ($product->old_price && $product->old_price > $product->price)
                    <span class="shopmi-price-old">${{ number_format($product->old_price, 2) }}</span>
                @endif
            </div>

            @if ($product->inStock())
                <button
                    wire:click="add2Cart({{ $product->id }})"
                    wire:loading.attr="disabled"
                    class="shopmi-btn shopmi-btn-outline mt-auto"
                >
                    <span wire:loading.remove wire:target="add2Cart({{ $product->id }})">
                        <i class="fas fa-shopping-bag"></i> В корзину
                    </span>
                    <span wire:loading wire:target="add2Cart({{ $product->id }})">
                        <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                        Добавляем
                    </span>
                </button>
            @else
                <span class="shopmi-kicker mt-auto">Нет в наличии</span>
            @endif
        </div>
    </article>
</div>
