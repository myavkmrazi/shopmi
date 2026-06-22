<div class="shopmi-page checkout-success shopmi-animate-in">
    <div class="shopmi-shell">
        <ol class="shopmi-breadcrumb">
            <li><a href="{{ route('home') }}" wire:navigate>Главная</a></li>
            <li><a href="{{ route('cart') }}" wire:navigate>Корзина</a></li>
            <li class="active">Заказ оформлен</li>
        </ol>

        <header class="shopmi-page-head">
            <p class="shopmi-kicker mb-0">Спасибо за покупку</p>
            <h1 class="shopmi-heading">Заказ принят</h1>
            <p class="shopmi-subtitle">
                Мы получили ваш заказ и скоро свяжемся с вами. Подтверждение отправлено на
                <strong>{{ $order->email }}</strong>.
            </p>
        </header>

        <div class="row g-4 align-items-start">
            <section class="col-lg-8">
                <div class="shopmi-panel checkout-success__hero">
                    <div class="checkout-success__icon" aria-hidden="true">
                        <i class="fas fa-circle-check"></i>
                    </div>
                    <div>
                        <p class="shopmi-kicker mb-2">Номер заказа</p>
                        <p class="checkout-success__order-id mb-3">#{{ $order->id }}</p>
                        <p class="shopmi-subtitle mb-0">
                            Статус: <span class="shopmi-status processing">{{ $order->statusLabel() }}</span>
                        </p>
                    </div>
                </div>

                <div class="shopmi-panel mt-4">
                    <h2 class="shopmi-title fs-2 mb-4">Состав заказа</h2>

                    @foreach ($order->orderProducts as $item)
                        <div class="shopmi-order-line">
                            <div class="d-flex align-items-center gap-3">
                                @if ($item->image)
                                    <img src="{{ asset($item->image) }}" alt="{{ $item->title }}"
                                        class="checkout-success__thumb">
                                @endif
                                <div>
                                    <div class="fw-medium">{{ $item->title }}</div>
                                    <div class="small text-muted">
                                        {{ $item->quantity }} × ${{ number_format($item->price, 2) }}
                                    </div>
                                </div>
                            </div>
                            <strong class="shopmi-price fs-5 mb-0">
                                ${{ number_format($item->price * $item->quantity, 2) }}
                            </strong>
                        </div>
                    @endforeach
                </div>
            </section>

            <aside class="col-lg-4">
                <div class="shopmi-order-summary shopmi-panel sticky-top" style="top: 96px;">
                    <h2 class="shopmi-title fs-1 mb-4">Детали</h2>

                    <div class="checkout-success__detail mb-3">
                        <span class="shopmi-kicker">Получатель</span>
                        <p class="mb-0">{{ $order->name }} {{ $order->surname }}</p>
                    </div>
                    <div class="checkout-success__detail mb-3">
                        <span class="shopmi-kicker">Телефон</span>
                        <p class="mb-0">{{ $order->phone }}</p>
                    </div>
                    <div class="checkout-success__detail mb-3">
                        <span class="shopmi-kicker">Доставка</span>
                        <p class="mb-0">{{ $order->city }}, {{ $order->address }}</p>
                    </div>
                    <div class="checkout-success__detail mb-4">
                        <span class="shopmi-kicker">Оплата</span>
                        <p class="mb-0">{{ $this->paymentLabel() }}</p>
                    </div>

                    @if ($order->note)
                        <div class="checkout-success__detail mb-4">
                            <span class="shopmi-kicker">Комментарий</span>
                            <p class="mb-0">{{ $order->note }}</p>
                        </div>
                    @endif

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="shopmi-kicker fs-4">Итого</span>
                        <span class="shopmi-price fs-2">${{ number_format($order->total, 2) }}</span>
                    </div>

                    <a href="{{ route('home') }}" class="shopmi-btn w-100 mb-3" wire:navigate>
                        <i class="fas fa-store"></i> На главную
                    </a>

                    @auth
                        <a href="{{ route('orders') }}" class="shopmi-btn shopmi-btn-outline w-100" wire:navigate>
                            <i class="fas fa-bag-shopping"></i> Мои заказы
                        </a>
                    @endauth
                </div>
            </aside>
        </div>
    </div>
</div>
