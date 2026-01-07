<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @section('metatags')
        <title>ShopMI :: {{ $title ?? 'Интернет-магазин' }}</title>
        <meta name="description" content="Лучший интернет-магазин с быстрой доставкой">

        <!-- Favicon для вкладки браузера -->
        <link rel="icon" type="image/png" href="{{ asset('logo.myavk.png') }}">
        {{-- Bootstrap CSS --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

        {{-- Font Awesome для иконок --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        {{-- Toastr CSS --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
        <link rel="icon" type="image/x-icon" href="{{ asset('logomyavk') }}">

        {{-- Vite: CSS + JS --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Livewire styles --}}
        @livewireStyles

        <style>
            /* ========== ФИКСИРУЕМ НАВБАР ========== */
            .navbar {
                position: sticky;
                top: 0;
                z-index: 1030;
                min-height: 60px;
                overflow: visible;
            }

            .navbar .container {
                position: relative;
            }

            .navbar .dropdown-menu {
                position: absolute;
                border: none;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
                padding: 10px 0;
                margin-top: 5px;
            }

            .navbar .dropend>.dropdown-menu {
                position: absolute;
                top: -10px;
                left: 100%;
                margin-left: 0;
                display: none;
                opacity: 0;
                transform: translateX(-10px);
                transition: all 0.3s ease;
            }

            .navbar .dropend:hover>.dropdown-menu {
                display: block !important;
                opacity: 1;
                transform: translateX(0);
            }

            .navbar-nav {
                align-items: center;
            }

            .nav-item {
                position: relative;
            }

            .navbar-collapse {
                overflow: visible;
            }

            .navbar .dropdown-item:hover {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
            }

            @media (max-width: 768px) {
                .navbar {
                    min-height: auto;
                    overflow: visible;
                }

                .navbar .dropend>.dropdown-menu {
                    position: static;
                    margin: 0;
                    box-shadow: none;
                    opacity: 1;
                    transform: none;
                    display: none !important;
                }

                .navbar .dropend:hover>.dropdown-menu {
                    display: block !important;
                }
            }
        </style>

        @stack('head')
    </head>

    <body>
        {{-- ========== HEADER / NAVBAR ========== --}}
        <nav class="navbar navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}" wire:navigate>
                    ShopMI
                </a>

                <livewire:search.search-form-component />

                {{-- ЛЕВАЯ ЧАСТЬ МЕНЮ --}}
                <ul class="navbar-nav me-auto d-flex flex-row">
                    <li class="nav-item me-3">
                        <a class="nav-link" href="{{ route('home') }}" wire:navigate>Home</a>
                    </li>

                    {{-- МЕНЮ КАТЕГОРИЙ --}}
                    <li class="nav-item me-3 dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                            aria-expanded="false">Category</a>
                        <ul class="dropdown-menu">
                            {!! \App\Helpers\Category\Category::getMenu('incs.menu-tpl', 'categories_html') !!}
                        </ul>
                    </li>

                    <li class="nav-item me-3">
                        <a class="nav-link" href="https://t.me/+Ln5wsCSUkqk4OGJi" target="_blank"
                            rel="noopener">Телеграм</a>
                    </li>

                    {{-- Livewire компонент корзины --}}
                    <livewire:cart.cart-icon-component />
                </ul>

                <livewire:user.nav-component />
                </>
        </nav>

        {{-- ========== MAIN CONTENT ========== --}}
        <main>
            {{ $slot }}
        </main>

        {{-- ========== FOOTER ========== --}}
        <footer class="bg-white border-top py-3 mt-auto">
            <div class="container text-center small">
                &copy; {{ date('Y') }} {{ config('', 'shopMI') }}. Все права защищены.
            </div>
        </footer>

        <livewire:cart.cart-modal-component />

        {{-- ========== ПРАВИЛЬНЫЙ ПОРЯДОК ПОДКЛЮЧЕНИЯ СКРИПТОВ ========== --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
        @livewireScripts
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" defer></script>
        @vite(['resources/js/app.js'])
        <script src="{{ asset('assets/js/main.js') }}" defer></script>
        @stack('scripts')
    </body>

    </html>
