<div class="shopmi-page shopmi-animate-in">
    @if (!$category)
        <div class="shopmi-shell">
            <div class="shopmi-empty">
                <i class="fas fa-folder-open fa-3x"></i>
                <h1 class="shopmi-title">Категория не найдена</h1>
                <p class="shopmi-subtitle mx-auto">Такой категории нет или ссылка устарела.</p>
                <a href="{{ route('home') }}" class="shopmi-btn mt-4" wire:navigate>
                    <i class="fas fa-home"></i> На главную
                </a>
            </div>
        </div>
    @else
        <div class="shopmi-shell">
            <ol class="shopmi-breadcrumb">
                <li><a href="{{ route('home') }}" wire:navigate>Главная</a></li>
                @if ($category->parent)
                    <li>
                        <a href="{{ route('category', $category->parent->slug) }}" wire:navigate>
                            {{ $category->parent->title }}
                        </a>
                    </li>
                @endif
                <li class="active">{{ $category->title }}</li>
            </ol>

            <header class="shopmi-page-head">
                <p class="shopmi-kicker mb-0">Каталог / {{ $products->total() }} товаров</p>
                <h1 class="shopmi-heading">{{ $category->title }}</h1>
                @if ($category->description)
                    <p class="shopmi-subtitle">{{ $category->description }}</p>
                @else
                    <p class="shopmi-subtitle">Подборка товаров с фильтрами, сортировкой и быстрым добавлением в корзину.</p>
                @endif
            </header>

            <div class="row g-4 align-items-start">
                <aside class="col-lg-3">
                    <div class="shopmi-panel mb-4">
                        <h2 class="shopmi-filter-title">Фильтры</h2>

                        <div class="mb-4">
                            <div class="form-check">
                                <input wire:model.live="inStock" class="form-check-input" type="checkbox" id="inStock">
                                <label class="form-check-label" for="inStock">Только в наличии</label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label shopmi-kicker">Цена</label>
                            <div class="row g-2">
                                <div class="col">
                                    <input type="number" class="form-control shopmi-input" placeholder="От"
                                        wire:model.live="minPrice" min="0">
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control shopmi-input" placeholder="До"
                                        wire:model.live="maxPrice" min="0">
                                </div>
                            </div>
                        </div>

                        @if (isset($category_filters) && $category_filters->count() > 0)
                            @foreach ($category_filters->groupBy('group_title') as $group_title => $filter_group)
                                <div class="mb-4" wire:key="{{ $group_title }}">
                                    <h3 class="shopmi-kicker fs-5">{{ $group_title }}</h3>
                                    @foreach ($filter_group as $filter)
                                        <div class="form-check mb-2" wire:key="{{ $filter->filter_id }}">
                                            <input wire:model.live="selected_filters" class="form-check-input"
                                                type="checkbox" value="{{ $filter->filter_id }}"
                                                id="filter_{{ $filter->filter_id }}">
                                            <label class="form-check-label" for="filter_{{ $filter->filter_id }}">
                                                {{ $filter->filter }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        @endif

                        <div class="mb-3">
                            <label class="form-label shopmi-kicker">Сортировка</label>
                            <select class="form-select shopmi-select" wire:model.live="sort">
                                @foreach ($sortList as $k => $item)
                                    <option value="{{ $k }}" wire:key="{{ $k }}">{{ $item['title'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label shopmi-kicker">На странице</label>
                            <select class="form-select shopmi-select" wire:model.live="limit">
                                @foreach ($limitList as $item)
                                    <option value="{{ $item }}" wire:key="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button class="shopmi-btn shopmi-btn-outline w-100" wire:click="resetFilters">
                            <i class="fas fa-rotate-left"></i> Сбросить
                        </button>
                    </div>

                    @if ($category->children && $category->children->count() > 0)
                        <div class="shopmi-panel">
                            <h2 class="shopmi-filter-title">Подкатегории</h2>
                            <div class="d-grid gap-2">
                                @foreach ($category->children as $child)
                                    <a href="{{ route('category', $child->slug) }}" class="shopmi-btn shopmi-btn-outline justify-content-between" wire:navigate>
                                        <span>{{ $child->title }}</span>
                                        <span>{{ $child->products_count ?? 0 }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </aside>

                <section class="col-lg-9">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                        <div class="shopmi-stat">
                            Найдено: {{ $products->total() }}
                        </div>
                        <div class="text-muted">
                            {{ $sortList[$sort]['title'] ?? 'Default' }}
                        </div>
                    </div>

                    @if ($minPrice || $maxPrice || (isset($selected_filters) && count($selected_filters) > 0))
                        <div class="shopmi-panel d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 py-3">
                            <div class="d-flex flex-wrap gap-2">
                                @if ($minPrice)
                                    <span class="badge text-bg-dark rounded-0">От {{ $minPrice }}</span>
                                @endif
                                @if ($maxPrice)
                                    <span class="badge text-bg-dark rounded-0">До {{ $maxPrice }}</span>
                                @endif
                                @if (isset($selected_filters) && count($selected_filters) > 0)
                                    @foreach ($selected_filters as $filterId)
                                        @php $filter = $category_filters->firstWhere('filter_id', $filterId); @endphp
                                        @if ($filter)
                                            <span class="badge text-bg-light rounded-0 border">{{ $filter->filter }}</span>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                            <button class="shopmi-btn shopmi-btn-outline" wire:click="resetFilters">
                                Очистить
                            </button>
                        </div>
                    @endif

                    <div wire:loading class="shopmi-panel text-center mb-4">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Загрузка...</span>
                        </div>
                    </div>

                    @if ($products->count() > 0)
                        <div class="row g-4">
                            @foreach ($products as $product)
                                <div class="col-xl-4 col-md-6">
                                    @include('incs.product-card', ['product' => $product])
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-5 d-flex justify-content-center">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="shopmi-empty">
                            <i class="fas fa-search fa-3x"></i>
                            <h2 class="shopmi-title">Ничего не найдено</h2>
                            <p class="shopmi-subtitle mx-auto">Попробуйте убрать часть фильтров или выбрать другую категорию.</p>
                            <button class="shopmi-btn mt-4" wire:click="resetFilters">
                                <i class="fas fa-rotate-left"></i> Сбросить фильтры
                            </button>
                        </div>
                    @endif
                </section>
            </div>
        </div>
    @endif
</div>
