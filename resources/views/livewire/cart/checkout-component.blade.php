<div class="shopmi-page checkout-page shopmi-animate-in">
    <div class="shopmi-shell">
        <ol class="shopmi-breadcrumb">
            <li><a wire:navigate href="{{ route('home') }}">Главная</a></li>
            <li><a wire:navigate href="{{ route('cart') }}">Корзина</a></li>
            <li class="active">Оформление заказа</li>
        </ol>

        <header class="shopmi-page-head">
            <p class="shopmi-kicker mb-0">Финальный шаг</p>
            <h1 class="shopmi-heading">Оформление</h1>
            <p class="shopmi-subtitle">Укажите контакты и адрес доставки. После отправки заказа менеджер свяжется с вами.</p>
        </header>

        @if ($cart = \App\Helpers\Cart\Cart::getCart())
            @php
                $subtotal = 0;
                $totalQuantity = 0;

                foreach ($cart as $item) {
                    $subtotal += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
                    $totalQuantity += $item['quantity'] ?? 1;
                }
            @endphp

            <div class="row g-4 align-items-start">
                <section class="col-lg-8">
                    <div class="shopmi-panel">
                        <h2 class="shopmi-title fs-2 mb-4">Контактные данные</h2>

                        <form wire:submit.prevent="saveOrder">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Имя <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control shopmi-input @error('name') is-invalid @enderror"
                                        id="name" wire:model="name" required placeholder="Введите ваше имя">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="surname" class="form-label">Фамилия <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control shopmi-input @error('surname') is-invalid @enderror"
                                        id="surname" wire:model="surname" required placeholder="Введите свою фамилию">
                                    @error('surname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control shopmi-input @error('email') is-invalid @enderror"
                                    id="email" wire:model="email" required placeholder="example@mail.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-3">
                                <label for="phone" class="form-label">Телефон <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control shopmi-input @error('phone') is-invalid @enderror"
                                    id="phone" wire:model="phone" required placeholder="+7 (999) 999-99-99">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-3">
                                <label for="address" class="form-label">Адрес доставки <span class="text-danger">*</span></label>
                                <textarea class="form-control shopmi-input @error('address') is-invalid @enderror" id="address"
                                    wire:model="address" rows="2" required placeholder="Улица, дом, квартира"></textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-3">
                                <label for="city" class="form-label">Город <span class="text-danger">*</span></label>
                                <input type="text" class="form-control shopmi-input @error('city') is-invalid @enderror"
                                    id="city" wire:model="city" required placeholder="Введите ваш город">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-3">
                                <label for="note" class="form-label">Комментарий к заказу</label>
                                <textarea class="form-control shopmi-input @error('note') is-invalid @enderror" id="note"
                                    wire:model="note" rows="3" placeholder="Дополнительные пожелания по доставке..."></textarea>
                                @error('note')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <h3 class="shopmi-filter-title">Способ оплаты</h3>
                                <div class="checkout-payment-options">
                                    <label @class(['checkout-payment-option', 'is-active' => $payment_method === 'card'])>
                                        <input class="visually-hidden" type="radio" value="card" wire:model.live="payment_method">
                                        <i class="fas fa-credit-card"></i>
                                        <span class="checkout-payment-option__title">Карта онлайн</span>
                                        <span class="checkout-payment-option__hint">Оплата при получении ссылки</span>
                                    </label>
                                    <label @class(['checkout-payment-option', 'is-active' => $payment_method === 'cash'])>
                                        <input class="visually-hidden" type="radio" value="cash" wire:model.live="payment_method">
                                        <i class="fas fa-money-bill-wave"></i>
                                        <span class="checkout-payment-option__title">Наличными</span>
                                        <span class="checkout-payment-option__hint">При получении заказа</span>
                                    </label>
                                </div>
                                @error('payment_method')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <div class="form-check">
                                    <input class="form-check-input @error('agreed') is-invalid @enderror" type="checkbox"
                                        id="agree" wire:model="agreed">
                                    <label class="form-check-label" for="agree">
                                        Я согласен с <a href="#" class="text-decoration-none text-dark">правилами
                                            обработки персональных данных</a> и <a href="#"
                                            class="text-decoration-none text-dark">условиями покупки</a>
                                    </label>
                                </div>
                                @error('agreed')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            @error('cart')
                                <div class="alert alert-danger mt-3 mb-0">{{ $message }}</div>
                            @enderror
                        </form>
                    </div>
                </section>

                <aside class="col-lg-4">
                    <div class="shopmi-order-summary shopmi-panel sticky-top" style="top: 96px;">
                        <h2 class="shopmi-title fs-1 mb-4">Ваш заказ</h2>

                        @foreach ($cart as $id => $item)
                            <div class="shopmi-order-line">
                                <div>
                                    <div class="fw-medium">{{ $item['title'] ?? 'Без названия' }}</div>
                                    <div class="small text-muted">
                                        {{ $item['quantity'] ?? 1 }} ×
                                        ${{ number_format($item['price'] ?? 0, 2) }}
                                    </div>
                                </div>
                                <strong class="shopmi-price fs-5 mb-0">
                                    ${{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 2) }}
                                </strong>
                            </div>
                        @endforeach

                        <div class="d-flex justify-content-between mb-3 mt-4">
                            <span>Товары ({{ $totalQuantity }})</span>
                            <strong>${{ number_format($subtotal, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Доставка</span>
                            <strong>Бесплатно</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="shopmi-kicker fs-4">Итого</span>
                            <span class="shopmi-price fs-2">${{ number_format($subtotal, 2) }}</span>
                        </div>

                        <button type="button" wire:click="saveOrder" wire:loading.attr="disabled" wire:target="saveOrder"
                            class="shopmi-btn w-100">
                            <span wire:loading.remove wire:target="saveOrder">
                                <i class="fas fa-check-circle"></i> Оформить заказ
                            </span>
                            <span wire:loading wire:target="saveOrder">
                                <i class="fas fa-spinner fa-spin"></i> Оформление...
                            </span>
                        </button>

                        <a wire:navigate href="{{ route('cart') }}" class="shopmi-btn shopmi-btn-outline w-100 mt-3">
                            Вернуться в корзину
                        </a>
                    </div>
                </aside>
            </div>
        @else
            <div class="shopmi-empty">
                <i class="fas fa-shopping-cart fa-3x"></i>
                <h2 class="shopmi-title">Корзина пуста</h2>
                <p class="shopmi-subtitle mx-auto">Добавьте товары из каталога, чтобы оформить заказ.</p>
                <a wire:navigate href="{{ route('home') }}" class="shopmi-btn mt-4">
                    <i class="fas fa-store"></i> Начать покупки
                </a>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const phoneInput = document.getElementById('phone');
            if (!phoneInput) {
                return;
            }

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
        });
    </script>
</div>
