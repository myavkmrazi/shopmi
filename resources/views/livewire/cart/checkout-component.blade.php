<div>
    <div class="container py-5">
        {{-- Хлебные крошки --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a wire:navigate href="{{ route('home') }}">Главная</a>
                </li>
                <li class="breadcrumb-item">
                    <a wire:navigate href="{{ route('cart') }}">Корзина</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Оформление заказа</li>
            </ol>
        </nav>

        <h1 class="mb-4">📦 Оформление заказа</h1>

        @if ($cart = \App\Helpers\Cart\Cart::getCart())
            {{-- Если корзина НЕ пустая --}}
            <div class="row">
                {{-- Форма оформления --}}
                <div class="col-lg-8 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="mb-4">Контактные данные</h5>

                            {{-- Livewire форма --}}
                            <form wire:submit.prevent="saveOrder">
                                @csrf

                                {{-- Имя --}}
                                <div class="mb-3">
                                    <label for="name" class="form-label">Имя <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" wire:model="name" value="{{ auth()->user()->name ?? '' }}"
                                        required placeholder="Введите ваше имя">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- Surname --}}
                                <div class="mb-3">
                                    <label for="surname" class="form-label">Фамилия <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('surname') is-invalid @enderror"
                                        id="surname" wire:model="surname" value="{{ auth()->user()->surname ?? '' }}"
                                        required placeholder="Введите свою фамилию">
                                    @error('surname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" wire:model="email" value="{{ auth()->user()->email ?? '' }}"
                                        required placeholder="example@mail.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Телефон --}}
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Телефон <span
                                            class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" id="phone" name="phone"
                                        value="{{ auth()->user()->phone ?? '' }}" required
                                        placeholder="+7 (999) 999-99-99">
                                </div>

                                {{-- Адрес доставки --}}
                                <div class="mb-3">
                                    <label for="address" class="form-label">Адрес доставки <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="address" name="address" rows="2" required placeholder="Улица, дом, квартира">{{ auth()->user()->address ?? '' }}</textarea>
                                </div>

                                {{-- Город --}}
                                <div class="mb-3">
                                    <label for="city" class="form-label">Город <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="city" name="city"
                                        value="{{ auth()->user()->city ?? '' }}" required
                                        placeholder="Введите ваш город">
                                </div>

                                {{-- Комментарий --}}
                                <div class="mb-3">
                                    <label for="note" class="form-label">Комментарий к заказу</label>
                                    <textarea class="form-control @error('note') is-invalid @enderror" id="note" wire:model="note" rows="3"
                                        placeholder="Дополнительные пожелания по доставке..."></textarea>
                                    @error('note')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Способ оплаты --}}
                                <div class="mb-4">
                                    <h6 class="mb-3">Способ оплаты</h6>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                            id="payment1" value="card" checked>
                                        <label class="form-check-label" for="payment1">Банковская карта онлайн</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                            id="payment2" value="cash">
                                        <label class="form-check-label" for="payment2">Наличными при получении</label>
                                    </div>
                                </div>

                                {{-- Соглашение --}}
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="agree"
                                            name="agree">
                                        <label class="form-check-label" for="agree">
                                            Я согласен с <a href="#" class="text-decoration-none">правилами
                                                обработки персональных данных</a> и <a href="#"
                                                class="text-decoration-none">условиями покупки</a>
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Сводка заказа --}}
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Ваш заказ</h5>
                        </div>
                        <div class="card-body">
                            {{-- Список товаров --}}
                            <div class="mb-3">
                                @foreach ($cart as $id => $item)
                                    <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                        <div>
                                            <div class="fw-medium">{{ $item['title'] ?? 'Без названия' }}</div>
                                            <div class="small text-muted">
                                                {{ $item['quantity'] ?? 1 }} ×
                                                ${{ number_format($item['price'] ?? 0, 2) }}
                                            </div>
                                        </div>
                                        <div class="fw-bold">
                                            ${{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 2) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Итоги --}}
                            @php
                                $subtotal = 0;
                                $totalQuantity = 0;

                                foreach ($cart as $item) {
                                    $subtotal += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
                                    $totalQuantity += $item['quantity'] ?? 1;
                                }
                            @endphp

                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Товары ({{ $totalQuantity }})</span>
                                    <span>${{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Доставка</span>
                                    <span class="text-success">Бесплатно</span>
                                </div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                                <span>Итого:</span>
                                <span class="text-primary">${{ number_format($subtotal, 2) }}</span>
                            </div>

                            {{-- Кнопка оформления --}}
                            <div class="d-grid gap-2">
                                <button type="button" wire:click="saveOrder" wire:loading.attr="disabled"
                                    wire:target="saveOrder" class="btn btn-primary btn-lg">

                                    {{-- Обычное состояние --}}
                                    <span wire:loading.remove wire:target="saveOrder">
                                        <i class="fas fa-check-circle me-2"></i>Оформить заказ
                                    </span>

                                    {{-- Состояние загрузки --}}
                                    <span wire:loading wire:target="saveOrder">
                                        <i class="fas fa-spinner fa-spin me-2"></i>Оформление...
                                    </span>
                                </button>
                                <a wire:navigate href="{{ route('cart') }}" class="btn btn-outline-secondary">
                                    Вернуться в корзину
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            {{-- Если корзина пустая --}}
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                <h3 class="mb-3">Ваша корзина пуста</h3>
                <p class="text-muted mb-4">Добавьте товары из каталога</p>
                <a wire:navigate href="{{ route('home') }}" class="btn btn-primary">
                    Начать покупки
                </a>
            </div>
        @endif
    </div>

    <style>
        .breadcrumb {
            background-color: transparent;
            padding: 0;
        }

        .breadcrumb-item a {
            text-decoration: none;
            color: #6c757d;
        }

        .breadcrumb-item.active {
            color: #000;
        }

        .card {
            border-radius: 10px;
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }

        .is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 0.25rem;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Маска для телефона
            const phoneInput = document.getElementById('phone');
            if (phoneInput) {
                phoneInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length > 0) {
                        if (!value.startsWith('7')) {
                            value = '7' + value;
                        }
                        let formatted = '+7 (' + value.substring(1, 4) + ') ' +
                            value.substring(4, 7) + '-' +
                            value.substring(7, 9) + '-' +
                            value.substring(9, 11);
                        e.target.value = formatted.substring(0, 18);
                    }
                });
            }
        });
    </script>
</div>
