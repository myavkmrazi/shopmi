<?php

namespace App\Livewire\Search;

use Livewire\Component;
use Livewire\WithPagination;
use App\Helpers\Traits\CartTrait;
use App\Helpers\Traits\WishlistTrait;
use App\Models\Product;

class SearchComponent extends Component
{
    use WithPagination, CartTrait, WishlistTrait;

    public $query;

    public function mount()
    {
        $this->query = request()->query('query') ?? '';
    }

    public function updatedQuery(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = collect();

        if ($this->query) {
            $products = Product::query()
                ->where('stock', '>', 0)
                ->whereLike('title', '%' . $this->query . '%')
                ->paginate(12);
        }

        return view('livewire.search.search-component', [
            'products' => $products,
        ]);
    }
}
