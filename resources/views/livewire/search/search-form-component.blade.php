<div style="position: relative; width: 300px;">
    <!-- ФОРМА ПОИСКА -->
    <div class="search-form">
        <!-- Кнопка лупы ТЕПЕРЬ вызывает performSearch -->
        <button type="button" class="search-icon-btn" wire:click="performSearch"
            @if (!$term) disabled @endif title="Найти">
            <i class="fas fa-search search-icon"></i>
        </button>

        <!-- Поле ввода тоже вызывает performSearch при Enter -->
        <input type="text" class="search-input" wire:model.live.debounce.500ms="term" placeholder="Поиск товаров..."
            aria-label="Поиск" wire:keydown.enter="performSearch">

        <!-- Крестик очистки (упрощенный вариант) -->
        @if ($term)
            <span class="search-empty" wire:click="clearSearch" title="Очистить поиск">
                <i class="fa-solid fa-xmark"></i>
            </span>
        @endif
    </div>

    <!-- Результаты автодополнения -->
    @if (isset($search_results) && count($search_results) > 0)
        <ul class="search-result">
            @foreach ($search_results as $product)
                <li>
                    <a href="{{ route('product', $product->slug) }}" wire:navigate>
                        <span>{{ $product->title }}</span>
                        <span>{{ number_format($product->price, 0, ',', ' ') }} ₽</span>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif

    <style>
        .search-form {
            position: relative;
            width: 100%;
        }

        .search-input {
            width: 100%;
            padding: 10px 40px 10px 45px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.2);
        }

        /* Кнопка лупы */
        .search-icon-btn {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #667eea;
            cursor: pointer;
            z-index: 2;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            border-radius: 50%;
            transition: all 0.3s;
        }

        .search-icon-btn:hover:not(:disabled) {
            background: rgba(102, 126, 234, 0.1);
            color: #764ba2;
        }

        .search-icon-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .search-icon {
            font-size: 16px;
        }

        .search-empty {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            cursor: pointer;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
        }

        .search-empty:hover {
            color: #dc3545;
        }

        .search-result {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: #fff;
            z-index: 1025;
            border: 1px solid #ccc;
            border-top: none;
            border-radius: 0 0 5px 5px;
            list-style: none;
            padding: 0;
            margin: 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-height: 300px;
            overflow-y: auto;
        }

        .search-result li {
            border-bottom: 1px solid #f1f1f1;
        }

        .search-result li:last-child {
            border-bottom: none;
        }

        .search-result a {
            display: flex;
            justify-content: space-between;
            text-decoration: none;
            padding: 10px 15px;
            color: #333;
            transition: all 0.3s;
        }

        .search-result a:hover {
            background: #f1f5f9;
            color: #667eea;
        }

        @media (max-width: 768px) {
            div[style*="position: relative"] {
                width: 100%;
            }
        }
    </style>
</div> 
