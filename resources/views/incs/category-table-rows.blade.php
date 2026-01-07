<tr wire:key="{{ $item['id'] }}">
    <td width="60" class="text-center font-weight-bold">{{ $item['id'] }}</td>
    <td>
        <div class="d-flex align-items-center">
            <div class="icon-circle bg-primary mr-3">
                <i class="fas fa-folder text-white"></i>
            </div>
            <div>
                <div class="font-weight-bold">{{ $tab }}{{ $item['title'] ?? $item['name'] }}</div>
                <div class="text-muted small">{{ $item['slug'] ?? '' }}</div>
            </div>
        </div>
    </td>
    <td width="100" class="text-center">
        <span class="badge badge-primary badge-pill px-3 py-1">
            {{ $item['products_count'] ?? 0 }}
        </span>
    </td>
</tr>
@if (isset($item['children']))
    {!! \App\Helpers\Category\Category::getHtml($item['children'], "$tab - ") !!}
@endif
