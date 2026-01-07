<div>
    @if (!$category)
        <div class="container-wide py-4 text-center">
            <div class="alert alert-danger">
                <h4>Категория не найдена</h4>
                <p>Запрошенная категория не существует.</p>
                <a href="{{ route('home') }}" class="btn btn-primary" wire:navigate>
                    <i class="fas fa-home me-2"></i>На главную
                </a>
            </div>
        </div>
    @else
        <div class="container-wide py-4">
            {{-- ========== ХЛЕБНЫЕ КРОШКИ ========== --}}
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" wire:navigate>Главная</a>
                    </li>
                    @if ($category->parent)
                        <li class="breadcrumb-item">
                            <a href="{{ route('category', $category->parent->slug) }}" wire:navigate>
                                {{ $category->parent->title }}
                            </a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $category->title }}
                    </li>
                </ol>
            </nav>

            <div class="row">
                {{-- ========== ЛЕВАЯ КОЛОНКА - ИНФОРМАЦИЯ О КАТЕГОРИИ И ФИЛЬТРЫ ========== --}}
                <div class="col-md-3">
                    {{-- КАРТОЧКА КАТЕГОРИИ --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-body text-center">
                            <div wire:loading class="text-center py-4">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Загрузка...</span>
                                </div>
                                <p class="mt-2 small text-muted">Обновление...</p>
                            </div>

                            {{-- ОСНОВНОЙ КОНТЕНТ (скрывается при загрузке) --}}
                            <div wire:loading.remove wire:target="minPrice,maxPrice,sortBy">
                                <div class="bg-light rounded mb-3 d-flex align-items-center justify-content-center"
                                    style="height: 150px;">
                                    <i class="fas fa-folder fa-3x text-muted"></i>
                                </div>
                                <h5 class="card-title">{{ $category->title }}</h5>
                                @if ($category->description)
                                    <p class="card-text text-muted small">{{ $category->description }}</p>
                                @endif
                                <div class="text-muted small">
                                    <i class="fas fa-box me-1"></i> Товаров: {{ $products->total() }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ФИЛЬТРЫ --}}
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-filter me-2"></i>Фильтры
                            </h6>
                        </div>
                        <div class="card-body">
                            {{-- Фильтр по цене --}}
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Цена, руб.</label>
                                <div class="row g-2">
                                    <div class="col">
                                        <input type="number" class="form-control form-control-sm" placeholder="От"
                                            wire:model.live="minPrice" min="0">
                                    </div>
                                    <div class="col">
                                        <input type="number" class="form-control form-control-sm" placeholder="До"
                                            wire:model.live="maxPrice" min="0">
                                    </div>
                                </div>
                            </div>

                            {{-- ДИНАМИЧЕСКИЕ ФИЛЬТРЫ ИЗ БАЗЫ --}}
                            @if (isset($category_filters) && $category_filters->count() > 0)
                                @foreach ($category_filters->groupBy('group_title') as $group_title => $filter_group)
                                    <div class="filter-block mb-4" wire:key="{{ $group_title }}">
                                        <h6 class="section-title small fw-bold mb-3">
                                            <span>Filter by {{ $group_title }}</span>
                                        </h6>
                                        <div class="filter-group">
                                            @foreach ($filter_group as $filter)
                                                <div class="form-check d-flex justify-content-between mb-2"
                                                    wire:key="{{ $filter->filter_id }}">
                                                    <div>
                                                        <input wire:model.live="selected_filters"
                                                            class="form-check-input" type="checkbox"
                                                            value="{{ $filter->filter_id }}"
                                                            id="filter_{{ $filter->filter_id }}">
                                                        <label class="form-check-label small"
                                                            for="filter_{{ $filter->filter_id }}">
                                                            {{ $filter->filter }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            {{-- Сортировка --}}
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Сортировка</label>
                                <select class="form-select form-select-sm" wire:model.live="sort">
                                    @foreach ($sortList as $k => $item)
                                        <option value="{{ $k }}" wire:key="{{ $k }}">
                                            {{ $item['title'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- ЛИМИТ ТОВАРОВ НА СТРАНИЦЕ --}}
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Товаров на странице</label>
                                <select class="form-select form-select-sm" wire:model.live="limit">
                                    @foreach ($limitList as $item)
                                        <option value="{{ $item }}" wire:key="{{ $item }}">
                                            {{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Кнопка сброса --}}
                            <button class="btn btn-outline-secondary btn-sm w-100" wire:click="resetFilters">
                                <i class="fas fa-redo me-1"></i>Сбросить фильтры
                            </button>
                        </div>
                    </div>

                    {{-- ПОДКАТЕГОРИИ (если есть) --}}
                    @if ($category->children && $category->children->count() > 0)
                        <div class="card shadow-sm mt-4">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-folder-tree me-2"></i>Подкатегории
                                </h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">
                                    @foreach ($category->children as $child)
                                        <a href="{{ route('category', $child->slug) }}"
                                            class="list-group-item list-group-item-action small d-flex justify-content-between align-items-center"
                                            wire:navigate>
                                            {{ $child->title }}
                                            <span
                                                class="badge bg-primary rounded-pill">{{ $child->products_count ?? 0 }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- ========== ПРАВАЯ КОЛОНКА - ТОВАРЫ ========== --}}
                <div class="col-md-9">
                    {{-- ЗАГОЛОВОК И ИНФОРМАЦИЯ --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h1 class="h3 mb-1">{{ $category->title }}</h1>
                            <p class="text-muted mb-0">
                                <i class="fas fa-search me-1"></i>Найдено товаров: {{ $products->total() }}
                            </p>
                        </div>

                        {{-- ВИД ОТОБРАЖЕНИЯ И СОРТИРОВКА --}}
                        <div class="d-flex align-items-center gap-3">
                            <div class="text-muted small">
                                Сортировка:
                                <span class="fw-bold">
                                    {{ $sortList[$sort]['title'] ?? 'По умолчанию' }}
                                </span>
                            </div>
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-outline-secondary active" title="Сетка">
                                    <i class="fas fa-th"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" title="Список">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                        </div>
                    </div>


                    {{-- АКТИВНЫЕ ФИЛЬТРЫ --}}
                    @if ($minPrice || $maxPrice || (isset($selected_filters) && count($selected_filters) > 0))
                        <div class="alert alert-light d-flex align-items-center justify-content-between mb-4 py-2">
                            <div>
                                <small class="fw-bold">Активные фильтры:</small>
                                @if ($minPrice)
                                    <span class="badge bg-primary ms-2">От {{ $minPrice }} руб.</span>
                                @endif
                                @if ($maxPrice)
                                    <span class="badge bg-primary ms-2">До {{ $maxPrice }} руб.</span>
                                @endif
                                @if (isset($selected_filters) && count($selected_filters) > 0)
                                    @foreach ($selected_filters as $filterId)
                                        @php
                                            $filter = $category_filters->firstWhere('filter_id', $filterId);
                                        @endphp
                                        @if ($filter)
                                            <span class="badge bg-info ms-2">{{ $filter->filter }}</span>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                            <button class="btn btn-sm btn-outline-danger" wire:click="resetFilters">
                                <i class="fas fa-times me-1"></i>Очистить
                            </button>
                        </div>
                    @endif
                    {{-- СЕТКА ТОВАРОВ --}}
                    @if ($products->count() > 0)
                        <div class="row g-4">
                            @foreach ($products as $product)
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    @include('incs.product-card', ['product' => $product])
                                </div>
                            @endforeach
                        </div>

                        {{-- ПАГИНАЦИЯ --}}
                        <div class="mt-5 d-flex justify-content-center">
                            {{ $products->links() }}
                        </div>
                    @else
                        {{-- СООБЩЕНИЕ ЕСЛИ ТОВАРОВ НЕТ --}}
                        <div class="text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">Товары не найдены</h4>
                            <p class="text-muted mb-4">Попробуйте изменить параметры фильтрации или выбрать другую
                                категорию</p>
                            <div class="d-flex gap-2 justify-content-center">
                                <button class="btn btn-primary" wire:click="resetFilters">
                                    <i class="fas fa-redo me-2"></i>Сбросить фильтры
                                </button>
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary" wire:navigate>
                                    <i class="fas fa-home me-2"></i>На главную
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    {{-- СКРИПТ ДЛЯ ПЛАВНОЙ ПРОКРУТКИ ПРИ ПАГИНАЦИИ --}}
    <script>
        document.addEventListener('livewire:init', () => {
            // Для плавной прокрутки
            Livewire.on('page-changed', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Для обновления title (ПРАВИЛЬНЫЙ СИНТАКСИС)
            Livewire.on('page-updated', (event) => {
                console.log('Page updated event:', event);
                if (event && event.title) {
                    document.title = event.title;
                }
            });
        });
    </script>
</div>
