<?php

namespace App\Livewire\Admin\Filter;

use App\Models\FilterGroup;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Create Filter Group')]
class FilterGroupEditComponent extends Component
{
    public FilterGroup $filter_group;

    public string $title;

    public function mount(FilterGroup $filter_group)
    {
        $this->filterGroup = $filter_group;
        $this->title = $filter_group->title;
    }

    public function save()
    {
        $validated = $this->validate([
            'title' => 'required|max:255',
        ]);

        $this->filter_group->update($validated);

        session()->flash('success', 'Filter group updated successfully');
        $this->redirectRoute('admin.filter-groups.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.filter.filter-group-edit-component');
    }
}
