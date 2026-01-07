<div>
    <div class="container py-5">
        {{-- Хлебные крошки --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a wire:navigate href="{{ route('home') }}">Главная</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Корзина покупок</li>
            </ol>
        </nav>

        <h1 class="mb-4">🛒 Корзина покупок</h1>

        @if (!empty($cartItems))
            {{-- Есть товары в корзине --}}
            <div class="row">
                {{-- Список товаров --}}
                <div class="col-lg-8 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="table-responsive position-relative">
                                <div wire:loading class="text-center py-4">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Загрузка...</span>
                                    </div>
                                    <p class="mt-2 small text-muted">Обновление...</p>
                                </div>
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="100">Фото</th>
                                            <th>Товар</th>
                                            <th width="120">Цена</th>
                                            <th width="160">Количество</th>
                                            <th width="120">Сумма</th>
                                            <th width="60"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cartItems as $id => $item)
                                            <tr wire:key="cart-item-{{ $id }}">
                                                <td>
                                                    <a href="{{ route('product', $item['slug']) }}" wire:navigate>
                                                        <img src="{{ $item['image'] ?? asset('img/no-image.jpg') }}"
                                                            alt="{{ $item['title'] }}" class="img-fluid rounded"
                                                            style="width: 80px; height: 80px; object-fit: cover;">
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('product', $item['slug']) }}" wire:navigate
                                                        class="text-decoration-none text-dark">
                                                        <h6 class="mb-1 fw-bold">{{ $item['title'] }}</h6>
                                                    </a>
                                                </td>
                                                <td class="fw-bold">${{ number_format($item['price'], 2) }}</td>
                                                <td>
                                                    <div class="input-group input-group-sm" style="width: 160px;">
                                                        {{-- Кнопка уменьшить --}}
                                                        <button class="btn btn-outline-secondary"
                                                            wire:click="decrementQuantity('{{ $id }}')"
                                                            {{ $item['quantity'] <= 1 ? 'disabled' : '' }}
                                                            wire:loading.attr="disabled">
                                                            <i class="fas fa-minus"></i>
                                                        </button>

                                                        {{-- Поле количества --}}
                                                        <input type="text" class="form-control text-center"
                                                            value="{{ $item['quantity'] }}" readonly
                                                            style="width: 60px;">

                                                        {{-- Кнопка увеличить --}}
                                                        <button class="btn btn-outline-secondary"
                                                            wire:click="incrementQuantity('{{ $id }}')"
                                                            wire:loading.attr="disabled">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div wire:loading wire:target="incrementQuantity,decrementQuantity"
                                                        class="small text-muted mt-1">
                                                        Обновление...
                                                    </div>
                                                </td>
                                                <td class="fw-bold text-primary">
                                                    ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                                </td>
                                                <td>
                                                    <button class="btn btn-outline-danger btn-sm" title="Удалить"
                                                        wire:click="removeFromCart('{{ $id }}')"
                                                        wire:loading.attr="disabled">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- Продолжить покупки --}}
                            <div class="mt-3">
                                <a href="{{ route('home') }}" class="btn btn-outline-primary" wire:navigate>
                                    <i class="fas fa-arrow-left me-2"></i>Продолжить покупки
                                </a>
                                <button class="btn btn-outline-danger" wire:click="clearCart"
                                    wire:loading.attr="disabled">
                                    <i class="fas fa-trash me-2"></i>Очистить корзину
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Итоги заказа --}}
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Итоги заказа</h5>
                        </div>
                        <div class="card-body">
                            @php
                                $totalItems = array_sum(array_column($cartItems, 'quantity'));
                                $subtotal = array_sum(
                                    array_map(function ($item) {
                                        return $item['price'] * $item['quantity'];
                                    }, $cartItems),
                                );
                                $tax = $subtotal * 0.1;
                                $total = $subtotal + $tax;
                            @endphp

                            {{-- Стоимость товаров --}}
                            <div class="d-flex justify-content-between mb-2">
                                <span>Товары ({{ $totalItems }})</span>
                                <span class="fw-bold">${{ number_format($subtotal, 2) }}</span>
                            </div>

                            {{-- Доставка --}}
                            <div class="d-flex justify-content-between mb-2">
                                <span>Доставка</span>
                                <span class="text-success">Бесплатно</span>
                            </div>

                            {{-- Налог --}}
                            <div class="d-flex justify-content-between mb-3">
                                <span>Налог</span>
                                <span>${{ number_format($tax, 2) }}</span>
                            </div>

                            <hr>

                            {{-- Итого --}}
                            <div class="d-flex justify-content-between mb-4">
                                <span class="fs-5 fw-bold">Итого</span>
                                <span class="fs-5 fw-bold text-primary">${{ number_format($total, 2) }}</span>
                            </div>

                            <a href="{{ route('checkout') }}" class="btn btn-primary w-100 py-3 mb-3"
                                onclick="showLoader(this)">
                                <i class="fas fa-credit-card me-2"></i>
                                <span class="btn-text">Перейти к оформлению</span>
                                <span class="spinner" style="display: none;">
                                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                    Перенаправление...
                                </span>
                            </a>

                            {{-- Безопасность --}}
                            <div class="text-center small text-muted">
                                <i class="fas fa-lock me-1"></i>
                                Безопасная оплата · Ваши данные защищены
                            </div>

                            {{-- Принимаемые карты --}}
                            <div class="text-center mt-3">
                                <img src="https://img.icons8.com/color/48/000000/visa.png" alt="Visa" class="me-2"
                                    style="height: 30px;">
                                <img src="https://img.icons8.com/color/48/000000/mastercard.png" alt="MasterCard"
                                    class="me-2" style="height: 30px;">
                                <img src="https://img.icons8.com/color/48/000000/paypal.png" alt="PayPal"
                                    style="height: 30px;">
                            </div>
                        </div>
                    </div>

                    {{-- Промокод --}}
                    <div class="card shadow-sm border-0 mt-4">
                        <div class="card-body">
                            <h6 class="mb-3">Есть промокод?</h6>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Введите код">
                                <button class="btn btn-outline-secondary">
                                    Применить
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            {{-- Корзина пуста --}}
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                <h3 class="mb-3">Ваша корзина пуста</h3>
                <p class="text-muted mb-4">Добавьте товары из каталога</p>
                <a href="{{ route('home') }}" class="btn btn-primary" wire:navigate>
                    <i class="fas fa-store me-2"></i>Начать покупки
                </a>
            </div>
        @endif
    </div>

    <style>
        .table th {
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            color: #6c757d;
        }

        .table td {
            vertical-align: middle;
        }

        .input-group input {
            border-left: 0;
            border-right: 0;
        }

        .sticky-top {
            position: -webkit-sticky;
            position: sticky;
        }

        .btn-checkout {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            font-weight: 600;
        }

        .btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
    </style>
</div>
