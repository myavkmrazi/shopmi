{{-- resources/views/livewire/home-component.blade.php --}}
<div>
    @push('head')
        <style>
            /* Уточняем селекторы чтобы не конфликтовать с Bootstrap */
            .home-component .card-img-top {
                object-fit: cover;
                height: 220px;
            }

            /* Фиксированная высота для названия товара */
            .home-component .home-product-card .card-title {
                height: 60px;
                overflow: hidden;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                line-height: 1.3;
            }

            .home-component .product-price .old-price {
                text-decoration: line-through;
                color: #888;
                margin-right: .5rem;
            }

            .home-component .product-price .current-price {
                color: #0d6efd;
                font-weight: 600;
            }

            /* Owl Carousel стили с более специфичными селекторами */
            .home-component .owl-carousel .item {
                padding: 0 15px;
                /* Увеличил отступ между карточками */
            }

            .home-component .owl-carousel .item img {
                width: 100%;
                height: 200px;
                object-fit: cover;
                border-radius: 8px;
            }

            .home-component .owl-nav {
                display: block !important;
            }

            .home-component .owl-nav button {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                background: rgba(0, 0, 0, 0.7) !important;
                color: white !important;
                border: none !important;
                padding: 14px 18px !important;
                /* Увеличил кнопки */
                border-radius: 50%;
                font-size: 20px !important;
                width: 50px;
                /* Увеличил размер */
                height: 50px;
                display: flex !important;
                align-items: center;
                justify-content: center;
                transition: all 0.3s ease;
            }

            .home-component .owl-nav button:hover {
                background: rgba(0, 0, 0, 0.9) !important;
                transform: translateY(-50%) scale(1.1);
            }

            /* ОТОДВИНУЛ СТРЕЛКИ ПОДАЛЬШЕ ОТ КАРУСЕЛИ */
            .home-component .owl-nav button.owl-prev {
                left: -40px;
                /* Увеличил отступ */
            }

            .home-component .owl-nav button.owl-next {
                right: -40px;
                /* Увеличил отступ */
            }

            .home-component .owl-dots {
                text-align: center;
                margin-top: 25px;
                display: block !important;
            }

            .home-component .owl-dot {
                display: inline-block;
                margin: 0 6px;
                width: 14px;
                height: 14px;
                border-radius: 50%;
                background: #ddd !important;
                transition: all 0.3s ease;
            }

            .home-component .owl-dot.active {
                background: #0d6efd !important;
                transform: scale(1.2);
            }

            /* Адаптивность */
            @media (max-width: 1200px) {
                .home-component .owl-nav button.owl-prev {
                    left: -25px;
                }

                .home-component .owl-nav button.owl-next {
                    right: -25px;
                }
            }

            @media (max-width: 768px) {
                .home-component .owl-nav button {
                    padding: 10px 14px !important;
                    width: 40px;
                    height: 40px;
                    font-size: 16px !important;
                }

                .home-component .owl-nav button.owl-prev {
                    left: -15px;
                }

                .home-component .owl-nav button.owl-next {
                    right: -15px;
                }

                .home-component .owl-carousel .item {
                    padding: 0 10px;
                }
            }

            @media (max-width: 576px) {
                .home-component .owl-nav {
                    display: none !important;
                    /* Скрываем стрелки на очень маленьких экранах */
                }
            }

            /* ШИРОКИЙ КОНТЕЙНЕР ДЛЯ КОНТЕНТА */
            .home-component .container-wide {
                max-width: 1400px;
                margin: 0 auto;
                padding-left: 25px;
                padding-right: 25px;
            }
        </style>
    @endpush
    {{-- Убираем my-5 и добавляем класс для специфичности --}}
    <div class="container home-component">
        @section('metatags')
            <title>{{ config('app.name') . ' :: ' . ($title ?? 'Page Title') }}</title>
            <meta name="description" content="{{ $desc ?? 'default...' }}">
        @endsection

        {{-- --- Bootstrap carousel (hero) --- --}}
        <div id="carousel" class="carousel slide carousel-fade mb-4" data-bs-ride="carousel" aria-label="Главная карусель">
            {{-- ... остальной код карусели без изменений ... --}}
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carousel" data-bs-slide-to="0" class="active"
                    aria-current="true"></button>
                <button type="button" data-bs-target="#carousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#carousel" data-bs-slide-to="2"></button>
            </div>

            <div class="carousel-inner rounded-3 shadow-sm">
                <div class="carousel-item active">
                    <img src="{{ asset('img/banners/banner3.jpg') }}" class="d-block w-100" alt="Слайд 1">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Заголовок слайда 1</h5>
                        <p>Короткое описание или CTA.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/banners/banner2 (1).jpg') }}" class="d-block w-100" alt="Слайд 2">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Заголовок слайда 2</h5>
                        <p>Короткое описание или CTA.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/banners/banner4.jpg') }}" class="d-block w-100" alt="Слайд 3">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Заголовок слайда 3</h5>
                        <p>Короткое описание или CTA.</p>
                    </div>
                </div>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Предыдущий</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Следующий</span>
            </button>
        </div>

        {{-- --- Преимущества --- --}}
        <section class="advantages section-bg rounded-3 mb-4" aria-labelledby="advantagesTitle">
            <h2 id="advantagesTitle" class="section-title">Преимущества</h2>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="p-3 bg-white rounded shadow-sm h-100">
                        <h5>Быстро</h5>
                        <p class="mb-0">Короткое описание преимущества №1.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-white rounded shadow-sm h-100">
                        <h5>Надёжно</h5>
                        <p class="mb-0">Короткое описание преимущества №2.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-white rounded shadow-sm h-100">
                        <h5>Поддержка</h5>
                        <p class="mb-0">Короткое описание преимущества №3.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- --- Рекомендуемые товары --- --}}
        @if ($hits_products->isNotEmpty())
            <section class="featured-products mb-4" aria-labelledby="featuredTitle">
                <h2 id="featuredTitle" class="section-title">Рекомендуемые товары</h2>
                <div class="owl-carousel owl-theme" wire:ignore>
                    @foreach ($hits_products as $product)
                        @include('incs.product-card', ['product' => $product])
                    @endforeach
                </div>
            </section>
        @endif

        {{-- --- Новые поступления (OwlCarousel) --- --}}
        @if ($new_products->isNotEmpty())
            <section class="new-products section-bg mb-4" aria-labelledby="newProductsTitle">
                <h2 id="newProductsTitle" class="section-title">Новинки</h2>
                <div class="owl-carousel owl-theme" wire:ignore>
                    @foreach ($new_products as $product)
                        @include('incs.product-card', ['product' => $product])
                    @endforeach
                </div>
            </section>
        @endif

        {{-- --- О нас --- --}}
        <section class="about-us mb-4" id="about" aria-labelledby="aboutTitle">
            <h2 id="aboutTitle" class="section-title">О нас</h2>
            <p>Короткий текст про компанию / проект. Здесь можно вставить миссию, контактные данные и т.д.</p>
        </section>

        {{-- --- Карта --- --}}
        <section class="mb-4 text-center" aria-labelledby="mapTitle">
            <h2 id="mapTitle" class="section-title">Где нас найти</h2>
            <iframe id="map" src="https://www.google.com/maps/embed?pb=" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade" aria-label="Карта расположения"
                style="width: 85%; height: 400px; border:0; border-radius: 10px; display:block; margin: 0 auto;">
            </iframe>
        </section>
    </div>

    @if (session('success'))
        @script
            <script>
                toastr.success('{{ session('success') }}');
            </script>
        @endscript
    @endif
</div>
