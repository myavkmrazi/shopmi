<div>
    <div class="container">
        {{-- ХЛЕБНЫЕ КРОШКИ --}}
        <nav aria-label="breadcrumb" class="my-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" wire:navigate>Главная</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Регистрация</li>
            </ol>
        </nav>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="register-card">
                    {{-- Заголовок --}}
                    <div class="register-header">
                        <h2 class="mb-1"><i class="fas fa-user-plus me-2"></i>Создать аккаунт</h2>
                        <p class="mb-0">Присоединяйтесь к нашему сообществу</p>
                    </div>

                    {{-- Форма регистрации --}}
                    <div class="register-body">
                        <form wire:submit="save">
                            {{-- Имя --}}
                            <div class="mb-3">
                                <label for="name" class="form-label">Полное имя</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" wire:model="name" placeholder="Введите ваше имя">
                                </div>
                                @error('name')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            {{-- surname --}}
                            <div class="mb-3">
                                <label for="surname" class="form-label">Фамилия</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control @error('surname') is-invalid @enderror"
                                        id="surname" wire:model="surname" placeholder="Введите свою фамилию">
                                </div>
                                @error('surname')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">Email адрес</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" wire:model="email" placeholder="example@mail.com">
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Пароль --}}
                            <div class="mb-3">
                                <label for="password" class="form-label">Пароль</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" wire:model="password" placeholder="Минимум 8 символов">
                                    <button class="btn btn-outline-secondary" type="button"
                                        onclick="togglePassword('password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Подтверждение пароля --}}
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Подтвердите пароль</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation"
                                        wire:model="password_confirmation" placeholder="Повторите пароль">
                                </div>
                                @error('password_confirmation')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Соглашение --}}
                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="terms" wire:model="terms">
                                <label class="form-check-label small" for="terms">
                                    Я соглашаюсь с <a href="#" class="login-link">условиями использования</a>
                                    и <a href="#" class="login-link">политикой конфиденциальности</a>
                                </label>
                                @error('terms')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Кнопка регистрации --}}
                            <button type="submit" class="btn btn-register w-100 mb-3" wire:loading.attr="disabled">
                                <i class="fas fa-user-plus me-2"></i>
                                <span wire:loading.remove>Зарегистрироваться</span>
                                <span wire:loading>Регистрация...</span>
                            </button>

                            {{-- Ссылка на вход --}}
                            <div class="text-center">
                                <span class="text-muted">Уже есть аккаунт?</span>
                                <a href="/login" class="login-link ms-1" wire:navigate>Войти</a>
                            </div>
                        </form>
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
    </script>

    <style>
        .register-card {
            background: white;
            border: 1px solid #e5e5e5;
            border-radius: 0;
            box-shadow: none;
            overflow: hidden;
            margin: 2rem 0;
        }

        .register-header {
            background: #0f0f10;
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .register-header h2,
        .btn-register,
        .login-link {
            font-family: 'Oswald', sans-serif;
            letter-spacing: 1px;
        }

        .register-body {
            padding: 2rem;
        }

        .form-control:focus {
            border-color: #0f0f10;
            box-shadow: 0 0 0 0.2rem rgba(184, 255, 44, 0.35);
        }

        .btn-register {
            background: #0f0f10;
            border: none;
            color: white;
            padding: 12px;
            font-weight: 600;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            background: #b8ff2c;
            color: #0f0f10;
        }

        .login-link {
            color: #0f0f10;
            text-decoration: none;
        }

        .login-link:hover {
            color: #0f0f10;
            text-decoration: underline;
        }
    </style>
</div>
