<div class="shopmi-page shopmi-account shopmi-animate-in">
    <div class="shopmi-shell">
        <ol class="shopmi-breadcrumb">
            <li><a href="{{ route('home') }}" wire:navigate>Главная</a></li>
            <li class="active">Личный кабинет</li>
        </ol>

        <header class="shopmi-page-head">
            <p class="shopmi-kicker mb-0">Добро пожаловать</p>
            <h1 class="shopmi-heading">Личный кабинет</h1>
            <p class="shopmi-subtitle">Управляйте профилем, заказами и настройками аккаунта.</p>
        </header>

        <div class="shopmi-account-layout">
            <aside class="shopmi-account-nav shopmi-panel">
                <div class="shopmi-account-nav__user">
                    <div class="shopmi-account-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <p class="shopmi-kicker mb-1">{{ auth()->user()->name }} {{ auth()->user()->surname }}</p>
                        <p class="shopmi-subtitle mb-0">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <nav aria-label="Меню аккаунта">
                    <a href="{{ route('account') }}" class="shopmi-account-link active" wire:navigate>
                        <span><i class="fas fa-user me-2"></i>Профиль</span>
                    </a>
                    <a href="{{ route('change-account') }}" class="shopmi-account-link" wire:navigate>
                        <span><i class="fas fa-pen me-2"></i>Редактирование</span>
                    </a>
                    <a href="{{ route('orders') }}" class="shopmi-account-link" wire:navigate>
                        <span><i class="fas fa-bag-shopping me-2"></i>Мои заказы</span>
                        @if ($ordersCount > 0)
                            <span class="shopmi-account-badge">{{ $ordersCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('wishlist') }}" class="shopmi-account-link" wire:navigate>
                        <span><i class="fas fa-heart me-2"></i>Избранное</span>
                    </a>
                </nav>

                <div class="p-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="shopmi-btn shopmi-btn-outline w-100">
                            <i class="fas fa-right-from-bracket"></i> Выйти
                        </button>
                    </form>
                </div>
            </aside>

            <div class="shopmi-account-main d-grid gap-4">
                <div class="shopmi-panel">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                        <h2 class="shopmi-title fs-2 mb-0">Личные данные</h2>
                        <a href="{{ route('change-account') }}" class="shopmi-btn" wire:navigate>
                            <i class="fas fa-pen"></i> Редактировать
                        </a>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <p class="shopmi-kicker mb-1">Имя</p>
                            <p class="mb-0">{{ auth()->user()->name }} {{ auth()->user()->surname }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="shopmi-kicker mb-1">Email</p>
                            <p class="mb-0">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="shopmi-kicker mb-1">Телефон</p>
                            <p class="mb-0">{{ auth()->user()->phone ?? 'Не указан' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="shopmi-kicker mb-1">Дата регистрации</p>
                            <p class="mb-0">{{ auth()->user()->created_at?->format('d.m.Y') ?? '—' }}</p>
                        </div>
                    </div>
                </div>

                <div class="shopmi-panel">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
                        <h2 class="shopmi-title fs-2 mb-0">Последние заказы</h2>
                        <a href="{{ route('orders') }}" class="shopmi-btn shopmi-btn-outline" wire:navigate>
                            Все заказы
                        </a>
                    </div>

                    @forelse ($recentOrders as $order)
                        <div class="shopmi-order-row">
                            <div>
                                <p class="shopmi-kicker mb-1">Заказ #{{ $order->id }}</p>
                                <p class="shopmi-subtitle mb-0">{{ $order->created_at?->format('d.m.Y H:i') }}</p>
                            </div>
                            <div class="text-end">
                                <p class="shopmi-price fs-4 mb-2">${{ number_format($order->total, 2) }}</p>
                                <span @class([
                                    'shopmi-status',
                                    'completed' => $order->status === 'completed',
                                    'processing' => in_array($order->status, ['new', 'processing'], true),
                                    'cancelled' => $order->status === 'cancelled',
                                ])>
                                    {{ $order->statusLabel() }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="shopmi-empty py-4">
                            <i class="fas fa-bag-shopping fa-2x"></i>
                            <p class="shopmi-subtitle mb-3">У вас пока нет заказов</p>
                            <a href="{{ route('home') }}" class="shopmi-btn" wire:navigate>Перейти в каталог</a>
                        </div>
                    @endforelse
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="shopmi-panel h-100">
                            <p class="shopmi-kicker mb-2">Заказов</p>
                            <p class="shopmi-price fs-1 mb-0">{{ $ordersCount }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="shopmi-panel h-100">
                            <p class="shopmi-kicker mb-2">Статус</p>
                            <p class="mb-0">Активный аккаунт</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="shopmi-panel h-100">
                            <p class="shopmi-kicker mb-2">Поддержка</p>
                            <a href="https://t.me/+Ln5wsCSUkqk4OGJi" target="_blank" rel="noopener" class="shopmi-btn shopmi-btn-outline w-100">
                                Telegram
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
