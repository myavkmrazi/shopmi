<div class="navbar-nav ms-auto d-flex flex-row align-items-center">
    @auth
        {{-- Пользователь авторизован --}}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fas fa-user-circle me-1"></i>
                {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('account') }}">
                        <i class="fas fa-user me-2"></i>Профиль
                    </a></li>
                <li><a class="dropdown-item" href="#">
                        <i class="fas fa-shopping-bag me-2"></i>Мои заказы
                    </a></li>

                @if (auth()->user()->is_admin)
                    <li><a class="dropdown-item" href="{{ route('admin') }}">
                            <i class="fas fa-cog me-2"></i>Панель управления
                        </a></li>
                @endif

                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    {{-- ПРОСТАЯ ССЫЛКА ДЛЯ ВЫХОДА --}}
                    <a class="dropdown-item" href="{{ route('logout') }}" wire:navigate>
                        <i class="fas fa-sign-out-alt me-2"></i>Выйти
                    </a>
                </li>
            </ul>
        </li>
    @else
        {{-- Пользователь не авторизован --}}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fas fa-user"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="{{ route('login') }}" wire:navigate>
                        <i class="fas fa-sign-in-alt me-2"></i>Войти
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('register') }}" wire:navigate>
                        <i class="fas fa-user-plus me-2"></i>Регистрация
                    </a>
                </li>
            </ul>
        </li>
    @endauth
</div>
