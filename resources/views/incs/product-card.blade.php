<div class="item" wire:key="{{ $product->id }}">
    <div class="card h-100 home-product-card position-relative">
        {{-- Значок ХИТ --}}
        @if ($product->is_hit)
            <span class="position-absolute top-0 start-0 badge bg-danger m-2">HIT</span>
        @endif

        {{-- Значок НОВИНКА --}}
        @if ($product->is_new)
            <span class="position-absolute top-0 end-0 badge bg-success m-2">NEW</span>
        @endif

        {{-- Ссылка на товар --}}
        <a href="{{ route('product', $product->slug) }}">
            @php
                $imageNumber = (($product->id - 1) % 45) + 1;
            @endphp
            <img src="{{ asset('img/products/' . $imageNumber . '.jpg') }}" alt="{{ $product->title }}"
                class="card-img-top" style="height: 200px; object-fit: cover;">
        </a>

        <div class="card-body text-center d-flex flex-column">

            <a href="{{ route('product', $product->slug) }}">
                <h5 class="card-title"
                    style="height: 60px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                    {{ $product->title }}
                </h5>
            </a>

            <p class="card-text mb-2">${{ number_format($product->price, 2) }}</p>

            <div class="mt-auto">
                <button wire:click="add2Cart({{ $product->id }})" wire:loading.attr="disabled"
                    class="btn btn-outline-primary btn-sm add-to-cart">
                    <div wire:loading.remove wire:target="add2Cart({{ $product->id }})">
                        <i class="fas fa-shopping-cart me-1"></i> В корзину
                    </div>
                    <div wire:loading wire:target="add2Cart({{ $product->id }})">
                        <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                        <span role="status">Loading...</span>
                    </div>
                </button>
            </div>
        </div>
    </div>

    {{-- НОВЫЙ БЛОК PRODUCT-DETAILS --}}
    <div class="product-details">
        <!-- Тут будет контент для деталей товара -->
    </div>
</div>
