{{-- resources/views/incs/menu-tpl.blade.php --}}
<li class="nav-item @if (!empty($item['children'])) dropend @endif">
    @if (!empty($item['children']))
        <a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">
            {{ $item['title'] }}
        </a>
        <ul class="dropdown-menu">
            {!! \App\Helpers\Category\Category::getHtml($item['children']) !!}
        </ul>
    @else
        <a class="dropdown-item" wire:navigate href="{{ route('category', $item['slug']) }}">
            {{ $item['title'] }}
        </a>
    @endif
</li>
