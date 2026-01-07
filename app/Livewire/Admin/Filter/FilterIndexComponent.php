<?php

namespace App\Livewire\Admin\Filter;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\Filter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
#[Layout('components.layouts.admin')]
#[Title('Filters')]
class FilterIndexComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public function deleteFilter(Filter $filter)
    {
        try {
            DB::beginTransaction();
            DB::table('filter_products')
                ->where('filter_id', '=', $filter->id)
                ->delete();
            $filter->delete();
            DB::commit();
            $this->js("toastr.success('Filter removed')");
            return;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->js("toastr.error('Error deleting filter')");
        }

    }
    public function render()
    {
        $filters = Filter::query()->with('group')->paginate();
        return view('livewire.admin.filter.filter-index-component', compact('filters'));
    }
}
