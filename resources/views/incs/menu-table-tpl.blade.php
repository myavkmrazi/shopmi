<tr wire:key="{{ $item['id'] }}">
    <td>{{ $item['id'] }}</td>
    <td><span style="padding-left: {{ strlen($tab) * 3 }}px;">{{ $tab . $item['title'] }}</span></td>
    <td>
        <a href="{{ route('category', $item['slug']) }}" target="_blank" class="btn btn-info btn-circle">
            <i class="fa-solid fa-eye"></i>
        </a>
        <a href="{{ route('admin.categories.edit', $item['id']) }}" class="btn btn-warning btn-circle" wire:navigate>
            <i class="fa-solid fa-pencil"></i>
        </a>
        <button class="btn btn-danger btn-circle" wire:click="deleteCategory({{ $item['id'] }})"
            wire:confirm="Are you sure?" wire:loading.attr="disabled">
            <i class="fa-solid fa-trash"></i>
        </button>
    </td>
</tr>
@if (isset($item['children']))
    {!! \App\Helpers\Category\Category::getHtml($item['children'], "$tab - ") !!}
@endif
