<?php

namespace App\Livewire\Search;

use App\Models\Product;
use Livewire\Component;

class SearchFormComponent extends Component
{
    public string $term = '';

    public function clearSearch()
    {
        $this->term = '';
    }

    // Этот метод вызывается кнопкой лупы и Enter
    public function performSearch()
    {
        if ($this->term) {
            // Редирект на страницу поиска
            return $this->redirectRoute('search', ['query' => $this->term], navigate: true);
        }
    }

    // Устаревший метод, можно удалить или оставить для совместимости
    public function search()
    {
        // Просто вызываем performSearch
        return $this->performSearch();
    }

    public function render()
    {
        $search_results = [];

        if (mb_strlen($this->term, 'UTF-8') > 1) {
            $search_results = Product::query()
                ->whereLike('title', '%' . $this->term . '%')
                ->limit(10)
                ->get();
        }

        return view('livewire.search.search-form-component', [
            'search_results' => $search_results,
        ]);
    }
}
