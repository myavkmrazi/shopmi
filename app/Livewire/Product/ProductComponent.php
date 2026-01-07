<?php

namespace App\Livewire\Product;

use App\Models\Product;
use App\Models\FilterGroup;
use Livewire\Component;
use App\Helpers\Traits\CartTrait;

class ProductComponent extends Component
{
    use CartTrait;
    public string $slug = '';
    public $product;
    public $productAttributes = [];
    public int $quantity = 1; // ДОБАВЬТЕ ЭТУ СТРОКУ!

    //add event listener
    protected $listeners = ['cartUpdated' => '$refresh'];

    public function mount($slug)
    {
        $this->slug = $slug;
        // upload product in mount
        $this->product = Product::with(['category.parent'])
            ->where('slug', $this->slug)
            ->firstOrFail();

        //upload product attribute
        $this->loadAttributes();
    }

    public function incrementQuantity()
    {
        $this->quantity++;
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    //overriding the add to cart method
    public function addCart($productId)
    {
        $this->add2Cart($productId, $this->quantity);
        //sending an update to the trash method
        $this->dispatch('cart-updated');

        // Optional:Show a notification
        $this->dispatch('show-alert', [
            'type' => 'success',
            'message' => 'Товар добавлен в корзину!'
        ]);

        // Сбросить количество после добавления (опционально)
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
            ->where('category_id', '=', $this->product->category_id) // Товары из той же категории
            ->where('id', '!=', $this->product->id) //exclude the current product
            ->limit(8) // Limit to 8 items
            ->get();

        return view('livewire.product.product-component', [
            'related_product' => $related_product,
            'productAttributes' => $this->productAttributes,
            'quantity' => $this->quantity // Передаем в шаблон
        ]);
    }
}
