<div class="row">

    <div class="col-12 mb-4 position-relative">
        <div class="col-12 mb-4 position-relative">
            <div class="update-loading" wire:loading wire:target="save">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <a href="{{ route('admin.filter-groups.create') }}" wire:navigate class="btn btn-primary">Add Filter
                        Groups</a>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">ID</th>
                                    <th>Title</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($filter_groups as $filter_group)
                                    <tr wire:key="{{ $filter_group->id }}">
                                        <td>{{ $filter_group->id }}</td>
                                        <td>{{ $filter_group->title }}</td>
                                        <td>
                                            <a href="{{ route('admin.filter-groups.edit', $filter_group->id) }}"
                                                class="btn btn-warning btn-circle" wire:navigate>
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            <button class="btn btn-danger btn-circle"
                                                wire:click="deleteFilterGroup({{ $filter_group->id }})"
                                                wire:confirm="Are you sure?" wire:loading.attr="disabled">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>

    </div>
