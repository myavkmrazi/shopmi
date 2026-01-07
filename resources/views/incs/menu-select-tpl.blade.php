<option value="{{ $item['id'] }}" wire:key="{{ $item['id'] }}" {!! $item['parent_id'] == 0 ? 'class="font-weight-bold"' : '' !!}
    @if (isset($this->id) && $item['id'] == $this->id) disabled style="color: #ccc;" @endif>
    {!! $tab . $item['title'] !!}
</option>

@if (isset($item['children']))
    {!! \App\Helpers\Category\Category::getHtml($item['children'], "&nbsp;$tab - ") !!}
@endif
