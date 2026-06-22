<div class="shopmi-page shopmi-animate-in">
    <div class="shopmi-shell">
        <ol class="shopmi-breadcrumb">
            <li><a href="{{ route('home') }}" wire:navigate>Главная</a></li>
            <li class="active">Избранное</li>
        </ol>

        <header class="shopmi-page-head">
            <p class="shopmi-kicker mb-0">Сохранённое</p>
            <h1 class="shopmi-heading">Избранное</h1>
            <p class="shopmi-subtitle">Товары, которые вы отложили для покупки позже.</p>
        </header>

        @if (count($items) > 0)
            <div class="row g-4">
                @foreach ($items as $id => $item)
                    @php $product = $products->get($id); @endphp
                    <div class="col-xl-3 col-lg-4 col-md-6" wire:key="wishlist-{{ $id }}">
                        <article class="shopmi-product-card h-100">
                            <a class="shopmi-product-media" href="{{ route('product', $item['slug']) }}" wire:navigate>
                                <img src="{{ $item['image'] ?? asset('img/no-image.jpg') }}" alt="{{ $item['title'] }}" loading="lazy">
                            </a>
                            <div class="shopmi-product-body">
                                <a href="{{ route('product', $item['slug']) }}" wire:navigate>
                                    <h3 class="shopmi-card-title">{{ $item['title'] }}</h3>
                                </a>
                                <div class="shopmi-price">
                                    <span>${{ number_format($item['price'], 2) }}</span>
                                </div>
                                <div class="d-flex flex-column gap-2 mt-auto">
                                    @if ($product && $product->inStock())
                                        <button class="shopmi-btn shopmi-btn-outline" wire:click="add2Cart({{ $id }})" wire:loading.attr="disabled">
                                            <i class="fas fa-shopping-bag"></i> В корзину
                                        </button>
                                    @else
                                        <span class="small text-muted">Нет в наличии</span>
                                    @endif
                                    <button class="shopmi-btn shopmi-btn-outline" wire:click="removeFromWishlist({{ $id }})">
                                        <i class="fas fa-heart-crack"></i> Убрать
                                    </button>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        @else
            <div class="shopmi-empty">
                <i class="fas fa-heart fa-3x"></i>
                <h2 class="shopmi-title">Избранное пусто</h2>
                <p class="shopmi-subtitle mx-auto">Нажмите на сердечко у товара, чтобы сохранить его здесь.</p>
                <a href="{{ route('home') }}" class="shopmi-btn mt-4" wire:navigate>
                    <i class="fas fa-store"></i> В каталог
                </a>
            </div>
        @endif
    </div>
</div>
