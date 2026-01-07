<?php

namespace App\Livewire\Admin\Product;

use App\Models\Filter;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.admin')]
#[Title('Create Product')]
class ProductCreateComponent extends Component
{
    use WithFileUploads;

    public string $title;
    public $category_id;
    public array $selectedFilters = [];
    public int $price = 0;
    public int $old_price = 0;
    public bool $is_hit = false;
    public bool $is_new = false;
    public string $excerpt;
    public string $content;
    #[Validate]
    public $image;
    #[Validate]
    public $galery;

    public function updatedCategoryId()
    {
        $this->selectedFilters = [];
    }

    #[Computed]
    public function filters()
    {
        $filter_groups = [];
        if ($this->category_id) {
            $ids = \App\Helpers\Category\Category::getIds($this->category_id) . $this->category_id;
            $category_filters = DB::table('category_filters')
                ->select('category_filters.filter_group_id', 'filter_groups.title', 'filters.id as filter_id', 'filters.title as filter_title')
                ->join('filter_groups', 'category_filters.filter_group_id', '=', 'filter_groups.id')
                ->join('filters', 'filters.filter_group_id', '=', 'filter_groups.id')
                ->whereIn('category_filters.category_id', explode(',', $ids))
                ->get();

            foreach ($category_filters as $filter) {
                $filter_groups[$filter->filter_group_id][] = $filter;
            }
        }
        return $filter_groups;
    }

    protected function rules()
    {
        return [
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'selectedFilters.*' => 'numeric',
            'price' => 'required|integer',
            'old_price' => 'integer',
            'is_hit' => 'boolean',
            'is_new' => 'boolean',
            'excerpt' => 'nullable|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'galery.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // ← ИЗМЕНЕНО: gallery.* -> galery.*
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        $folders = date('Y') . '/' . date('m') . '/' . date('d'); // 2025/04/27
        if ($validated['image']) {
            $validated['image'] = "uploads/" . $validated['image']->store($folders);
        }
        if (!empty($validated['galery'])) { // ← ИЗМЕНЕНО: gallery -> galery
            foreach ($validated['galery'] as $k => $photo) { // ← ИЗМЕНЕНО: gallery -> galery
                $validated['galery'][$k] = "uploads/" . $photo->store($folders); // ← ИЗМЕНЕНО: gallery -> galery
            }
        }

        try {
            DB::beginTransaction();

            $product = Product::query()->create($validated);

            if (!empty($validated['selectedFilters'])) {
                $filter_groups = Filter::query()
                    ->whereIn('id', $validated['selectedFilters'])->get();
                $data = [];
                foreach ($filter_groups as $filter_group) {
                    $data[] = [
                        'filter_id' => $filter_group->id,
                        'product_id' => $product->id,
                        'filter_group_id' => $filter_group->filter_group_id,
                    ];
                }
                DB::table('filter_products')->insert($data);
            }

            DB::commit();
            session()->flash('success', 'Product created successfully');
            $this->redirectRoute('admin.products.index', navigate: true);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->js("toastr.error('Error saving product')");
        }

    }

    public function render()
    {
        return view('livewire.admin.product.product-create-component');
    }
}
