<div class="shopmi-page shopmi-account shopmi-animate-in">
    <div class="shopmi-shell">
        <ol class="shopmi-breadcrumb">
            <li><a href="{{ route('home') }}" wire:navigate>Главная</a></li>
            <li><a href="{{ route('account') }}" wire:navigate>Личный кабинет</a></li>
            <li class="active">Редактирование</li>
        </ol>

        <header class="shopmi-page-head">
            <p class="shopmi-kicker mb-0">Настройки</p>
            <h1 class="shopmi-heading">Профиль</h1>
            <p class="shopmi-subtitle">Обновите личные данные и пароль.</p>
        </header>

        <div class="shopmi-account-layout">
            <aside class="shopmi-account-nav shopmi-panel">
                <div class="shopmi-account-nav__head">
                    <h2 class="shopmi-title fs-3 mb-0">Аккаунт</h2>
                </div>
                <nav aria-label="Меню аккаунта">
                    <a href="{{ route('account') }}" class="shopmi-account-link" wire:navigate>
                        <span><i class="fas fa-user me-2"></i>Профиль</span>
                    </a>
                    <a href="{{ route('change-account') }}" class="shopmi-account-link active" wire:navigate>
                        <span><i class="fas fa-pen me-2"></i>Редактирование</span>
                    </a>
                    <a href="{{ route('orders') }}" class="shopmi-account-link" wire:navigate>
                        <span><i class="fas fa-bag-shopping me-2"></i>Мои заказы</span>
                    </a>
                </nav>
            </aside>

            <div class="shopmi-panel">
                <form wire:submit.prevent="save" class="d-grid gap-4">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Имя</label>
                            <input type="text" id="name" wire:model="name"
                                class="form-control shopmi-input @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="surname" class="form-label">Фамилия</label>
                            <input type="text" id="surname" wire:model="surname"
                                class="form-control shopmi-input @error('surname') is-invalid @enderror">
                            @error('surname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" wire:model="email"
                                class="form-control shopmi-input @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Новый пароль</label>
                            <input type="password" id="password" wire:model="password"
                                class="form-control shopmi-input @error('password') is-invalid @enderror"
                                placeholder="Оставьте пустым, если не меняете">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 justify-content-between">
                        <a href="{{ route('account') }}" class="shopmi-btn shopmi-btn-outline" wire:navigate>
                            <i class="fas fa-arrow-left"></i> Назад
                        </a>
                        <button type="submit" class="shopmi-btn" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="save">
                                <i class="fas fa-save"></i> Сохранить
                            </span>
                            <span wire:loading wire:target="save">
                                <i class="fas fa-spinner fa-spin"></i> Сохранение...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="position-fixed bottom-0 end-0 p-4" style="z-index: 1050;">
            <div class="shopmi-panel mb-0 py-3 px-4">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        </div>
    @endif
</div>
