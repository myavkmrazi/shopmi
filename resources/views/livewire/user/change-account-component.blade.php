<!-- change-account.blade.php -->
<div>
    <!-- Хлебные крошки -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm">
            <li>
                <a href="/" class="text-gray-500 hover:text-gray-700">Главная</a>
            </li>
            <li>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            </li>
            <li>
                <a href="{{ route('account') }}" class="text-gray-500 hover:text-gray-700">Личный кабинет</a>
            </li>
            <li>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            </li>
            <li class="text-gray-900 font-medium">Редактирование профиля</li>
        </ol>
    </nav>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Левая панель - меню -->
        <div class="lg:w-1/4">
            <!-- Контейнер с ссылками Account -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <!-- Заголовок контейнера -->
                <div class="mb-4 pb-4 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900">
                        <i class="fas fa-user-circle mr-2 text-blue-600"></i>Account
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Manage your account settings</p>
                </div>

                <!-- Список ссылок -->
                <div class="space-y-2">
                    <!-- Профиль -->
                    <a href="{{ route('account') }}"
                        class="flex items-center p-3 hover:bg-gray-50 text-gray-700 rounded-lg transition-colors">
                        <i class="fas fa-user text-gray-600 w-5 mr-3"></i>
                        <span class="font-medium">Профиль</span>
                    </a>

                    <!-- Редактирование профиля (текущая страница) -->
                    <div class="flex items-center p-3 bg-blue-600 text-white rounded-lg">
                        <i class="fas fa-edit w-5 mr-3"></i>
                        <div>
                            <p class="font-medium">Редактирование</p>
                            <p class="text-xs text-blue-100">Change profile information</p>
                        </div>
                    </div>

                    <!-- Заказы -->
                    <a href="{{ route('orders') }}"
                        class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors">
                        <div class="flex items-center">
                            <i class="fas fa-shopping-bag text-gray-600 w-5 mr-3"></i>
                            <span class="font-medium text-gray-900">Мои заказы</span>
                        </div>
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">5</span>
                    </a>

                    <!-- Адреса -->
                    <a href="#" class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-map-marker-alt text-gray-600 w-5 mr-3"></i>
                        <span class="font-medium text-gray-900">Адреса доставки</span>
                    </a>

                    <!-- Избранное -->
                    <a href="#"
                        class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors">
                        <div class="flex items-center">
                            <i class="fas fa-heart text-gray-600 w-5 mr-3"></i>
                            <span class="font-medium text-gray-900">Избранное</span>
                        </div>
                        <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">12</span>
                    </a>
                </div>
            </div>

            <!-- Статистика -->
            <div class="bg-white rounded-lg shadow p-6">
                <h4 class="font-bold mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                    Важная информация
                </h4>
                <div class="space-y-3">
                    <div class="p-3 bg-blue-50 rounded-lg border border-blue-100">
                        <p class="text-sm text-blue-800">
                            <i class="fas fa-exclamation-circle mr-2"></i>Все поля обязательны для заполнения
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Правая часть - форма редактирования -->
        <div class="lg:w-3/4">
            <!-- Заголовок страницы -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-user-edit text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Редактирование профиля</h1>
                        <p class="text-gray-600">Обновите вашу личную информацию</p>
                    </div>
                </div>
            </div>

            <!-- Форма редактирования -->
            <div class="bg-white rounded-lg shadow p-6">
                <form wire:submit.prevent="save" class="space-y-6">
                    @csrf

                    <!-- Личные данные -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-id-card mr-2 text-blue-600"></i>Личные данные
                        </h3>

                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Имя -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Имя <span class="text-red-500">*</span>
                                </label>
                                <input type="text" wire:model="name"
                                    class="w-full p-3 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                    placeholder="Введите ваше имя">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Фамилия -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Фамилия <span class="text-red-500">*</span>
                                </label>
                                <input type="text" wire:model="surname"
                                    class="w-full p-3 border @error('surname') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                    placeholder="Введите вашу фамилию">
                                @error('surname')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Email адрес <span class="text-red-500">*</span>
                                </label>
                                <input type="email" wire:model="email"
                                    class="w-full p-3 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                    placeholder="example@email.com">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Пароль -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Новый пароль (оставьте пустым, если не хотите менять)
                                </label>
                                <input type="password" wire:model="password"
                                    class="w-full p-3 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                    placeholder="Введите новый пароль">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Минимум 6 символов</p>
                            </div>
                        </div>
                    </div>

                    <!-- Кнопки формы -->
                    <div class="flex flex-col sm:flex-row justify-between items-center pt-6 border-t border-gray-200">
                        <div class="mb-4 sm:mb-0">
                            <a href="{{ route('account') }}"
                                class="text-gray-600 hover:text-gray-900 font-medium flex items-center">
                                <i class="fas fa-arrow-left mr-2"></i>Вернуться в личный кабинет
                            </a>
                        </div>

                        <div class="flex space-x-4">
                            <!-- Кнопка отмены -->
                            <a href="{{ route('account') }}"
                                class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                                Отмена
                            </a>

                            <!-- Кнопка сохранения -->
                            <button type="submit"
                                class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                                <i class="fas fa-save mr-2"></i>Сохранить изменения
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Сообщение об успехе -->
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif
</div>
