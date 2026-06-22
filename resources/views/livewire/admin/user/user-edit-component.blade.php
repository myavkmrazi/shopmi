<div class="row">

    <div class="col-12 mb-4 position-relative">

        <div class="update-loading" wire:loading wire:target="save">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a href="{{ route('admin.users.index') }}" wire:navigate class="btn btn-primary">Users List</a>
            </div>
            <div class="card-body">

                <form wire:submit="save">

                    <div class="mb-3">
                        <label for="name" class="form-label required">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            placeholder="Name" wire:model="name">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="surname" class="form-label required">Surname</label>
                        <input type="text" class="form-control @error('surname') is-invalid @enderror" id="surname"
                            placeholder="Surname" wire:model="surname">
                        @error('surname')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label required">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            placeholder="Email" wire:model="email">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label required">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" placeholder="Password" wire:model="password">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    @if (auth()->id() != $user->id)
                        <div class="mb-3">
                            Is Admin?
                            <label class="switch">
                                <input type="checkbox" wire:model="is_admin">
                                <span class="slider round"></span>
                            </label>
                        </div>
                    @endif

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

        @if ($user_orders->isNotEmpty())
            <div class="card shadow mb-4 position-relative">

                <div class="update-loading" wire:loading wire:target="save">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>

                <div class="card-header py-3">
                    User orders
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">ID</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user_orders as $order)
                                    <tr wire:key="{{ $order->id }}">
                                        <td>${{ $order->id }}</td>
                                        <td>{{ $order->statusLabel() }}</td>
                                        <td>${{ $order->total }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>{{ $order->updated_at }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.edit', $order->id) }}" wire:navigate
                                                class="btn btn-warning btn-circle"><i class="fa-solid fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $user_orders->links(data: ['scrollTo' => false]) }}

                </div>
            </div>
        @endif

    </div>

</div>
