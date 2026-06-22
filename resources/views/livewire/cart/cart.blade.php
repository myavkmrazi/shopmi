<div class="shopmi-page shopmi-animate-in">
    <div class="shopmi-shell">
        <ol class="shopmi-breadcrumb">
            <li><a wire:navigate href="{{ route('home') }}">Главная</a></li>
            <li class="active">Корзина</li>
        </ol>

        <header class="shopmi-page-head">
            <p class="shopmi-kicker mb-0">Почти готово</p>
            <h1 class="shopmi-heading">Корзина</h1>
            <p class="shopmi-subtitle">Проверьте товары, количество и итоговую сумму перед оформлением заказа.</p>
        </header>

        @if (!empty($cartItems))
            @php
                $totalItems = array_sum(array_column($cartItems, 'quantity'));
                $subtotal = array_sum(array_map(fn ($item) => $item['price'] * $item['quantity'], $cartItems));
                $total = $subtotal;
            @endphp

            <div class="row g-4 align-items-start">
                <section class="col-lg-8">
                    <div class="shopmi-panel p-0 overflow-hidden">
                        <div wire:loading class="text-center py-4">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Загрузка...</span>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table shopmi-table mb-0 align-middle">
                                <thead>
                                    <tr>
                                        <th>Товар</th>
                                        <th>Цена</th>
                                        <th>Количество</th>
                                        <th>Сумма</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartItems as $id => $item)
                                        <tr wire:key="cart-item-{{ $id }}">
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <a href="{{ route('product', $item['slug']) }}" wire:navigate>
                                                        <img src="{{ $item['image'] ?? asset('img/no-image.jpg') }}"
                                                            alt="{{ $item['title'] }}"
                                                            style="width: 84px; height: 100px; object-fit: cover; border: 1px solid var(--shopmi-line);">
                                                    </a>
                                                    <a href="{{ route('product', $item['slug']) }}" wire:navigate
                                                        class="text-decoration-none text-dark">
                                                        <h2 class="shopmi-card-title mb-0">{{ $item['title'] }}</h2>
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="shopmi-price fs-4">${{ number_format($item['price'], 2) }}</td>
                                            <td>
                                                <div class="shopmi-qty">
                                                    <button type="button" wire:click="decrementQuantity('{{ $id }}')"
                                                        {{ $item['quantity'] <= 1 ? 'disabled' : '' }}
                                                        wire:loading.attr="disabled">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <span>{{ $item['quantity'] }}</span>
                                                    <button type="button" wire:click="incrementQuantity('{{ $id }}')"
                                                        wire:loading.attr="disabled">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="shopmi-price fs-4">
                                                ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                            </td>
                                            <td class="text-end">
                                                <button class="shopmi-btn shopmi-btn-outline px-3" title="Удалить"
                                                    wire:click="removeFromCart('{{ $id }}')" wire:loading.attr="disabled">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <a href="{{ route('home') }}" class="shopmi-btn shopmi-btn-outline" wire:navigate>
                            <i class="fas fa-arrow-left"></i> Продолжить покупки
                        </a>
                        <button class="shopmi-btn shopmi-btn-outline" wire:click="clearCart" wire:loading.attr="disabled">
                            <i class="fas fa-trash"></i> Очистить корзину
                        </button>
                    </div>
                </section>

                <aside class="col-lg-4">
                    <div class="shopmi-order-summary shopmi-panel sticky-top" style="top: 96px;">
                        <h2 class="shopmi-title fs-1 mb-4">Итоги</h2>

                        <div class="d-flex justify-content-between mb-3">
                            <span>Товары ({{ $totalItems }})</span>
                            <strong>${{ number_format($subtotal, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Доставка</span>
                            <strong>Бесплатно</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="shopmi-kicker fs-4">Итого</span>
                            <span class="shopmi-price fs-2">${{ number_format($total, 2) }}</span>
                        </div>

                        <a href="{{ route('checkout') }}" class="shopmi-btn w-100" wire:navigate>
                            <i class="fas fa-credit-card"></i> Оформить заказ
                        </a>

                        <div class="small text-muted mt-3">
                            <i class="fas fa-lock me-1"></i>
                            Данные заказа защищены, оформление проходит внутри сайта.
                        </div>
                    </div>

                    <div class="shopmi-panel mt-4">
                        <h3 class="shopmi-filter-title">Промокод</h3>
                        <div class="input-group">
                            <input type="text" class="form-control shopmi-input" placeholder="Код">
                            <button class="shopmi-btn shopmi-btn-outline" type="button">Применить</button>
                        </div>
                    </div>
                </aside>
            </div>
        @else
            <div class="shopmi-empty">
                <i class="fas fa-shopping-bag fa-3x"></i>
                <h2 class="shopmi-title">Корзина пустая</h2>
                <p class="shopmi-subtitle mx-auto">Добавьте товары из каталога, чтобы перейти к оформлению заказа.</p>
                <a href="{{ route('home') }}" class="shopmi-btn mt-4" wire:navigate>
                    <i class="fas fa-store"></i> Начать покупки
                </a>
            </div>
        @endif
    </div>
</div>
