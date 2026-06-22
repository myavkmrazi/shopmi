<div class="container-fluid home-component px-0 shopmi-reveal">
    @section('metatags')
        <title>{{ config('app.name') . ' :: ' . ($title ?? 'Главная') }}</title>
        <meta name="description" content="{{ $desc ?? 'ShopMI - streetwear магазин для портфолио' }}">
    @endsection

    <section class="home-hero" aria-label="Главный баннер">
        <img src="{{ asset('img/banners/newbanner.png') }}" class="hero-banner" alt="Urban Line">
    </section>

    <div class="container-wide">
        <section class="advantages mb-5 shopmi-reveal">
            <ul class="nav adv-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#adv-about" type="button"
                        role="tab">
                        ABOUT THIS BOUTIQUE
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#adv-ship" type="button"
                        role="tab">
                        SHIPPING
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#adv-returns" type="button"
                        role="tab">
                        RETURNS & EXCHANGES
                    </button>
                </li>
            </ul>

            <div class="tab-content adv-content">
                <div class="tab-pane fade show active" id="adv-about" role="tabpanel">
                    <h3 class="shopmi-title fs-2">ShopMI street edit</h3>
                    <p class="shopmi-subtitle mb-0">
                        Подборка вещей в минималистичном streetwear-стиле: чистые формы, резкий контраст и товары,
                        которые легко читать в каталоге.
                    </p>
                </div>
                <div class="tab-pane fade" id="adv-ship" role="tabpanel">
                    <h3 class="shopmi-title fs-2">Shipping</h3>
                    <p class="shopmi-subtitle mb-0">Быстрая обработка заказа и понятный checkout без лишних шагов.</p>
                </div>
                <div class="tab-pane fade" id="adv-returns" role="tabpanel">
                    <h3 class="shopmi-title fs-2">Returns</h3>
                    <p class="shopmi-subtitle mb-0">Возврат и обмен оформлены как спокойная часть сервиса, а не как спрятанный текст.</p>
                </div>
            </div>
        </section>

        @if ($hits_products->isNotEmpty())
            <section class="home-carousel-section featured-products section-bg mb-4 shopmi-reveal"
                aria-labelledby="featuredTitle">
                <h2 id="featuredTitle" class="section-title">Рекомендуемые товары</h2>
                <div class="home-carousel-wrap">
                    <div class="owl-carousel owl-theme" wire:ignore>
                        @foreach ($hits_products as $product)
                            @include('incs.product-card', ['product' => $product])
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        @if ($new_products->isNotEmpty())
            <section class="home-carousel-section new-products section-bg mb-4 shopmi-reveal"
                aria-labelledby="newProductsTitle">
                <h2 id="newProductsTitle" class="section-title">Новинки</h2>
                <div class="home-carousel-wrap">
                    <div class="owl-carousel owl-theme" wire:ignore>
                        @foreach ($new_products as $product)
                            @include('incs.product-card', ['product' => $product])
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <section class="section-bg mb-4 shopmi-reveal" id="about" aria-labelledby="aboutTitle">
            <h2 id="aboutTitle" class="section-title">О нас</h2>
            <p class="shopmi-subtitle mb-3">
                ShopMI выглядит как учебный магазин, но собирается по правилам реального e-commerce: единые карточки,
                понятная корзина, аккуратный checkout и визуальная система без случайных Bootstrap-кусков.
            </p>
            <a href="{{ route('home') }}" class="shopmi-btn shopmi-btn-outline">Подробнее</a>
        </section>
    </div>

    <section class="map-section-full shopmi-reveal">
        <div class="map-container container-wide">
            <div class="map-section-head">
                <p class="shopmi-kicker mb-0">Local pickup</p>
                <h2 class="section-title mb-0">Где нас найти</h2>
            </div>
            <iframe
                id="map"
                src="https://www.google.com/maps?q=Tashkent&output=embed"
                loading="lazy"
                title="Карта ShopMI"
                referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
        </div>
    </section>

    @if (session('success'))
        @script
            <script>
                toastr.success('{{ session('success') }}');
            </script>
        @endscript
    @endif
</div>
