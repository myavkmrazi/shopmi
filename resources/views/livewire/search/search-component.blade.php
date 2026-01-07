<div>
    <div class="container py-4">
        @php
            $query = $query ?? '';
            $products = $products ?? collect();
        @endphp

        <!-- Заголовок -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold">
                <i class="fas fa-search me-2 text-primary"></i>
                @if ($query)
                    Результаты поиска: "{{ $query }}"
                @else
                    Поиск товаров
                @endif
            </h1>

            @if ($products->count() > 0)
                <span class="badge bg-primary fs-6 py-2 px-3">
                    Найдено: {{ $products->total() ?? 0 }}
                </span>
            @endif
        </div>

        <!-- Форма поиска -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body">
                <form wire:submit.prevent="$refresh">
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control border-primary"
                            placeholder="Введите название товара..." wire:model.live.debounce.500ms="query">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search me-2"></i> Найти
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Результаты поиска -->
        @if ($products->count() > 0)
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
                @foreach ($products as $product)
                    @php
                        $product = (object) $product;
                        $image = $product->image ?? null;
                        $slug = $product->slug ?? '#';
                        $title = $product->title ?? ($product->name ?? 'Без названия');
                        $price = $product->price ?? 0;
                    @endphp

                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm hover-lift transition-all">
                            <!-- КАРТИНКА ТОВАРА -->
                            <div class="position-relative overflow-hidden" style="height: 220px;">
                                @if ($image)
                                    <img src="public/img/products/" class="card-img-top w-100 h-100"
                                        alt="{{ $title }}" style="object-fit: cover;"
                                        onerror="this.onerror=null; this.src='https://via.placeholder.com/300x220/667eea/ffffff?text=Товар'">
                                @else
                                    <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                @endif

                                <!-- Бейджи -->
                                <div class="position-absolute top-0 start-0 p-2">
                                    @if (isset($product->discount) && $product->discount > 0)
                                        <span class="badge bg-danger rounded-pill">
                                            -{{ $product->discount }}%
                                        </span>
                                    @endif
                                    @if (isset($product->is_new) && $product->is_new)
                                        <span class="badge bg-success rounded-pill ms-1">NEW</span>
                                    @endif
                                </div>

                                <!-- Кнопка быстрого просмотра -->
                                <div class="position-absolute bottom-0 end-0 p-2">
                                    <a href="{{ route('product', $slug) }}"
                                        class="btn btn-sm btn-light rounded-circle shadow-sm" wire:navigate
                                        title="Быстрый просмотр">
                                        <i class="fas fa-eye text-primary"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Информация о товаре -->
                            <div class="card-body d-flex flex-column">
                                @if (isset($product->category) && $product->category)
                                    <div class="small text-muted mb-1">
                                        {{ is_object($product->category) ? $product->category->name : $product->category }}
                                    </div>
                                @endif

                                <h5 class="card-title fs-6 mb-2" style="min-height: 3em;">
                                    <a href="{{ route('product', $slug) }}" class="text-decoration-none text-dark"
                                        wire:navigate>
                                        {{ \Illuminate\Support\Str::limit($title, 50) }}
                                    </a>
                                </h5>

                                @if (isset($product->short_description))
                                    <p class="card-text text-muted small mb-3">
                                        {{ \Illuminate\Support\Str::limit($product->short_description, 80) }}
                                    </p>
                                @endif

                                <div class="mt-auto">
                                    <!-- Цена -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="fw-bold fs-5 text-primary">
                                            {{ number_format($price, 0, ',', ' ') }} ₽
                                        </span>

                                        @if (isset($product->old_price) && $product->old_price > $price)
                                            <span class="text-decoration-line-through text-muted small">
                                                {{ number_format($product->old_price, 0, ',', ' ') }} ₽
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Кнопки действий -->
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('product', $slug) }}" class="btn btn-primary btn-sm"
                                            wire:navigate>
                                            <i class="fas fa-shopping-cart me-1"></i>
                                            Купить
                                        </a>

                                        <a href="{{ route('product', $slug) }}" class="btn btn-outline-primary btn-sm"
                                            wire:navigate>
                                            <i class="fas fa-info-circle me-1"></i>
                                            Подробнее
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Пагинация -->
            @if (method_exists($products, 'hasPages') && $products->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    <div class="bg-white p-3 rounded shadow-sm">
                        {{ $products->links() }}
                    </div>
                </div>
            @endif
        @elseif($query)
            <!-- Нет результатов -->
            <div class="text-center py-5 my-4">
                <div class="empty-state mb-4">
                    <i class="fas fa-search fa-4x text-muted mb-3"></i>
                    <h4 class="fw-bold">Ничего не найдено</h4>
                    <p class="text-muted mb-4">
                        По запросу "{{ $query }}" товаров не найдено.
                    </p>

                    <div class="suggestions mb-4">
                        <p class="mb-2">Попробуйте:</p>
                        <div class="d-flex flex-wrap justify-content-center gap-2">
                            <a href="{{ route('search', ['query' => 'футболка']) }}"
                                class="btn btn-outline-primary btn-sm" wire:navigate>
                                Футболки
                            </a>
                            <a href="{{ route('search', ['query' => 'джинсы']) }}"
                                class="btn btn-outline-primary btn-sm" wire:navigate>
                                Джинсы
                            </a>
                            <a href="{{ route('search', ['query' => 'куртка']) }}"
                                class="btn btn-outline-primary btn-sm" wire:navigate>
                                Куртки
                            </a>
                            <a href="{{ route('search', ['query' => 'платье']) }}"
                                class="btn btn-outline-primary btn-sm" wire:navigate>
                                Платья
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('home') }}" class="btn btn-primary" wire:navigate>
                        <i class="fas fa-home me-2"></i>
                        Вернуться на главную
                    </a>
                </div>
            </div>
        @else
            <!-- Пустой поиск -->
            <div class="text-center py-5 my-4">
                <div class="empty-state mb-4">
                    <div class="bg-primary rounded-circle p-4 d-inline-block mb-3">
                        <i class="fas fa-search fa-4x text-white"></i>
                    </div>
                    <h4 class="fw-bold">Начните поиск</h4>
                    <p class="text-muted mb-4">
                        Введите поисковый запрос в поле выше, чтобы найти товары
                    </p>

                    <div class="popular-searches">
                        <p class="mb-2">Популярные запросы:</p>
                        <div class="d-flex flex-wrap justify-content-center gap-2">
                            <a href="{{ route('search', ['query' => 'смартфон']) }}"
                                class="badge bg-light text-dark p-2" wire:navigate>
                                <i class="fas fa-mobile-alt me-1"></i>
                                Смартфоны
                            </a>
                            <a href="{{ route('search', ['query' => 'ноутбук']) }}"
                                class="badge bg-light text-dark p-2" wire:navigate>
                                <i class="fas fa-laptop me-1"></i>
                                Ноутбуки
                            </a>
                            <a href="{{ route('search', ['query' => 'одежда']) }}" class="badge bg-light text-dark p-2"
                                wire:navigate>
                                <i class="fas fa-tshirt me-1"></i>
                                Одежда
                            </a>
                            <a href="{{ route('search', ['query' => 'книги']) }}" class="badge bg-light text-dark p-2"
                                wire:navigate>
                                <i class="fas fa-book me-1"></i>
                                Книги
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .card-img-top {
            transition: transform 0.5s ease;
        }

        .hover-lift:hover .card-img-top {
            transform: scale(1.05);
        }

        .empty-state {
            max-width: 500px;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .row-cols-md-2 .col {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }

        @media (max-width: 576px) {
            .row-cols-1 .col {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
    </style>
</div>
