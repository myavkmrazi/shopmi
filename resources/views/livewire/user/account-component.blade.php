<!-- account-component.blade.php -->
<div>
    <!-- Основной контент -->
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">

            <!-- Левая панель - меню -->
            <div class="lg:w-1/4">
                <!-- Информация о пользователе -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-xl text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">{{ auth()->user()->name ?? 'Пользователь' }}</h3>
                            <p class="text-gray-500 text-sm">{{ auth()->user()->email ?? 'Email не указан' }}</p>
                        </div>
                    </div>
                    <div class="text-center">
                        <span class="inline-block text-xs bg-green-100 text-green-800 px-3 py-1 rounded-full">
                            <i class="fas fa-star mr-1"></i>Постоянный клиент
                        </span>
                    </div>
                </div>

                <!-- Контейнер с ссылками Account -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <!-- Заголовок контейнера -->
                    <div class="mb-4 pb-4 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900">
                            <i class="fas fa-user-circle mr-2 text-blue-600"></i>Account
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">Manage your account settings</p>
                    </div>

                    <!-- Список ссылок с кнопками -->
                    <div class="space-y-3">
                        <!-- Профиль -->
                        <div
                            class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-user text-blue-600 w-5 mr-3"></i>
                                <div>
                                    <p class="font-medium text-gray-900">Профиль</p>
                                    <p class="text-xs text-gray-500">Manage your personal information</p>
                                </div>
                            </div>
                            <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Edit
                            </button>
                        </div>

                        <!-- Заказы -->
                        <div
                            class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-shopping-bag text-green-600 w-5 mr-3"></i>
                                <div>
                                    <p class="font-medium text-gray-900">Мои заказы</p>
                                    <p class="text-xs text-gray-500">View and manage your orders</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                @if ($ordersCount > 0)
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-2">
                                        {{ $ordersCount }}
                                    </span>
                                @endif
                                <a href="{{ route('orders') }}"
                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    View
                                </a>
                            </div>
                        </div>

                        <!-- Адреса -->
                        <div
                            class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt text-purple-600 w-5 mr-3"></i>
                                <div>
                                    <p class="font-medium text-gray-900">Адреса доставки</p>
                                    <p class="text-xs text-gray-500">Manage your delivery addresses</p>
                                </div>
                            </div>
                            <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Manage
                            </button>
                        </div>

                        <!-- Избранное -->
                        <div
                            class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-heart text-red-600 w-5 mr-3"></i>
                                <div>
                                    <p class="font-medium text-gray-900">Избранное</p>
                                    <p class="text-xs text-gray-500">Your saved items</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full mr-2">12</span>
                                <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    View
                                </button>
                            </div>
                        </div>

                        <!-- Безопасность -->
                        <div
                            class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-shield-alt text-yellow-600 w-5 mr-3"></i>
                                <div>
                                    <p class="font-medium text-gray-900">Безопасность</p>
                                    <p class="text-xs text-gray-500">Password and security settings</p>
                                </div>
                            </div>
                            <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Change
                            </button>
                        </div>

                        <!-- Уведомления -->
                        <div
                            class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-bell text-indigo-600 w-5 mr-3"></i>
                                <div>
                                    <p class="font-medium text-gray-900">Уведомления</p>
                                    <p class="text-xs text-gray-500">Notification preferences</p>
                                </div>
                            </div>
                            <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Settings
                            </button>
                        </div>
                    </div>

                    <!-- Кнопка выхода -->
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <button
                            class="w-full flex items-center justify-center p-3 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            <span class="font-medium">Выйти из аккаунта</span>
                        </button>
                    </div>
                </div>

                <!-- Статистика -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h4 class="font-bold mb-4 flex items-center">
                        <i class="fas fa-chart-bar mr-2 text-blue-600"></i>
                        Ваша статистика
                    </h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-2 hover:bg-gray-50 rounded">
                            <span class="text-gray-600 text-sm">Всего заказов:</span>
                            <span class="font-bold">15</span>
                        </div>
                        <div class="flex justify-between items-center p-2 hover:bg-gray-50 rounded">
                            <span class="text-gray-600 text-sm">На сумму:</span>
                            <span class="font-bold text-green-600">45 670 ₽</span>
                        </div>
                        <div class="flex justify-between items-center p-2 hover:bg-gray-50 rounded">
                            <span class="text-gray-600 text-sm">Бонусы:</span>
                            <span class="font-bold text-blue-600">1 245</span>
                        </div>
                        <div class="flex justify-between items-center p-2 hover:bg-gray-50 rounded">
                            <span class="text-gray-600 text-sm">В избранном:</span>
                            <span class="font-bold text-red-600">12</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Правая часть - контент -->
            <div class="lg:w-3/4">
                <!-- Заголовок страницы -->
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Личный кабинет</h1>
                    <p class="text-gray-600 mt-2">Добро пожаловать в ваш личный кабинет. Здесь вы можете управлять
                        своими данными, заказами и настройками.</p>
                </div>

                <!-- Быстрые действия -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-blue-50 rounded-lg p-5 border border-blue-100">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-shopping-cart text-blue-600"></i>
                            </div>
                            <h3 class="font-bold text-lg">Мои заказы</h3>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Отслеживайте текущие и просматривайте прошлые заказы</p>
                        <button class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                            Посмотреть все заказы →
                        </button>
                    </div>

                    <div class="bg-green-50 rounded-lg p-5 border border-green-100">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-heart text-green-600"></i>
                            </div>
                            <h3 class="font-bold text-lg">Избранное</h3>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Товары, которые вы сохранили для покупки позже</p>
                        <button class="text-green-600 hover:text-green-800 font-medium text-sm">
                            Перейти к избранному →
                        </button>
                    </div>

                    <div class="bg-purple-50 rounded-lg p-5 border border-purple-100">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-map-marker-alt text-purple-600"></i>
                            </div>
                            <h3 class="font-bold text-lg">Адреса</h3>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Управляйте адресами для доставки заказов</p>
                        <button class="text-purple-600 hover:text-purple-800 font-medium text-sm">
                            Управление адресами →
                        </button>
                    </div>
                </div>

                <!-- Контент профиля -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-900">
                            <i class="fas fa-id-card mr-2 text-blue-600"></i>Личные данные
                        </h2>
                        <button type="button" onclick="window.location.href='{{ route('change-account') }}'"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-edit mr-2"></i>Редактировать профиль
                        </button>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Полное имя</label>
                                <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    {{ auth()->user()->name ?? 'Не указано' }} {{ auth()->user()->surname ?? '' }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email адрес</label>
                                <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    {{ auth()->user()->email ?? 'Не указано' }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Дата рождения</label>
                                <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    {{ auth()->user()->birthdate ?? '15.03.1985' }}
                                </div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Телефон</label>
                                <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    {{ auth()->user()->phone ?? '+7 (999) 123-45-67' }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Дата регистрации</label>
                                <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    {{ auth()->user()->created_at ? auth()->user()->created_at->format('d.m.Y') : '12.01.2023' }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Статус аккаунта</label>
                                <div class="p-3 bg-green-50 rounded-lg border border-green-200 text-green-800">
                                    <i class="fas fa-check-circle mr-2"></i>Активный
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Последние заказы -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-900">
                            <i class="fas fa-history mr-2 text-blue-600"></i>Последние заказы
                        </h2>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">
                            Все заказы <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    <div class="space-y-4">
                        <!-- Заказ 1 -->
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                            <div class="flex flex-col md:flex-row md:items-center justify-between mb-3">
                                <div>
                                    <span class="font-bold text-blue-600">#24578</span>
                                    <span class="text-gray-500 text-sm ml-3">12.03.2024</span>
                                </div>
                                <div class="flex items-center mt-2 md:mt-0">
                                    <span class="font-bold text-lg">12 450 ₽</span>
                                    <span class="ml-4 px-3 py-1 rounded-full text-sm bg-green-100 text-green-800">
                                        Выполнен
                                    </span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <p class="text-gray-600">3 товара • Доставлен по адресу: ул. Примерная, 123</p>
                                <button class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                    Подробнее <i class="fas fa-chevron-right ml-1"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Заказ 2 -->
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                            <div class="flex flex-col md:flex-row md:items-center justify-between mb-3">
                                <div>
                                    <span class="font-bold text-blue-600">#24576</span>
                                    <span class="text-gray-500 text-sm ml-3">10.03.2024</span>
                                </div>
                                <div class="flex items-center mt-2 md:mt-0">
                                    <span class="font-bold text-lg">8 900 ₽</span>
                                    <span class="ml-4 px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                                        В обработке
                                    </span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <p class="text-gray-600">2 товара • Ожидает подтверждения</p>
                                <button class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                    Подробнее <i class="fas fa-chevron-right ml-1"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Обработка кнопок в контейнере Account
            const accountButtons = document.querySelectorAll('[class*="p-3 hover:bg-gray-50"] button');
            accountButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const parent = this.closest('div.flex.items-center.justify-between');
                    const title = parent.querySelector('.font-medium').textContent;

                    switch (title) {
                        case 'Профиль':
                            alert('Редактирование профиля');
                            break;
                        case 'Мои заказы':
                            window.location.href = '/orders';
                            break;
                        case 'Адреса доставки':
                            alert('Управление адресами');
                            break;
                        case 'Избранное':
                            window.location.href = '/favorites';
                            break;
                        case 'Безопасность':
                            alert('Изменение настроек безопасности');
                            break;
                        case 'Уведомления':
                            alert('Настройка уведомлений');
                            break;
                    }
                });
            });

            // Обработка клика на всю строку
            const accountItems = document.querySelectorAll('[class*="p-3 hover:bg-gray-50"]');
            accountItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    if (!e.target.closest('button')) {
                        const title = this.querySelector('.font-medium').textContent;
                        console.log('Переход к разделу:', title);
                    }
                });
            });

            // Кнопка выхода
            document.querySelector('button:contains("Выйти")').addEventListener('click', function() {
                if (confirm('Вы уверены, что хотите выйти?')) {
                    // Здесь будет запрос на выход
                    window.location.href = '/logout';
                }
            });
        });
    </script>
</div>
