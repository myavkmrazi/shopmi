<?php

namespace App\Livewire\Admin\Product;

use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

#[Layout('components.layouts.admin')]
#[Title('Products')]
class ProductIndexComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function deleteProduct(Product $product)
    {
        try {
            $image = $product->image;
            $gallery = $product->gallery;
            DB::beginTransaction();
            DB::table('filter_products')
                ->where('product_id', '=', $product->id)
                ->delete();

            $product->delete();
            DB::commit();
            if ($image) {
                Storage::disk('public_uploads_delete')->delete($image);
            }
            if ($gallery) {
                Storage::disk('public_uploads_delete')->delete($gallery);
            }
            $this->js("toastr.success('Product removed')");
            return;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->js("toastr.error('Error deleting product')");
        }
        Storage::disk('public_uploads_delete')->delete('uploads/test.txt');
        dump($product);
    }
    public function render()
    {
        $products = Product::query()
            ->with('category')
            ->orderBy('id', 'desc')
            ->paginate();
        return view('livewire.admin.product.product-index-component', compact('products'));
    }
}
