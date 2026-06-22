<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ $title ?? 'Admin Page Title' }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="{{ asset('assets/admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/libs/toastr/toastr.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.css" rel="stylesheet">
    <link href="{{ asset('assets/admin/main.css') }}" rel="stylesheet">

    <script src="{{ asset('assets/admin/vendor/jquery/jquery.min.js') }}" defer></script>
    <script src="{{ asset('assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('assets/admin/vendor/jquery-easing/jquery.easing.min.js') }}" defer></script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.js" defer></script>
    <script src="{{ asset('assets/admin/js/sb-admin-2.min.js') }}" defer></script>
    <script src="{{ asset('assets/libs/toastr/toastr.min.js') }}" defer></script>
    <script src="{{ asset('assets/admin/main.js') }}" defer></script>

</head>


<body id="page-top">


    <div id="wrapper">

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}"
                target="_blank" rel="noopener">
                <div class="sidebar-brand-text mx-3">SHOPMI</div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item @if (request()->routeIs('admin')) active @endif">
                <a class="nav-link" href="{{ route('admin') }}" wire:navigate>
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="nav-item @if (request()->routeIs('admin.categories.*')) active @endif">
                <a class="nav-link" href="{{ route('admin.categories.index') }}" wire:navigate>
                    <i class="fa-solid fa-bars-staggered"></i>
                    <span>Categories</span></a>
            </li>
            <li class="nav-item @if (request()->routeIs('admin.products.*')) active @endif">
                <a class="nav-link" href="{{ route('admin.products.index') }}" wire:navigate>
                    <i class="fa-solid fa-list"></i>
                    <span>Products</span></a>
            </li>

            <hr class="sidebar-divider">
            <li class="nav-item @if (request()->routeIs('admin.filter-groups.index', 'admin.filter-groups.edit')) active @endif">
                <a class="nav-link" href="{{ route('admin.filter-groups.index') }}" wire:navigate>
                    <i class="fa-solid fa-layer-group"></i>
                    <span>Filter groups</span></a>
            </li>
            <li class="nav-item @if (request()->routeIs('admin.filter-groups.create')) active @endif">
                <a class="nav-link" href="{{ route('admin.filter-groups.create') }}" wire:navigate>
                    <i class="fa-solid fa-plus"></i>
                    <span>Add filter group</span></a>
            </li>
            <li class="nav-item @if (request()->routeIs('admin.filters.index', 'admin.filters.edit')) active @endif">
                <a class="nav-link" href="{{ route('admin.filters.index') }}" wire:navigate>
                    <i class="fa-solid fa-filter"></i>
                    <span>Filters list</span></a>
            </li>
            <li class="nav-item @if (request()->routeIs('admin.filters.create')) active @endif">
                <a class="nav-link" href="{{ route('admin.filters.create') }}" wire:navigate>
                    <i class="fa-solid fa-plus"></i>
                    <span>Add filter</span></a>
            </li>
            <hr class="sidebar-divider">

            <li class="nav-item @if (request()->routeIs('admin.orders.*')) active @endif">
                <a class="nav-link" href="{{ route('admin.orders.index') }}" wire:navigate>
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span>Orders</span></a>
            </li>
            <li class="nav-item @if (request()->routeIs('admin.users.*')) active @endif">
                <a class="nav-link" href="{{ route('admin.users.index') }}" wire:navigate>
                    <i class="fa-solid fa-users"></i>
                    <span>Users</span></a>
            </li>


            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
                                <img class="img-profile rounded-circle"
                                    src="{{ asset('assets/admin/img/undraw_profile.svg') }}">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('home') }}" target="_blank" rel="noopener">
                                    <i class="fas fa-store fa-sm fa-fw mr-2 text-gray-400"></i>
                                    На сайт
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </li>

                    </ul>

                </nav>

                <div class="container-fluid">

                    <h1 class="h3 mb-3 text-gray-800">{{ $title ?? 'Admin page' }}</h1>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    {{ $slot }}

                </div>

            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>ShopMI Admin &copy; {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>

        </div>

    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fa-solid fa-angle-up"></i>
    </a>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-primary" type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
