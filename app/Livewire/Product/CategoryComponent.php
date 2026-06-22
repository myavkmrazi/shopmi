<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
use App\Models\Product;
use App\Helpers\Traits\CartTrait;
use App\Helpers\Traits\WishlistTrait;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\DB;

class CategoryComponent extends Component
{
    use WithPagination, CartTrait, WishlistTrait;

    public $slug;
    public $category;
    public string $categoryTitle = '';
    #[Url] public $minPrice = '';
    #[Url] public $maxPrice = '';
    #[Url(except: false)] public bool $inStock = false;

    #[Url] public string $sort = 'default';
    #[Url] public array $selected_filters = [];
    #[Url] public int $limit = 6;

    protected $listeners = ['gotoPage'];

    public array $sortList = [
        'default' => ['title' => 'Default', 'order_field' => 'id', 'order_direction' => 'desc'],
        'name-asc' => ['title' => 'Name (a-z)', 'order_field' => 'title', 'order_direction' => 'asc'],
        'name-desc' => ['title' => 'Name (z-a)', 'order_field' => 'title', 'order_direction' => 'desc'],
        'price-asc' => ['title' => 'Price (low > high)', 'order_field' => 'price', 'order_direction' => 'asc'],
        'price-desc' => ['title' => 'Price (high > low)', 'order_field' => 'price', 'order_direction' => 'desc'],
    ];

    public array $limitList = [6, 9, 12];

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->loadCategory();

        if (!isset($this->sortList[$this->sort])) {
            $this->sort = 'default';
        }

        if (!in_array($this->limit, $this->limitList)) {
            $this->limit = 6;
        }
    }
    public function updatedPage($page)
    {

        if (!$this->category) {
            return;
        }

        $page_title = $page > 1 ? " :: Страница {$page}" : "";
        $title = config('app.name') . " :: Категория {$this->category->title}{$page_title}";

        $this->dispatch('page-updated', title: $title);
    }

    public function loadCategory()
    {
        $this->category = Category::with([
            'children' => function ($query) {
                $query->withCount('products');
            }
        ])->where('slug', $this->slug)->firstOrFail();
    }

    public function getProductsProperty()
    {
        if (!$this->category) {
            return collect()->paginate(6);
        }


        $categoryIds = [$this->category->id];
        if ($this->category->children && $this->category->children->count() > 0) {
            foreach ($this->category->children as $child) {
                $categoryIds[] = $child->id;
            }
        }

        $query = Product::whereIn('category_id', $categoryIds);


        if ($this->minPrice !== '' && is_numeric($this->minPrice)) {
            $query->where('price', '>=', (float) $this->minPrice);
        }
        if ($this->maxPrice !== '' && is_numeric($this->maxPrice)) {
            $query->where('price', '<=', (float) $this->maxPrice);
        }

        if ($this->inStock) {
            $query->where('stock', '>', 0);
        }

        if (!empty($this->selected_filters)) {
            $filterIds = array_map('intval', $this->selected_filters);
            $query->whereHas('filters', function ($q) use ($filterIds) {
                $q->whereIn('filters.id', $filterIds);
            });
        }


        $sortKey = $this->sort;
        if (!isset($this->sortList[$sortKey])) {
            $sortKey = 'default';
        }

        $query->orderBy(
            $this->sortList[$sortKey]['order_field'],
            $this->sortList[$sortKey]['order_direction']
        );

        return $query->paginate($this->limit);
    }

    public function resetFilters(): void
    {
        $this->minPrice = '';
        $this->maxPrice = '';
        $this->inStock = false;
        $this->selected_filters = [];
        $this->sort = 'default';
        $this->resetPage();
    }

    public function updated($property): void
    {
        if (in_array($property, ['sort', 'limit', 'minPrice', 'maxPrice', 'inStock', 'selected_filters'], true)) {
            $this->resetPage();
        }
    }

    public function gotoPage($page)
    {
        $this->setPage($page);
        $this->dispatch('page-changed');
    }

    public function render()
    {

        if (!$this->category) {
            return view('livewire.product.category-component', [
                'category' => null,
                'products' => collect()->paginate(6),
                'category_filters' => collect(),
            ]);
        }

        $categoryId = $this->category->id;

        $category_filters = DB::table('filters')
            ->select(
                'filters.id as filter_id',
                'filters.title as filter',
                'filter_groups.title as group_title',
                'filter_groups.id as filter_group_id'
            )
            ->join('filter_groups', 'filters.filter_group_id', '=', 'filter_groups.id')
            ->join('category_filters', 'filter_groups.id', '=', 'category_filters.filter_group_id')
            ->where('category_filters.category_id', $categoryId)
            ->get();


        $page = request()->query('page', 1);
        $products = $this->products;

        if ($page > $products->lastPage() && $products->lastPage() > 0) {
            abort(404);
        }


        $title = "Категория: {$this->category->title}" . ($page ? ":: Page - {$page}" : '');

        return view('livewire.product.category-component', [
            'category' => $this->category,
            'products' => $products,
            'category_filters' => $category_filters,
            'title' => $title,
        ])->title($title);
    }
}
