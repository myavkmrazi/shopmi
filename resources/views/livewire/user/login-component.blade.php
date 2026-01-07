<div>
    <div class="container py-5">
        {{-- ХЛЕБНЫЕ КРОШКИ --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" wire:navigate>Главная</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Вход в аккаунт</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-card">
                    {{-- Заголовок --}}
                    <div class="login-header">
                        <h2 class="mb-1"><i class="fas fa-sign-in-alt me-2"></i>Вход в аккаунт</h2>
                        <p class="mb-0">С возвращением! Пожалуйста, войдите в свой аккаунт</p>
                    </div>

                    {{-- Форма входа --}}
                    <div class="login-body">
                        {{-- Сообщение об успехе --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-4">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Скрытые поля для обмана браузера --}}
                        <div style="display: none;">
                            <input type="text" name="fake-username" autocomplete="username">
                            <input type="password" name="fake-password" autocomplete="current-password">
                        </div>

                        <form wire:submit="login" autocomplete="off" id="login-form">

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="login-email" class="form-label">Email адрес</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="login-email" name="login_email" autocomplete="new-email" wire:model="email"
                                        placeholder="example@mail.com" autofocus>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Пароль --}}
                            <div class="mb-3">
                                <label for="login-password" class="form-label">Пароль</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="login-password" name="login_password" autocomplete="new-password"
                                        wire:model="password" placeholder="Введите ваш пароль">
                                    <button class="btn btn-outline-secondary" type="button"
                                        onclick="togglePassword('login-password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Запомнить меня и забыли пароль --}}
                            <div class="mb-4 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="login-remember"
                                        name="login_remember" wire:model="remember">
                                    <label class="form-check-label small" for="login-remember">
                                        Запомнить меня
                                    </label>
                                </div>
                                <a href="#" class="small login-link">Забыли пароль?</a>
                            </div>

                            {{-- Кнопка входа --}}
                            <button type="submit" class="btn btn-login w-100 mb-3" wire:loading.attr="disabled">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                <span wire:loading.remove>Войти</span>
                                <span wire:loading>Вход...</span>
                            </button>
                        </form>

                        {{-- Ссылка на регистрацию --}}
                        <div class="text-center mt-4">
                            <span class="text-muted">Еще нет аккаунта?</span>
                            <a href="{{ route('register') }}" class="login-link ms-1" wire:navigate>
                                Зарегистрироваться
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
            const icon = input.nextElementSibling.querySelector('i');

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

        // Полный сброс автозаполнения при загрузке страницы
        document.addEventListener('DOMContentLoaded', function() {
            // Очищаем все поля формы
            const form = document.getElementById('login-form');
            if (form) {
                form.reset();

                // Устанавливаем пустые значения для всех инпутов
                const inputs = form.querySelectorAll('input');
                inputs.forEach(input => {
                    input.value = '';
                    if (input.type === 'checkbox') {
                        input.checked = false;
                    }
                });
            }

            // Отключаем автозаполнение глобально
            document.querySelectorAll('input').forEach(input => {
                input.setAttribute('autocomplete', 'off');
                input.setAttribute('autocorrect', 'off');
                input.setAttribute('autocapitalize', 'off');
                input.setAttribute('spellcheck', 'false');
            });
        });
    </script>

    <style>
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin: 1rem 0 2rem 0;
        }

        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .login-body {
            padding: 2rem;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-login:disabled {
            opacity: 0.7;
            transform: none;
        }

        .login-link {
            color: #667eea;
            text-decoration: none;
        }

        .login-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        /* Стили для хлебных крошек */
        .breadcrumb {
            background: transparent;
            padding: 0;
        }

        .breadcrumb-item a {
            color: #667eea;
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .breadcrumb-item.active {
            color: #6c757d;
        }
    </style>
</div>
