<?php

namespace App\Livewire\Admin\Filter;

use App\Models\Filter;
use App\Models\FilterGroup;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Edit Filter')]
class FilterEditComponent extends Component
{
    public Filter $filter;

    public string $title;

    public $filter_group_id;

    public function mount(Filter $filter)
    {
        $this->filter = $filter;
        $this->title = $filter->title;
        $this->filter_group_id = $filter->filter_group_id;
    }

    public function save()
    {
        $validated = $this->validate([
            'title' => 'required|max:255',
            'filter_group_id' => 'required|exists:filter_groups,id',
        ]);

        $this->filter->update($validated);

        session()->flash('success', 'Filter updated successfully');
        $this->redirectRoute('admin.filters.index', navigate: true);
    }

    public function render()
    {
        $filter_groups = FilterGroup::all();

        return view('livewire.admin.filter.filter-edit-component', compact('filter_groups'));
    }
}
