<?php

namespace App\Livewire\Product;

use App\Models\Product;
use App\Models\FilterGroup;
use Livewire\Component;
use App\Helpers\Cart\Cart;
use App\Helpers\Traits\CartTrait;
use App\Helpers\Traits\WishlistTrait;

class ProductComponent extends Component
{
    use CartTrait, WishlistTrait;
    public string $slug = '';
    public $product;
    public $productAttributes = [];
    public int $quantity = 1;

    //add event listener
    protected $listeners = ['cartUpdated' => '$refresh'];

    public function mount($slug)
    {
        $this->slug = $slug;

        $this->product = Product::with(['category.parent'])
            ->where('slug', $this->slug)
            ->firstOrFail();


        $this->loadAttributes();
    }

    public function incrementQuantity()
    {
        $max = Cart::maxAllowedQuantity($this->product);

        if ($this->quantity < $max) {
            $this->quantity++;
        }
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }


    public function addCart($productId)
    {
        $this->add2Cart($productId, $this->quantity);

        $this->dispatch('cart-updated');


        $this->dispatch('show-alert', [
            'type' => 'success',
            'message' => 'Товар добавлен в корзину!'
        ]);


        $this->reset('quantity');
    }

    public function loadAttributes()
    {
        $this->productAttributes = FilterGroup::query()
            ->selectRaw('filter_groups.title as filter_groups_title, GROUP_CONCAT(filters.title SEPARATOR ", ") as filters_title')
            ->join('filters', 'filters.filter_group_id', '=', 'filter_groups.id')
            ->join('filter_products', 'filter_products.filter_id', '=', 'filters.id')
            ->where('filter_products.product_id', '=', $this->product->id)
            ->groupBy('filter_groups.title')
            ->get()
            ->toArray();
    }

    public function render()
    {
        $related_product = Product::query()
            ->where('category_id', '=', $this->product->category_id)
            ->where('id', '!=', $this->product->id)
            ->limit(8)
            ->get();

        return view('livewire.product.product-component', [
            'related_product' => $related_product,
            'productAttributes' => $this->productAttributes,
            'quantity' => $this->quantity 
        ]);
    }
}
