<div class="shopmi-page shopmi-animate-in">
    <div class="shopmi-shell">
        @php
            $query = $query ?? '';
            $products = $products ?? collect();
        @endphp

        <ol class="shopmi-breadcrumb">
            <li><a href="{{ route('home') }}" wire:navigate>Главная</a></li>
            <li class="active">Поиск</li>
        </ol>

        <header class="shopmi-page-head">
            <p class="shopmi-kicker mb-0">Поиск по магазину</p>
            <h1 class="shopmi-heading">
                @if ($query)
                    {{ $query }}
                @else
                    Найдите свой товар
                @endif
            </h1>
            <p class="shopmi-subtitle">
                Быстрый поиск по каталогу. Если результат пустой, попробуйте более короткий запрос.
            </p>
        </header>

        <div class="shopmi-panel mb-4">
            <form wire:submit.prevent="$refresh">
                <div class="row g-3">
                    <div class="col-md">
                        <input type="text" class="form-control shopmi-input"
                            placeholder="Например: hoodie, jeans, coat"
                            wire:model.live.debounce.500ms="query">
                    </div>
                    <div class="col-md-auto">
                        <button class="shopmi-btn w-100" type="submit">
                            <i class="fas fa-search"></i> Найти
                        </button>
                    </div>
                </div>
            </form>

            @if (! $query)
                <div class="shopmi-search__chips mt-3">
                    <span class="shopmi-search__hint me-2">Подсказки:</span>
                    @foreach (['Jeans', 'Coat', 'Shoes', 'Shirts', 'Sportswear'] as $hint)
                        <button type="button" class="shopmi-search__chip" wire:click="$set('query', '{{ $hint }}')">
                            {{ $hint }}
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        @if ($products->count() > 0)
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="shopmi-stat">Найдено: {{ $products->total() ?? 0 }}</div>
            </div>

            <div class="row g-4">
                @foreach ($products as $product)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        @include('incs.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>

            @if (method_exists($products, 'hasPages') && $products->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $products->links() }}
                </div>
            @endif
        @elseif($query)
            <div class="shopmi-empty">
                <i class="fas fa-search fa-3x"></i>
                <h2 class="shopmi-title">Ничего не найдено</h2>
                <p class="shopmi-subtitle mx-auto">
                    По запросу «{{ $query }}» товаров нет. Попробуйте другое слово или короче.
                </p>
                <div class="shopmi-search__chips justify-content-center mt-3">
                    @foreach (['Jeans', 'Coat', 'Shoes'] as $hint)
                        <button type="button" class="shopmi-search__chip" wire:click="$set('query', '{{ $hint }}')">
                            {{ $hint }}
                        </button>
                    @endforeach
                </div>
                <a href="{{ route('home') }}" class="shopmi-btn mt-4" wire:navigate>
                    <i class="fas fa-home"></i> На главную
                </a>
            </div>
        @else
            <div class="shopmi-empty">
                <i class="fas fa-magnifying-glass fa-3x"></i>
                <h2 class="shopmi-title">Начните поиск</h2>
                <p class="shopmi-subtitle mx-auto">Введите название товара или выберите подсказку выше.</p>
            </div>
        @endif
    </div>
</div>
