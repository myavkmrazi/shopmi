<div>
    <div class="container py-5">
        {{-- ХЛЕБНЫЕ КРОШКИ В СТИЛЕ МИНИМАЛИЗМ --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb" style="background: none; padding: 0; margin: 0;">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" wire:navigate
                        style="color: #0f0f10; text-decoration: none; font-family: 'Oswald', sans-serif; letter-spacing: 1px; font-size: 14px;">ГЛАВНАЯ</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"
                    style="color: #777; font-family: 'Oswald', sans-serif; letter-spacing: 1px; font-size: 14px;">
                    ВХОД В АККАУНТ</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                {{-- КАРТОЧКА ВХОДА В СТИЛЕ МИНИМАЛИЗМ --}}
                <div style="border: 1px solid #e5e5e5; background: #fff;">

                    {{-- Заголовок --}}
                    <div style="border-bottom: 1px solid #e5e5e5; padding: 2rem; text-align: center;">
                        <h2
                            style="font-family: 'Oswald', sans-serif; font-size: 36px; letter-spacing: 2px; color: #0f0f10; margin-bottom: 0.5rem;">
                            <i class="fas fa-sign-in-alt me-2" style="color: #0f0f10;"></i>ВХОД В АККАУНТ
                        </h2>
                        <p
                            style="font-family: 'Oswald', sans-serif; color: #777; font-size: 16px; letter-spacing: 1px; margin: 0;">
                            С ВОЗВРАЩЕНИЕМ! ПОЖАЛУЙСТА, ВОЙДИТЕ</p>
                    </div>

                    {{-- Форма входа --}}
                    <div style="padding: 2rem;">
                        {{-- Сообщение об успехе --}}
                        @if (session('success'))
                            <div
                                style="border: 1px solid #0f0f10; background: #f8f8f8; padding: 1rem; margin-bottom: 2rem; color: #0f0f10; font-family: 'Oswald', sans-serif; font-size: 16px; letter-spacing: 1px; display: flex; justify-content: space-between; align-items: center;">
                                <span>{{ session('success') }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    style="filter: brightness(0);"></button>
                            </div>
                        @endif

                        {{-- Скрытые поля для обмана браузера --}}
                        <div style="display: none;">
                            <input type="text" name="fake-username" autocomplete="off">
                            <input type="password" name="fake-password" autocomplete="off">
                        </div>

                        <form wire:submit="login" id="login-form">

                            {{-- Email --}}
                            <div class="mb-4">
                                <label for="login-email" class="form-label"
                                    style="font-family: 'Oswald', sans-serif; font-size: 16px; letter-spacing: 1px; color: #0f0f10; margin-bottom: 0.5rem; display: block;">
                                    EMAIL АДРЕС
                                </label>
                                <div style="display: flex; border: 1px solid #e5e5e5;">
                                    <span
                                        style="padding: 0.75rem 1rem; background: #f8f8f8; border-right: 1px solid #e5e5e5; color: #0f0f10;">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="login-email" name="email" autocomplete="username" wire:model="email"
                                        placeholder="EXAMPLE@MAIL.COM" autofocus
                                        style="flex: 1; border: none; padding: 0.75rem 1rem; font-family: 'Oswald', sans-serif; font-size: 16px; letter-spacing: 1px; text-transform: uppercase; {{ $errors->has('email') ? 'border: 1px solid #dc3545;' : '' }}"
                                        onfocus="this.style.outline='none'">
                                </div>
                                @error('email')
                                    <div
                                        style="color: #dc3545; font-size: 14px; margin-top: 0.5rem; font-family: 'Oswald', sans-serif; letter-spacing: 1px;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Пароль --}}
                            <div class="mb-4">
                                <label for="login-password" class="form-label"
                                    style="font-family: 'Oswald', sans-serif; font-size: 16px; letter-spacing: 1px; color: #0f0f10; margin-bottom: 0.5rem; display: block;">
                                    ПАРОЛЬ
                                </label>
                                <div style="display: flex; border: 1px solid #e5e5e5;">
                                    <span
                                        style="padding: 0.75rem 1rem; background: #f8f8f8; border-right: 1px solid #e5e5e5; color: #0f0f10;">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="login-password" name="password" autocomplete="current-password"
                                        wire:model="password" placeholder="ВВЕДИТЕ ВАШ ПАРОЛЬ"
                                        style="flex: 1; border: none; padding: 0.75rem 1rem; font-family: 'Oswald', sans-serif; font-size: 16px; letter-spacing: 1px; text-transform: uppercase; {{ $errors->has('password') ? 'border: 1px solid #dc3545;' : '' }}"
                                        onfocus="this.style.outline='none'">
                                    <button class="btn" type="button" onclick="togglePassword('login-password')"
                                        style="border: none; border-left: 1px solid #e5e5e5; background: #f8f8f8; padding: 0.75rem 1rem; color: #0f0f10; cursor: pointer;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div
                                        style="color: #dc3545; font-size: 14px; margin-top: 0.5rem; font-family: 'Oswald', sans-serif; letter-spacing: 1px;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Запомнить меня и забыли пароль --}}
                            <div class="mb-4 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="login-remember"
                                        name="login_remember" wire:model="remember"
                                        style="border: 1px solid #e5e5e5; border-radius: 0; width: 18px; height: 18px; margin-right: 0.5rem;">
                                    <label class="form-check-label small" for="login-remember"
                                        style="font-family: 'Oswald', sans-serif; color: #777; font-size: 14px; letter-spacing: 1px;">
                                        ЗАПОМНИТЬ МЕНЯ
                                    </label>
                                </div>
                                <a href="#"
                                    style="color: #0f0f10; text-decoration: none; font-family: 'Oswald', sans-serif; font-size: 14px; letter-spacing: 1px; border-bottom: 1px solid transparent; transition: border-color 0.3s;"
                                    onmouseover="this.style.borderColor='#0f0f10'"
                                    onmouseout="this.style.borderColor='transparent'">
                                    ЗАБЫЛИ ПАРОЛЬ?
                                </a>
                            </div>

                            {{-- Кнопка входа --}}
                            <button type="submit" class="btn w-100" wire:loading.attr="disabled"
                                style="background: #0f0f10; color: white; border: none; padding: 1rem; font-family: 'Oswald', sans-serif; font-size: 18px; letter-spacing: 2px; cursor: pointer; transition: all 0.3s; margin-bottom: 1rem;">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                <span wire:loading.remove>ВОЙТИ</span>
                                <span wire:loading>ВХОД...</span>
                            </button>
                        </form>

                        {{-- Ссылка на регистрацию --}}
                        <div
                            style="text-align: center; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e5e5e5;">
                            <span
                                style="font-family: 'Oswald', sans-serif; color: #777; font-size: 16px; letter-spacing: 1px;">ЕЩЕ
                                НЕТ АККАУНТА? </span>
                            <a href="{{ route('register') }}" wire:navigate
                                style="color: #0f0f10; text-decoration: none; font-family: 'Oswald', sans-serif; font-size: 16px; letter-spacing: 1px; border-bottom: 1px solid transparent; transition: border-color 0.3s;"
                                onmouseover="this.style.borderColor='#0f0f10'"
                                onmouseout="this.style.borderColor='transparent'">
                                ЗАРЕГИСТРИРОВАТЬСЯ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const input = document.getElementById(fieldId);
            const button = input.parentElement.querySelector('button');
            const icon = button.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

    <style>
        /* Стили для хлебных крошек */
        .breadcrumb-item+.breadcrumb-item::before {
            content: "|";
            color: #e5e5e5;
        }

        /* Стили для инпутов */
        input:focus {
            outline: none !important;
        }

        /* Стили для кнопки при наведении */
        button[type="submit"]:hover {
            background: #333 !important;
        }

        button[type="submit"]:active {
            transform: scale(0.98);
        }

        button[type="submit"]:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        /* Стили для чекбокса */
        .form-check-input:checked {
            background-color: #0f0f10;
            border-color: #0f0f10;
        }

        .form-check-input:focus {
            box-shadow: none;
            border-color: #0f0f10;
        }

        /* Стили для ошибок */
        .is-invalid {
            border: 1px solid #dc3545 !important;
        }

        /* Анимации */
        button {
            transition: all 0.3s ease !important;
        }

        button:active {
            transform: scale(0.98);
        }

        /* Убираем скругления у Bootstrap */
        .btn,
        .form-control,
        .input-group-text {
            border-radius: 0 !important;
        }

        .form-check-input {
            border-radius: 0;
        }

        /* Шрифты для плейсхолдеров - тоже Bebas */
        ::placeholder {
            font-family: 'Oswald', sans-serif !important;
            font-size: 16px;
            letter-spacing: 1px;
            color: #aaa;
            opacity: 1;
        }

        /* Для разных браузеров */
        ::-webkit-input-placeholder {
            font-family: 'Oswald', sans-serif !important;
            font-size: 16px;
            letter-spacing: 1px;
            color: #aaa;
        }

        :-moz-placeholder {
            font-family: 'Oswald', sans-serif !important;
            font-size: 16px;
            letter-spacing: 1px;
            color: #aaa;
        }

        ::-moz-placeholder {
            font-family: 'Oswald', sans-serif !important;
            font-size: 16px;
            letter-spacing: 1px;
            color: #aaa;
        }

        :-ms-input-placeholder {
            font-family: 'Oswald', sans-serif !important;
            font-size: 16px;
            letter-spacing: 1px;
            color: #aaa;
        }

        /* Стили для самого вводимого текста */
        input[type="email"],
        input[type="password"],
        input[type="text"] {
            font-family: 'Oswald', sans-serif !important;
            font-size: 16px !important;
            letter-spacing: 1px !important;
            text-transform: uppercase !important;
        }

        /* Для автозаполненных полей */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px white inset !important;
            -webkit-text-fill-color: #0f0f10 !important;
            font-family: 'Oswald', sans-serif !important;
            font-size: 16px !important;
            letter-spacing: 1px !important;
        }
    </style>
</div>
