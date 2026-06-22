<ul class="navbar-nav shopmi-nav shopmi-navbar__user">
    @auth
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown"
                aria-expanded="false">
                {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="{{ route('account') }}" wire:navigate>
                        <i class="fas fa-user me-2"></i>Профиль
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('orders') }}" wire:navigate>
                        <i class="fas fa-bag-shopping me-2"></i>Мои заказы
                    </a>
                </li>

                @if (auth()->user()->is_admin)
                    <li>
                        <a class="dropdown-item" href="{{ route('admin') }}">
                            <i class="fas fa-gauge-high me-2"></i>Админка
                        </a>
                    </li>
                @endif

                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-right-from-bracket me-2"></i>Выйти
                        </button>
                    </form>
                </li>
            </ul>
        </li>
    @else
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fas fa-user"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="{{ route('login') }}" wire:navigate>Войти</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('register') }}" wire:navigate>Регистрация</a>
                </li>
            </ul>
        </li>
    @endauth
</ul>
