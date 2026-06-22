<div>
    <!-- Хлебные крошки в стиле минимализм -->
    <div class="container" style="max-width: 1400px; margin: 0 auto; padding: 2rem;">
        <nav style="margin-bottom: 2rem;">
            <ol style="display: flex; align-items: center; gap: 1rem; list-style: none; padding: 0; margin: 0;">
                <li>
                    <a href="/" wire:navigate
                        style="color: #777; text-decoration: none; font-family: 'Oswald', sans-serif; font-size: 16px; letter-spacing: 1px; transition: all 0.3s ease;"
                        onmouseover="this.style.color='#0f0f10'" onmouseout="this.style.color='#777'">
                        ГЛАВНАЯ
                    </a>
                </li>
                <li>
                    <i class="fas fa-chevron-right" style="color: #e5e5e5; font-size: 12px;"></i>
                </li>
                <li>
                    <a href="{{ route('account') }}" wire:navigate
                        style="color: #777; text-decoration: none; font-family: 'Oswald', sans-serif; font-size: 16px; letter-spacing: 1px; transition: all 0.3s ease;"
                        onmouseover="this.style.color='#0f0f10'" onmouseout="this.style.color='#777'">
                        ЛИЧНЫЙ КАБИНЕТ
                    </a>
                </li>
                <li>
                    <i class="fas fa-chevron-right" style="color: #e5e5e5; font-size: 12px;"></i>
                </li>
                <li
                    style="color: #0f0f10; font-family: 'Oswald', sans-serif; font-size: 16px; letter-spacing: 1px;">
                    МОИ ЗАКАЗЫ
                </li>
            </ol>
        </nav>

        <!-- Заголовок страницы с анимацией -->
        <div style="margin-bottom: 3rem; position: relative; overflow: hidden;">
            <h1
                style="font-family: 'Oswald', sans-serif; font-size: 64px; letter-spacing: 4px; color: #0f0f10; margin: 0; line-height: 1.1; animation: slideInLeft 0.8s ease-out;">
                МОИ ЗАКАЗЫ
            </h1>
            <p
                style="font-family: 'Inter', sans-serif; font-size: 18px; color: #777; margin-top: 1rem; animation: fadeInUp 0.8s ease-out 0.2s both;">
                История ваших заказов
            </p>
            <!-- Декоративная линия -->
            <div
                style="width: 100px; height: 4px; background: #0f0f10; margin-top: 1.5rem; animation: expandWidth 0.8s ease-out 0.4s both;">
            </div>
        </div>

        @if ($orders->count() > 0)
            <!-- Блок с заказами -->
            <div style="border: 2px solid #e5e5e5; background: #fff; animation: fadeInUp 0.8s ease-out;">

                <!-- Таблица заказов -->
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead style="background: #f8f8f8; border-bottom: 2px solid #e5e5e5;">
                            <tr>
                                <th
                                    style="padding: 1.5rem 2rem; text-align: left; font-family: 'Oswald', sans-serif; font-size: 18px; letter-spacing: 1px; color: #0f0f10;">
                                    НОМЕР</th>
                                <th
                                    style="padding: 1.5rem 2rem; text-align: left; font-family: 'Oswald', sans-serif; font-size: 18px; letter-spacing: 1px; color: #0f0f10;">
                                    ИМЯ</th>
                                <th
                                    style="padding: 1.5rem 2rem; text-align: left; font-family: 'Oswald', sans-serif; font-size: 18px; letter-spacing: 1px; color: #0f0f10;">
                                    ДАТА</th>
                                <th
                                    style="padding: 1.5rem 2rem; text-align: left; font-family: 'Oswald', sans-serif; font-size: 18px; letter-spacing: 1px; color: #0f0f10;">
                                    СУММА</th>
                                <th
                                    style="padding: 1.5rem 2rem; text-align: left; font-family: 'Oswald', sans-serif; font-size: 18px; letter-spacing: 1px; color: #0f0f10;">
                                    СТАТУС</th>
                                <th
                                    style="padding: 1.5rem 2rem; text-align: left; font-family: 'Oswald', sans-serif; font-size: 18px; letter-spacing: 1px; color: #0f0f10;">
                                    ДЕЙСТВИЯ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $index => $order)
                                <tr style="border-bottom: 1px solid #e5e5e5; transition: all 0.3s ease; animation: fadeInRow 0.5s ease-out {{ $index * 0.1 }}s both;"
                                    onmouseover="this.style.background='#f8f8f8'"
                                    onmouseout="this.style.background='transparent'">

                                    <!-- Номер заказа -->
                                    <td style="padding: 1.5rem 2rem;">
                                        @php
                                            $statusInfo = match ($order->status) {
                                                'new' => ['label' => 'НОВЫЙ', 'color' => '#0f0f10'],
                                                'processing' => ['label' => 'В ОБРАБОТКЕ', 'color' => '#777'],
                                                'completed' => ['label' => 'ВЫПОЛНЕН', 'color' => '#0f0f10'],
                                                'cancelled' => ['label' => 'ОТМЕНЕН', 'color' => '#777'],
                                                default => $statusInfo,
                                            };
                                        @endphp
                                        <span
                                            style="font-family: 'Oswald', sans-serif; font-size: 20px; color: #0f0f10;">#{{ $order->id }}</span>
                                    </td>

                                    <!-- Имя -->
                                    <td style="padding: 1.5rem 2rem;">
                                        <span style="font-family: 'Inter', sans-serif; font-size: 16px; color: #555;">
                                            {{ $order->name ?? 'НЕ УКАЗАНО' }}
                                        </span>
                                    </td>

                                    <!-- Дата -->
                                    <td style="padding: 1.5rem 2rem;">
                                        <span style="font-family: 'Inter', sans-serif; font-size: 16px; color: #555;">
                                            {{ \Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i') }}
                                        </span>
                                    </td>

                                    <!-- Сумма -->
                                    <td style="padding: 1.5rem 2rem;">
                                        <span
                                            style="font-family: 'Oswald', sans-serif; font-size: 24px; color: #0f0f10;">
                                            {{ number_format($order->total, 0, '', ' ') }} ₽
                                        </span>
                                    </td>

                                    <!-- Статус -->
                                    <td style="padding: 1.5rem 2rem;">
                                        @php
                                            $statusMap = [
                                                0 => ['label' => 'НОВЫЙ', 'color' => '#0f0f10'],
                                                1 => ['label' => 'В ОБРАБОТКЕ', 'color' => '#777'],
                                                2 => ['label' => 'ПОДТВЕРЖДЕН', 'color' => '#0f0f10'],
                                                3 => ['label' => 'ОТПРАВЛЕН', 'color' => '#0f0f10'],
                                                4 => ['label' => 'ДОСТАВЛЕН', 'color' => '#0f0f10'],
                                                5 => ['label' => 'ОТМЕНЕН', 'color' => '#777'],
                                            ];
                                            $statusInfo = $statusMap[$order->status] ?? [
                                                'label' => 'НЕИЗВЕСТЕН',
                                                'color' => '#777',
                                            ];
                                        @endphp
                                        <span
                                            style="display: inline-block; padding: 0.5rem 1.5rem; border: 2px solid {{ $statusInfo['color'] }}; font-family: 'Oswald', sans-serif; font-size: 14px; letter-spacing: 1px; color: {{ $statusInfo['color'] }}; transition: all 0.3s ease;"
                                            onmouseover="this.style.background='{{ $statusInfo['color'] }}'; this.style.color='white'"
                                            onmouseout="this.style.background='transparent'; this.style.color='{{ $statusInfo['color'] }}'">
                                            {{ $statusInfo['label'] }}
                                        </span>
                                    </td>

                                    <!-- Действия -->
                                    <td style="padding: 1.5rem 2rem;">
                                        <a href="{{ route('orders-show', $order->id) }}" wire:navigate
                                            style="font-family: 'Oswald', sans-serif; font-size: 16px; letter-spacing: 1px; color: #0f0f10; text-decoration: none; border: 2px solid #e5e5e5; padding: 0.75rem 1.5rem; display: inline-block; transition: all 0.3s ease; position: relative; overflow: hidden;">
                                            <span style="position: relative; z-index: 1;">ПОДРОБНЕЕ</span>
                                            <div style="position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: #0f0f10; transition: all 0.3s ease;"
                                                onmouseover="this.style.left='0'" onmouseout="this.style.left='-100%'">
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Пагинация -->
                <div style="border-top: 2px solid #e5e5e5; padding: 2rem;">
                    <div
                        style="display: flex; flex-direction: column; align-items: center; justify-content: space-between; gap: 1rem;">
                        <div style="font-family: 'Inter', sans-serif; font-size: 16px; color: #777;">
                            ПОКАЗАНО {{ $orders->firstItem() ?? 0 }}-{{ $orders->lastItem() ?? 0 }} ИЗ
                            {{ $orders->total() }} ЗАКАЗОВ
                        </div>
                        <div style="display: flex; gap: 0.5rem;">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Блок "Нет заказов" с анимацией -->
            <div
                style="border: 2px solid #e5e5e5; background: #fff; padding: 5rem; text-align: center; animation: fadeInUp 0.8s ease-out;">
                <!-- Анимированная иконка -->
                <div
                    style="width: 120px; height: 120px; border: 2px solid #e5e5e5; margin: 0 auto 2rem; display: flex; align-items: center; justify-content: center; animation: pulse 2s infinite;">
                    <svg style="width: 60px; height: 60px; color: #777;" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>

                <h3
                    style="font-family: 'Oswald', sans-serif; font-size: 36px; letter-spacing: 2px; color: #0f0f10; margin-bottom: 1rem;">
                    ЗАКАЗОВ ПОКА НЕТ
                </h3>

                <p style="font-family: 'Inter', sans-serif; font-size: 18px; color: #777; margin-bottom: 2rem;">
                    Сделайте свой первый заказ, и он появится здесь
                </p>

                <a href="/catalog" wire:navigate
                    style="display: inline-block; font-family: 'Oswald', sans-serif; font-size: 20px; letter-spacing: 2px; color: #fff; background: #0f0f10; border: 2px solid #0f0f10; padding: 1.25rem 3rem; text-decoration: none; transition: all 0.3s ease; position: relative; overflow: hidden;">
                    <span style="position: relative; z-index: 1;">ПЕРЕЙТИ В КАТАЛОГ</span>
                    <div style="position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: #333; transition: all 0.3s ease;"
                        onmouseover="this.style.left='0'" onmouseout="this.style.left='-100%'"></div>
                </a>
            </div>
        @endif
    </div>

    <style>
        /* Анимации */
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInRow {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes expandWidth {
            from {
                width: 0;
                opacity: 0;
            }

            to {
                width: 100px;
                opacity: 1;
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                border-color: #e5e5e5;
            }

            50% {
                transform: scale(1.05);
                border-color: #0f0f10;
            }

            100% {
                transform: scale(1);
                border-color: #e5e5e5;
            }
        }

        /* Общие стили */
        * {
            border-radius: 0 !important;
        }

        /* Анимации для всех интерактивных элементов */
        button,
        a {
            transition: all 0.3s ease !important;
            position: relative;
            overflow: hidden;
        }

        button:active,
        a:active {
            transform: scale(0.95);
        }

        /* Стили для пагинации */
        .pagination {
            display: flex;
            gap: 0.5rem;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination .page-item {
            display: inline-block;
        }

        .pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            font-family: 'Oswald', sans-serif;
            font-size: 16px;
            letter-spacing: 1px;
            color: #0f0f10;
            border: 2px solid #e5e5e5;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .pagination .page-link:hover {
            background: #0f0f10;
            color: white;
            border-color: #0f0f10;
        }

        .pagination .active .page-link {
            background: #0f0f10;
            color: white;
            border-color: #0f0f10;
        }

        .pagination .disabled .page-link {
            opacity: 0.5;
            pointer-events: none;
        }

        /* Медиа-запросы для адаптивности */
        @media (max-width: 768px) {
            h1 {
                font-size: 48px !important;
            }

            table th,
            table td {
                padding: 1rem !important;
            }

            .pagination .page-link {
                width: 35px;
                height: 35px;
                font-size: 14px;
            }
        }

        @media (max-width: 640px) {
            .pagination .page-item:not(.active):not(:first-child):not(:last-child) {
                display: none;
            }
        }
    </style>
</div>
