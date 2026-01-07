<?php

namespace App\Livewire\Admin\Filter;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\FilterGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class FilterGroupIndexComponent extends Component
{

    #[Layout('components.layouts.admin')]
    #[Title('Filter Groups')]

    public function deleteFilterGroup(FilterGroup $filter_group)
    {
        try {
            $title = $filter_group->title;
            DB::beginTransaction();


            $filter_group->delete();
            DB::commit();
            $this->js("toastr.success('Filter Group removed')");
            return;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->js("toastr.error('Error deleting filter group')");
        }

    }
    public function render()
    {
        $filter_groups = FilterGroup::all();
        return view('livewire.admin.filter.filter-group-index-component', compact('filter_groups'));
    }
}
