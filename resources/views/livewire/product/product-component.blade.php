{{-- В начале файла --}}
<div> {{-- ОДИН корневой элемент --}}
    <div class="product-page">
        <div class="container py-5">
            <div class="product-page">
                <div class="container py-5">
                    {{-- Хлебные крошки --}}
                    <nav aria-label="breadcrumb" class="mb-4">
                        <!-- ... хлебные крошки ... -->
                    </nav>

                    {{-- ПЕРВЫЙ ROW: Изображение и информация --}}
                    <div class="row">
                        {{-- Галерея --}}
                        <div class="col-lg-6 mb-4">
                            @php
                                $allImages = [];
                                if ($product->image) {
                                    $allImages[] = str_replace('public/', '', $product->image);
                                }
                                if (!empty($product->galery)) {
                                    foreach ($product->galery as $image) {
                                        $allImages[] = str_replace('public/', '', $image);
                                    }
                                }
                                if (empty($allImages)) {
                                    $allImages[] = 'img/no-image.jpg';
                                }
                            @endphp

                            <div class="product-gallery position-relative">
                                <div class="main-image-container mb-3"
                                    style="height: 500px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 10px; padding: 20px; position: relative;">

                                    <img id="mainImage" src="{{ asset($allImages[0]) }}" alt="{{ $product->title }}"
                                        style="max-height: 100%; max-width: 100%; object-fit: contain;"
                                        onerror="this.src='{{ asset('img/no-image.jpg') }}'">

                                    @if (count($allImages) > 1)
                                        <button class="gallery-arrow arrow-left" onclick="prevImage()">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <button class="gallery-arrow arrow-right" onclick="nextImage()">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>

                                        <div class="image-counter">
                                            <span id="currentImg">1</span>/<span
                                                id="totalImg">{{ count($allImages) }}</span>
                                        </div>
                                    @endif
                                </div>

                                @if (count($allImages) > 1)
                                    <div class="thumbnails-container d-flex overflow-auto py-2">
                                        @foreach ($allImages as $index => $image)
                                            <div class="thumbnail-item me-2 {{ $index === 0 ? 'active' : '' }}"
                                                onclick="showImage({{ $index }})">
                                                <img src="{{ asset($image) }}" alt="Thumb {{ $index + 1 }}"
                                                    style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;"
                                                    onerror="this.src='{{ asset('img/no-image.jpg') }}'">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Информация --}}
                        <div class="col-lg-6">
                            <h1 class="h2 mb-3">{{ $product->title }}</h1>
                            <h3 class="text-primary mb-4">${{ number_format($product->price, 2) }}</h3>
                            @if ($product->old_price && $product->old_price > $product->price)
                                <p class="text-muted text-decoration-line-through mb-1">
                                    ${{ number_format($product->old_price, 2) }}</p>
                            @endif
                            <p class="text-muted mb-4">{{ $product->excerpt ?? 'Описание товара появится скоро...' }}
                            </p>

                            <div class="row align-items-center mb-4">
                                <div class="col-auto">
                                    <label class="form-label fw-bold">Количество:</label>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group" style="width: 140px;">
                                        <button class="btn btn-outline-secondary"
                                            wire:click="decrementQuantity">-</button>
                                        <input type="number" class="form-control text-center"
                                            value="{{ $quantity }}" wire:model="quantity" min="1">
                                        <button class="btn btn-outline-secondary"
                                            wire:click="incrementQuantity">+</button>
                                    </div>
                                </div>
                                <div class="col">
                                    <button class="btn btn-primary btn-lg w-100"
                                        wire:click="addCart({{ $product->id }})" wire:loading.attr="disabled">
                                        <i class="fas fa-shopping-cart me-2"></i>
                                        <span wire:loading.remove>Добавить в корзину</span>
                                        <span wire:loading>Добавляем...</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div> {{-- ЗАКРЫВАЕМ ПЕРВЫЙ ROW --}}

                    {{-- ВТОРОЙ ROW: Табы --}}
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    {{-- Табы --}}
                                    <ul class="nav nav-tabs mb-4" id="productTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                                data-bs-target="#description" type="button" role="tab"
                                                aria-controls="description" aria-selected="true">
                                                Описание
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="attributes-tab" data-bs-toggle="tab"
                                                data-bs-target="#attributes" type="button" role="tab"
                                                aria-controls="attributes" aria-selected="false">
                                                Характеристики
                                            </button>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="productTabsContent">
                                        <div class="tab-pane fade show active" id="description" role="tabpanel"
                                            aria-labelledby="description-tab">
                                            @if ($product->content)
                                                <div class="product-content">
                                                    {!! $product->content !!}
                                                </div>
                                            @else
                                                <p class="text-muted">Описание товара отсутствует.</p>
                                            @endif
                                        </div>

                                        <div class="tab-pane fade" id="attributes" role="tabpanel"
                                            aria-labelledby="attributes-tab">
                                            @if (!empty($this->productAttributes))
                                                <div class="attributes-list">
                                                    @foreach ($this->productAttributes as $attribute)
                                                        <div class="row mb-2">
                                                            <div class="col-md-4 fw-bold">
                                                                {{ $attribute['filter_groups_title'] }}:
                                                            </div>
                                                            <div class="col-md-8">
                                                                {{ $attribute['filters_title'] }}
                                                            </div>
                                                        </div>
                                                        @if (!$loop->last)
                                                            <hr class="my-2">
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-muted">Характеристики товара отсутствуют.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ТРЕТИЙ ROW: Блоки информации --}}
                    <div class="row mt-5">
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="text-primary mb-3">
                                        <i class="fas fa-shield-alt fa-2x"></i>
                                    </div>
                                    <h5>Гарантия качества</h5>
                                    <ul class="list-unstyled text-start">
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Гарантия 1
                                            год</li>
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Возврат в
                                            течение 14 дней</li>
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Оригинальное
                                            качество</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Сертифицированный товар</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="text-info mb-3">
                                        <i class="fas fa-truck fa-2x"></i>
                                    </div>
                                    <h5>Доставка</h5>
                                    <ul class="list-unstyled text-start">
                                        <li class="mb-2"><i
                                                class="fas fa-shipping-fast text-info me-2"></i>Бесплатная доставка
                                        </li>
                                        <li class="mb-2"><i class="fas fa-clock text-info me-2"></i>1-3 рабочих дня
                                        </li>
                                        <li class="mb-2"><i class="fas fa-map-marker-alt text-info me-2"></i>По всей
                                            стране</li>
                                        <li><i class="fas fa-box text-info me-2"></i>Надежная упаковка</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="text-success mb-3">
                                        <i class="fas fa-credit-card fa-2x"></i>
                                    </div>
                                    <h5>Оплата</h5>
                                    <ul class="list-unstyled text-start">
                                        <li class="mb-2"><i
                                                class="fas fa-money-bill-wave text-success me-2"></i>Наличными при
                                            получении</li>
                                        <li class="mb-2"><i
                                                class="fas fa-credit-card text-success me-2"></i>Банковской картой</li>
                                        <li class="mb-2"><i
                                                class="fab fa-cc-paypal text-success me-2"></i>Электронные платежи</li>
                                        <li><i class="fas fa-mobile-alt text-success me-2"></i>Онлайн перевод</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ЧЕТВЕРТЫЙ ROW: Похожие товары --}}
                    @if ($related_product && count($related_product) > 0)
                        <div class="row mt-5">
                            <div class="col-12">
                                <div class="related-products">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h3 class="mb-0">Похожие товары</h3>
                                        <div class="owl-nav-custom">
                                            <button class="btn btn-outline-primary btn-sm owl-prev-custom">
                                                <i class="fas fa-chevron-left"></i>
                                            </button>
                                            <button class="btn btn-outline-primary btn-sm owl-next-custom ms-2">
                                                <i class="fas fa-chevron-right"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="owl-carousel owl-theme">
                                        @foreach ($related_product as $related)
                                            <div class="item">
                                                <div class="card h-100 border-0 shadow-sm">
                                                    <a href="{{ route('product', $related->slug) }}" wire:navigate>
                                                        @if (!empty($related->galery) && count($related->galery) > 0)
                                                            @php
                                                                $relatedImage = str_replace(
                                                                    'public/',
                                                                    '',
                                                                    $related->galery[0],
                                                                );
                                                            @endphp
                                                            <img src="{{ asset($relatedImage) }}"
                                                                class="card-img-top"
                                                                style="height: 200px; object-fit: cover;"
                                                                alt="{{ $related->title }}"
                                                                onerror="this.src='{{ asset('img/no-image.jpg') }}'">
                                                        @else
                                                            <img src="{{ asset('img/no-image.jpg') }}"
                                                                class="card-img-top"
                                                                style="height: 200px; object-fit: cover;"
                                                                alt="{{ $related->title }}">
                                                        @endif
                                                    </a>
                                                    <div class="card-body p-3">
                                                        <h6 class="card-title mb-2">{{ $related->title }}</h6>
                                                        <p class="card-text text-primary fw-bold mb-2">
                                                            ${{ number_format($related->price, 2) }}</p>
                                                        <button class="btn btn-outline-primary btn-sm w-100"
                                                            wire:click="add2Cart({{ $related->id }})">
                                                            В корзину
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

            {{-- Стили и скрипты вынеси вниз --}}
            <style>
                .gallery-arrow {
                    position: absolute;
                    top: 50%;
                    transform: translateY(-50%);
                    width: 40px;
                    height: 40px;
                    background: white;
                    border: 1px solid #ddd;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    cursor: pointer;
                    transition: all 0.3s;
                    z-index: 10;
                }

                .gallery-arrow:hover {
                    background: #f8f9fa;
                    border-color: #007bff;
                }

                .arrow-left {
                    left: 10px;
                }

                .arrow-right {
                    right: 10px;
                }

                .image-counter {
                    position: absolute;
                    bottom: 10px;
                    left: 50%;
                    transform: translateX(-50%);
                    background: rgba(0, 0, 0, 0.7);
                    color: white;
                    padding: 4px 12px;
                    border-radius: 20px;
                    font-size: 14px;
                }

                .thumbnail-item {
                    cursor: pointer;
                    border: 3px solid transparent;
                    border-radius: 8px;
                    transition: all 0.3s;
                    flex-shrink: 0;
                }

                .thumbnail-item:hover {
                    border-color: #dee2e6;
                }

                .thumbnail-item.active {
                    border-color: #007bff;
                }

                .thumbnails-container {
                    scrollbar-width: thin;
                }

                .thumbnails-container::-webkit-scrollbar {
                    height: 6px;
                }

                .thumbnails-container::-webkit-scrollbar-track {
                    background: #f1f1f1;
                    border-radius: 3px;
                }

                .thumbnails-container::-webkit-scrollbar-thumb {
                    background: #888;
                    border-radius: 3px;
                }

                .thumbnails-container::-webkit-scrollbar-thumb:hover {
                    background: #555;
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
                        thumb.classList.toggle('active', i === index);
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
            </script>

            <script>
                window.addEventListener('load', function() {
                    if (typeof $.fn.owlCarousel === 'undefined') {
                        console.error('Owl Carousel not loaded!');
                        return;
                    }

                    var owl = $('.owl-carousel').owlCarousel({
                        loop: true,
                        margin: 10,
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
                            },
                            1200: {
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
    </div>
</div> {{-- Закрывающий тег в самом конце --}}
