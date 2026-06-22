<div class="shopmi-search">
    <input
        type="text"
        class="shopmi-search__input"
        wire:model.live.debounce.500ms="term"
        wire:keydown.enter="performSearch"
        placeholder="ПОИСК"
        aria-label="Поиск товаров"
        autocomplete="off"
    >

    @if ($term)
        <span class="shopmi-search__clear" wire:click="clearSearch" title="Очистить поиск">
            <i class="fa-solid fa-xmark"></i>
        </span>
    @endif
</div>
