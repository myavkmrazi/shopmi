<div class="row">

    <div class="col-12 mb-4">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a href="{{ route('admin.categories.index') }}" wire:navigate class="btn btn-primary">Categories List</a>
            </div>
            <div class="card-body">

                <form wire:submit="save">

                    <div class="mb-3">
                        <label for="title" class="form-label required">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            placeholder="Category title" wire:model="title">
                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="parent_id" class="form-label required">Parent category</label>
                        <select wire:model="parent_id" id="parent_id"
                            class="custom-select @error('parent_id') is-invalid @enderror">
                            <option value="0" wire:key="0">Root category</option>
                            {!! \App\Helpers\Category\Category::getMenu('incs.menu-select-tpl') !!}
                        </select>
                        @error('parent_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <div class="card">
                            <div class="card-header">Filters</div>
                            <div class="card-body">
                                @foreach ($filter_groups as $filter_group)
                                    <div wire:key="{{ $filter_group->id }}" class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{ $filter_group->id }}"
                                            id="filter-{{ $filter_group->id }}" wire:model="selectedCategoryFilters">
                                        <label class="form-check-label" for="filter-{{ $filter_group->id }}">
                                            {{ $filter_group->title }}
                                        </label>
                                    </div>
                                @endforeach
                                @error('selectedCategoryFilters.*')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-info">
                            Save
                            <div wire:loading wire:target="save" class="spinner-grow spinner-grow-sm" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

</div>
