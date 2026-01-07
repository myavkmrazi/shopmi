<?php

namespace App\Livewire\Search;

use Livewire\Component;
use Livewire\WithPagination;
use App\Helpers\Traits\CartTrait;
use App\Models\Product; // Добавьте этот импорт

class SearchComponent extends Component
{
    use WithPagination, CartTrait;

    public $query;

    public function mount()
    {
        $this->query = request()->query('query') ?? '';
    }

    public function render()
    {
        $products = []; // Исправлено: $product → $products (мн. число)

        if ($this->query) {
            $products = Product::query() // Теперь Product доступен
                ->whereLike('title', '%' . $this->query . '%') // Исправлено: $this->term → $this->query
                ->paginate(4);
        }

        return view('livewire.search.search-component', [
            'products' => $products,
        ]);
    }
}
