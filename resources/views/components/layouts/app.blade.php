<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @section('metatags')
        <title>ShopMI :: {{ $title ?? 'Store' }}</title>
        <meta name="description" content="ShopMI portfolio store">
        <link rel="icon" type="image/png" href="{{ asset('logo.myavk.png') }}">
        <link rel="icon" type="image/x-icon" href="{{ asset('logomyavk') }}">
    @show

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('head')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light shopmi-navbar">
        <div class="container shopmi-navbar__inner">
            <a class="navbar-brand" href="{{ route('home') }}" wire:navigate>SHOPMI</a>

            <ul class="navbar-nav shopmi-nav shopmi-navbar__links">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}" wire:navigate>HOME</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://t.me/+Ln5wsCSUkqk4OGJi" target="_blank" rel="noopener">
                        TELEGRAM
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        CATEGORY
                    </a>
                    <ul class="dropdown-menu">
                        {!! \App\Helpers\Category\Category::getMenu('incs.menu-tpl', 'categories_html') !!}
                    </ul>
                </li>
                <livewire:cart.cart-icon-component />
            </ul>

            <div class="shopmi-navbar__end">
                <livewire:search.search-form-component />
                <livewire:user.nav-component />
            </div>
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>

    <footer class="bg-white border-top py-4 mt-auto">
        <div class="container text-center small text-muted">
            &copy; {{ date('Y') }} ShopMI. Portfolio e-commerce project.
        </div>
    </footer>

    <livewire:cart.cart-modal-component />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
    @livewireScripts
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" defer></script>
    <script src="{{ asset('assets/js/main.js') }}" defer></script>
    @stack('scripts')
</body>

</html>

