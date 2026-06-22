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


    public function performSearch()
    {
        if ($this->term) {

            return $this->redirectRoute('search', ['query' => $this->term], navigate: true);
        }
    }


    public function search()
    {
        
        return $this->performSearch();
    }

    public function render()
    {
        $search_results = [];
        $termLength = mb_strlen(trim($this->term), 'UTF-8');

        if ($termLength > 1) {
            $search_results = Product::query()
                ->where('stock', '>', 0)
                ->whereLike('title', '%' . $this->term . '%')
                ->limit(10)
                ->get();
        }

        $popularSuggestions = Product::query()
            ->where('stock', '>', 0)
            ->orderByDesc('is_hit')
            ->orderByDesc('id')
            ->limit(6)
            ->pluck('title')
            ->all();

        return view('livewire.search.search-form-component', [
            'search_results' => $search_results,
            'term_length' => $termLength,
            'popular_suggestions' => $popularSuggestions,
        ]);
    }
}
