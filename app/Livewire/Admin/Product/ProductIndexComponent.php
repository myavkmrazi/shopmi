<?php

namespace App\Livewire\Admin\Product;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Storage;

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
                $this->deleteUploadFile($image);
            }
            if (! empty($gallery)) {
                foreach ((array) $gallery as $galleryPath) {
                    if (is_string($galleryPath)) {
                        $this->deleteUploadFile($galleryPath);
                    }
                }
            }

            $this->js("toastr.success('Product removed')");

            return;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->js("toastr.error('Error deleting product')");
        }
    }

    private function deleteUploadFile(string $path): void
    {
        $relativePath = str_starts_with($path, 'uploads/') ? substr($path, 8) : $path;
        Storage::disk('public_uploads')->delete($relativePath);
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
