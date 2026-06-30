{{-- resources/views/incs/menu-tpl.blade.php --}}
<li @class([
    'dropdown' => !empty($item['children']),
    'dropend' => !empty($item['children']),
])>
    @if (!empty($item['children']))
        <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
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
