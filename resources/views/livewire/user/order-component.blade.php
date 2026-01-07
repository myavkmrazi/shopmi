<!-- resources/views/livewire/user/order-component.blade.php -->
<div>
    <!-- Заголовок -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Мои заказы</h1>
        <p class="text-gray-600 mt-2">История ваших заказов</p>
    </div>

    @if ($orders->count() > 0)
        <!-- Таблица заказов -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-700">Номер заказа</th>
                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-700">Имя</th>
                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-700">Дата</th>
                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-700">Сумма</th>
                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-700">Статус</th>
                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-700">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <!-- Номер заказа -->
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <span class="text-blue-600 font-medium">#{{ $order->id }}</span>
                                </td>

                                <!-- Имя -->
                                <td class="py-4 px-6 whitespace-nowrap">
                                    {{ $order->name ?? 'Не указано' }}
                                </td>

                                <!-- Дата -->
                                <td class="py-4 px-6 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i') }}
                                </td>

                                <!-- Сумма -->
                                <td class="py-4 px-6 whitespace-nowrap font-bold">
                                    {{ number_format($order->total, 0, '', ' ') }} ₽
                                </td>

                                <!-- Статус -->
                                <td class="py-4 px-6 whitespace-nowrap">
                                    @php
                                        // Преобразуем числовой статус в текстовый
                                        $statusMap = [
                                            0 => ['label' => 'Новый', 'color' => 'bg-blue-100 text-blue-800'],
                                            1 => ['label' => 'В обработке', 'color' => 'bg-yellow-100 text-yellow-800'],
                                            2 => ['label' => 'Подтвержден', 'color' => 'bg-green-100 text-green-800'],
                                            3 => ['label' => 'Отправлен', 'color' => 'bg-purple-100 text-purple-800'],
                                            4 => ['label' => 'Доставлен', 'color' => 'bg-green-100 text-green-800'],
                                            5 => ['label' => 'Отменен', 'color' => 'bg-red-100 text-red-800'],
                                        ];

                                        $statusInfo = $statusMap[$order->status] ?? [
                                            'label' => 'Неизвестен',
                                            'color' => 'bg-gray-100 text-gray-800',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusInfo['color'] }}">
                                        {{ $statusInfo['label'] }}
                                    </span>
                                </td>

                                <!-- Действия -->
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <a href="{{ route('orders-show', $order->id) }}"
                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Подробнее
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Пагинация -->
            <div class="px-6 py-4 border-t border-gray-200">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="text-sm text-gray-500 mb-4 md:mb-0">
                        Показано {{ $orders->firstItem() ?? 0 }}-{{ $orders->lastItem() ?? 0 }} из
                        {{ $orders->total() }} заказов
                    </div>
                    <div>
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Блок "Нет заказов" -->
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-medium text-gray-900 mb-2">Заказов пока нет</h3>
            <p class="text-gray-500 mb-6">Сделайте свой первый заказ, и он появится здесь</p>
            <a href="/catalog"
                class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                Перейти в каталог
            </a>
        </div>
    @endif
</div>
