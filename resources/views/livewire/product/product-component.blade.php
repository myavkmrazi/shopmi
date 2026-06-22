{{-- В начале файла --}}
<div>
    <div class="product-page">
        <div class="container py-5">

            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb" style="background: none; padding: 0; margin: 0;">
                    <li class="breadcrumb-item">
                        <a href="/"
                            style="color: #0f0f10; text-decoration: none; font-family: 'Oswald', sans-serif; letter-spacing: 1px; font-size: 14px;">ГЛАВНАЯ</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/catalog"
                            style="color: #0f0f10; text-decoration: none; font-family: 'Oswald', sans-serif; letter-spacing: 1px; font-size: 14px;">КАТАЛОГ</a>
                    </li>
                    <li class="breadcrumb-item active"
                        style="color: #777; font-family: 'Oswald', sans-serif; letter-spacing: 1px; font-size: 14px;"
                        aria-current="page">{{ $product->title }}</li>
                </ol>
            </nav>


            <div class="row g-5">
                <div class="col-lg-6 mb-4">
                    @php
                        $allImages = [];
                        if ($product->image) {
                            $allImages[] = str_replace('public/', '', $product->image);
                        }
                        if (!empty($product->gallery)) {
                            foreach ($product->gallery as $image) {
                                $allImages[] = str_replace('public/', '', $image);
                            }
                        }
                        if (empty($allImages)) {
                            $allImages[] = 'img/no-image.jpg';
                        }
                    @endphp

                    <div class="product-gallery">
                        <div class="main-image-container mb-3"
                            style="border: 1px solid #e5e5e5; background: #fff; padding: 2rem; position: relative;">

                            <img id="mainImage" src="{{ asset($allImages[0]) }}" alt="{{ $product->title }}"
                                style="width: 100%; height: 500px; object-fit: contain; display: block;"
                                onerror="this.src='{{ asset('img/no-image.jpg') }}'">

                            @if (count($allImages) > 1)
                                <button class="gallery-arrow arrow-left" onclick="prevImage()"
                                    style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); background: white; border: 1px solid #e5e5e5; width: 40px; height: 40px; cursor: pointer; transition: all 0.3s;">
                                    <i class="fas fa-chevron-left" style="color: #0f0f10;"></i>
                                </button>
                                <button class="gallery-arrow arrow-right" onclick="nextImage()"
                                    style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: white; border: 1px solid #e5e5e5; width: 40px; height: 40px; cursor: pointer; transition: all 0.3s;">
                                    <i class="fas fa-chevron-right" style="color: #0f0f10;"></i>
                                </button>

                                <div class="image-counter"
                                    style="position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%); background: #0f0f10; color: white; padding: 4px 16px; font-family: 'Oswald', sans-serif; letter-spacing: 1px; font-size: 14px;">
                                    <span id="currentImg">1</span>/<span id="totalImg">{{ count($allImages) }}</span>
                                </div>
                            @endif
                        </div>

                        @if (count($allImages) > 1)
                            <div class="thumbnails-container d-flex gap-2"
                                style="overflow-x: auto; padding-bottom: 5px;">
                                @foreach ($allImages as $index => $image)
                                    <div class="thumbnail-item {{ $index === 0 ? 'active' : '' }}"
                                        onclick="showImage({{ $index }})"
                                        style="border: 1px solid {{ $index === 0 ? '#0f0f10' : '#e5e5e5' }}; width: 80px; height: 80px; flex-shrink: 0; cursor: pointer; transition: border 0.3s;">
                                        <img src="{{ asset($image) }}" alt="Thumb {{ $index + 1 }}"
                                            style="width: 100%; height: 100%; object-fit: cover; display: block;"
                                            onerror="this.src='{{ asset('img/no-image.jpg') }}'">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-6">
                    <h1
                        style="font-family: 'Oswald', sans-serif; font-size: 48px; letter-spacing: 2px; margin-bottom: 1rem; color: #0f0f10;">
                        {{ $product->title }}
                    </h1>

                    <div style="margin-bottom: 1.5rem;">
                        <span
                            style="font-family: 'Oswald', sans-serif; font-size: 36px; letter-spacing: 2px; color: #0f0f10;">
                            ${{ number_format($product->price, 2) }}
                        </span>
                        @if ($product->old_price && $product->old_price > $product->price)
                            <span
                                style="font-family: 'Oswald', sans-serif; font-size: 24px; letter-spacing: 1px; color: #777; text-decoration: line-through; margin-left: 15px;">
                                ${{ number_format($product->old_price, 2) }}
                            </span>
                        @endif
                    </div>

                    <p
                        style="color: #555; letter-spacing: 0.5px; line-height: 1.6; margin-bottom: 2rem; border-bottom: 1px solid #e5e5e5; padding-bottom: 1.5rem;">
                        {{ $product->excerpt ?? 'Описание товара появится скоро...' }}
                    </p>

                    <div style="border: 1px solid #e5e5e5; padding: 1.5rem; margin-bottom: 2rem;">
                        <div class="row align-items-center g-3">
                            <div class="col-auto">
                                <label
                                    style="font-family: 'Oswald', sans-serif; font-size: 16px; letter-spacing: 1px; color: #0f0f10;">КОЛИЧЕСТВО:</label>
                            </div>
                            <div class="col-auto">
                                <div class="d-flex" style="border: 1px solid #e5e5e5;">
                                    <button class="btn" wire:click="decrementQuantity"
                                        style="border: none; border-radius: 0; padding: 0.5rem 1rem; background: transparent; color: #0f0f10;">
                                        <i class="fas fa-minus" style="font-size: 12px;"></i>
                                    </button>
                                    <input type="number" class="form-control text-center" value="{{ $quantity }}"
                                        wire:model="quantity" min="1"
                                        style="border: none; border-left: 1px solid #e5e5e5; border-right: 1px solid #e5e5e5; border-radius: 0; width: 80px; font-family: 'Oswald', sans-serif; letter-spacing: 1px;">
                                    <button class="btn" wire:click="incrementQuantity"
                                        style="border: none; border-radius: 0; padding: 0.5rem 1rem; background: transparent; color: #0f0f10;">
                                        <i class="fas fa-plus" style="font-size: 12px;"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col">
                                <button class="btn w-100" wire:click="addCart({{ $product->id }})"
                                    wire:loading.attr="disabled"
                                    style="background: #7FFF00; color: rgb(0, 0, 0); border-radius: 0%; border: none; padding: 1rem; font-family: 'Oswald', sans-serif; font-size: 18px; letter-spacing: 2px; cursor: pointer; transition: background 0.3s;">
                                    <span wire:loading.remove>ДОБАВИТЬ В КОРЗИНУ</span>
                                    <span wire:loading>ДОБАВЛЯЕМ...</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <div style="border: 1px solid #e5e5e5; background: #fff;">
                        {{-- Табы --}}
                        <ul class="nav"
                            style="border-bottom: 1px solid #e5e5e5; display: flex; list-style: none; margin: 0; padding: 0;">
                            <li class="nav-item" style="margin: 0;">
                                <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                    data-bs-target="#description" type="button" role="tab"
                                    style="font-family: 'Oswald', sans-serif; font-size: 18px; letter-spacing: 2px; padding: 1rem 2rem; background: none; border: none; border-right: 1px solid #e5e5e5; color: #0f0f10; cursor: pointer; {{-- активный стиль --}} border-bottom: 2px solid #0f0f10;">
                                    ОПИСАНИЕ
                                </button>
                            </li>
                            <li class="nav-item" style="margin: 0;">
                                <button class="nav-link" id="attributes-tab" data-bs-toggle="tab"
                                    data-bs-target="#attributes" type="button" role="tab"
                                    style="font-family: 'Oswald', sans-serif; font-size: 18px; letter-spacing: 2px; padding: 1rem 2rem; background: none; border: none; border-right: 1px solid #e5e5e5; color: #777; cursor: pointer;">
                                    ХАРАКТЕРИСТИКИ
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" style="padding: 2rem;">
                            <div class="tab-pane fade show active" id="description" role="tabpanel">
                                @if ($product->content)
                                    <div class="product-content" style="color: #555; line-height: 1.8;">
                                        {!! $product->content !!}
                                    </div>
                                @else
                                    <p style="color: #777; letter-spacing: 0.5px;">Описание товара отсутствует.</p>
                                @endif
                            </div>

                            <div class="tab-pane fade" id="attributes" role="tabpanel">
                                @if (!empty($this->productAttributes))
                                    <div class="attributes-list">
                                        @foreach ($this->productAttributes as $attribute)
                                            <div class="row mb-3">
                                                <div class="col-md-4"
                                                    style="font-family: 'Oswald', sans-serif; font-size: 16px; letter-spacing: 1px; color: #0f0f10;">
                                                    {{ $attribute['filter_groups_title'] }}:
                                                </div>
                                                <div class="col-md-8" style="color: #555;">
                                                    {{ $attribute['filters_title'] }}
                                                </div>
                                            </div>
                                            @if (!$loop->last)
                                                <hr style="border-color: #e5e5e5; margin: 1rem 0;">
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <p style="color: #777; letter-spacing: 0.5px;">Характеристики товара отсутствуют.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5 g-4">
                <div class="col-md-4">
                    <div style="border: 1px solid #e5e5e5; padding: 2rem; height: 100%;">
                        <div style="margin-bottom: 1.5rem;">
                            <i class="fas fa-shield-alt" style="font-size: 32px; color: #0f0f10;"></i>
                        </div>
                        <h5
                            style="font-family: 'Oswald', sans-serif; font-size: 24px; letter-spacing: 2px; margin-bottom: 1.5rem;">
                            ГАРАНТИЯ</h5>
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            <li style="margin-bottom: 0.75rem; color: #555; letter-spacing: 0.5px;"><i
                                    class="fas fa-check me-2" style="color: #0f0f10;"></i>Гарантия 1 год</li>
                            <li style="margin-bottom: 0.75rem; color: #555; letter-spacing: 0.5px;"><i
                                    class="fas fa-check me-2" style="color: #0f0f10;"></i>Возврат 14 дней</li>
                            <li style="margin-bottom: 0.75rem; color: #555; letter-spacing: 0.5px;"><i
                                    class="fas fa-check me-2" style="color: #0f0f10;"></i>Оригинальное качество</li>
                            <li style="color: #555; letter-spacing: 0.5px;"><i class="fas fa-check me-2"
                                    style="color: #0f0f10;"></i>Сертифицированный товар</li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4">
                    <div style="border: 1px solid #e5e5e5; padding: 2rem; height: 100%;">
                        <div style="margin-bottom: 1.5rem;">
                            <i class="fas fa-truck" style="font-size: 32px; color: #0f0f10;"></i>
                        </div>
                        <h5
                            style="font-family: 'Oswald', sans-serif; font-size: 24px; letter-spacing: 2px; margin-bottom: 1.5rem;">
                            ДОСТАВКА</h5>
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            <li style="margin-bottom: 0.75rem; color: #555; letter-spacing: 0.5px;"><i
                                    class="fas fa-shipping-fast me-2" style="color: #0f0f10;"></i>Бесплатная доставка
                            </li>
                            <li style="margin-bottom: 0.75rem; color: #555; letter-spacing: 0.5px;"><i
                                    class="fas fa-clock me-2" style="color: #0f0f10;"></i>1-3 рабочих дня</li>
                            <li style="margin-bottom: 0.75rem; color: #555; letter-spacing: 0.5px;"><i
                                    class="fas fa-map-marker-alt me-2" style="color: #0f0f10;"></i>По всей стране</li>
                            <li style="color: #555; letter-spacing: 0.5px;"><i class="fas fa-box me-2"
                                    style="color: #0f0f10;"></i>Надежная упаковка</li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4">
                    <div style="border: 1px solid #e5e5e5; padding: 2rem; height: 100%;">
                        <div style="margin-bottom: 1.5rem;">
                            <i class="fas fa-credit-card" style="font-size: 32px; color: #0f0f10;"></i>
                        </div>
                        <h5
                            style="font-family: 'Oswald', sans-serif; font-size: 24px; letter-spacing: 2px; margin-bottom: 1.5rem;">
                            ОПЛАТА</h5>
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            <li style="margin-bottom: 0.75rem; color: #555; letter-spacing: 0.5px;"><i
                                    class="fas fa-money-bill-wave me-2" style="color: #0f0f10;"></i>Наличными</li>
                            <li style="margin-bottom: 0.75rem; color: #555; letter-spacing: 0.5px;"><i
                                    class="fas fa-credit-card me-2" style="color: #0f0f10;"></i>Банковской картой</li>
                            <li style="margin-bottom: 0.75rem; color: #555; letter-spacing: 0.5px;"><i
                                    class="fab fa-cc-paypal me-2" style="color: #0f0f10;"></i>Электронные платежи</li>
                            <li style="color: #555; letter-spacing: 0.5px;"><i class="fas fa-mobile-alt me-2"
                                    style="color: #0f0f10;"></i>Онлайн перевод</li>
                        </ul>
                    </div>
                </div>
            </div>

            @if ($related_product && count($related_product) > 0)
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="related-products">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3
                                    style="font-family: 'Oswald', sans-serif; font-size: 32px; letter-spacing: 2px; margin: 0;">
                                    ПОХОЖИЕ ТОВАРЫ</h3>
                                <div class="owl-nav-custom">
                                    <button class="btn owl-prev-custom"
                                        style="border: 1px solid #e5e5e5; background: white; width: 40px; height: 40px; padding: 0; margin-right: 0.5rem;">
                                        <i class="fas fa-chevron-left" style="color: #0f0f10;"></i>
                                    </button>
                                    <button class="btn owl-next-custom"
                                        style="border: 1px solid #e5e5e5; background: white; width: 40px; height: 40px; padding: 0;">
                                        <i class="fas fa-chevron-right" style="color: #0f0f10;"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="owl-carousel owl-theme">
                                @foreach ($related_product as $related)
                                    <div class="item">
                                        <div style="border: 1px solid #e5e5e5; background: #fff; height: 100%;">
                                            <a href="{{ route('product', $related->slug) }}" wire:navigate
                                                style="text-decoration: none; color: inherit;">
                                                @if (!empty($related->gallery) && count($related->gallery) > 0)
                                                    @php
                                                        $relatedImage = str_replace('public/', '', $related->gallery[0]);
                                                    @endphp
                                                    <img src="{{ asset($relatedImage) }}"
                                                        style="width: 100%; height: 250px; object-fit: cover; display: block; border-bottom: 1px solid #e5e5e5;"
                                                        alt="{{ $related->title }}"
                                                        onerror="this.src='{{ asset('img/no-image.jpg') }}'">
                                                @else
                                                    <img src="{{ asset('img/no-image.jpg') }}"
                                                        style="width: 100%; height: 250px; object-fit: cover; display: block; border-bottom: 1px solid #e5e5e5;"
                                                        alt="{{ $related->title }}">
                                                @endif
                                            </a>
                                            <div style="padding: 1.5rem;">
                                                <a href="{{ route('product', $related->slug) }}" wire:navigate
                                                    style="text-decoration: none; color: inherit;">
                                                    <h6
                                                        style="font-family: 'Oswald', sans-serif; font-size: 18px; letter-spacing: 1px; margin-bottom: 0.5rem; color: #0f0f10;">
                                                        {{ $related->title }}
                                                    </h6>
                                                </a>
                                                <p
                                                    style="font-family: 'Oswald', sans-serif; font-size: 20px; letter-spacing: 1px; color: #0f0f10; margin-bottom: 1rem;">
                                                    ${{ number_format($related->price, 2) }}
                                                </p>
                                                <button class="btn w-100" wire:click="add2Cart({{ $related->id }})"
                                                    style="border: 1px solid #0f0f10; background: transparent; color: #0f0f10; padding: 0.75rem; font-family: 'Oswald', sans-serif; font-size: 16px; letter-spacing: 1px; cursor: pointer; transition: all 0.3s;">
                                                    В КОРЗИНУ
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        .gallery-arrow:hover {
            background: #f8f8f8 !important;
            border-color: #0f0f10 !important;
        }

        .thumbnail-item:hover {
            border-color: #0f0f10 !important;
        }

        .nav-link:hover {
            color: #0f0f10 !important;
        }

        .nav-link.active {
            color: #0f0f10 !important;
            border-bottom: 2px solid #0f0f10 !important;
        }

        .btn:hover {
            background: #0f0f10 !important;
            color: white !important;
        }

        .btn.owl-prev-custom:hover,
        .btn.owl-next-custom:hover {
            background: #0f0f10 !important;
        }

        .btn.owl-prev-custom:hover i,
        .btn.owl-next-custom:hover i {
            color: white !important;
        }

        .thumbnails-container::-webkit-scrollbar {
            height: 4px;
        }

        .thumbnails-container::-webkit-scrollbar-track {
            background: #f5f5f5;
        }

        .thumbnails-container::-webkit-scrollbar-thumb {
            background: #0f0f10;
        }

        .thumbnails-container::-webkit-scrollbar-thumb:hover {
            background: #333;
        }

        .product-content {
            font-family: inherit;
            line-height: 1.8;
            color: #555;
        }

        .product-content h1,
        .product-content h2,
        .product-content h3,
        .product-content h4 {
            font-family: 'Oswald', sans-serif;
            letter-spacing: 1px;
            color: #0f0f10;
        }

        .product-content img {
            max-width: 100%;
            height: auto;
        }

        button {
            transition: all 0.3s ease !important;
        }

        button:active {
            transform: scale(0.98);
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "|";
            color: #e5e5e5;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>

    <script>
        let currentImageIndex = 0;
        const images = [
            @foreach ($allImages as $image)
                "{{ asset($image) }}",
            @endforeach
        ];

        function showImage(index) {
            if (index < 0 || index >= images.length) return;

            currentImageIndex = index;
            document.getElementById('mainImage').src = images[index];
            document.getElementById('currentImg').textContent = index + 1;

            document.querySelectorAll('.thumbnail-item').forEach((thumb, i) => {
                if (i === index) {
                    thumb.style.borderColor = '#0f0f10';
                } else {
                    thumb.style.borderColor = '#e5e5e5';
                }
            });

            const activeThumb = document.querySelectorAll('.thumbnail-item')[index];
            if (activeThumb) {
                activeThumb.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest',
                    inline: 'center'
                });
            }
        }

        function nextImage() {
            let nextIndex = currentImageIndex + 1;
            if (nextIndex >= images.length) nextIndex = 0;
            showImage(nextIndex);
        }

        function prevImage() {
            let prevIndex = currentImageIndex - 1;
            if (prevIndex < 0) prevIndex = images.length - 1;
            showImage(prevIndex);
        }

        document.getElementById('mainImage').addEventListener('error', function() {
            this.src = '{{ asset('img/no-image.jpg') }}';
        });

        document.addEventListener('keydown', function(e) {
            if (images.length <= 1) return;
            if (e.key === 'ArrowLeft') prevImage();
            if (e.key === 'ArrowRight') nextImage();
        });

        window.addEventListener('load', function() {
            if (typeof $.fn.owlCarousel === 'undefined') {
                console.error('Owl Carousel not loaded!');
                return;
            }

            var owl = $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 20,
                nav: false,
                dots: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    576: {
                        items: 2
                    },
                    768: {
                        items: 3
                    },
                    992: {
                        items: 4
                    }
                }
            });

            $('.owl-next-custom').click(function() {
                owl.trigger('next.owl.carousel');
            });

            $('.owl-prev-custom').click(function() {
                owl.trigger('prev.owl.carousel');
            });
        });
    </script>
</div> 
