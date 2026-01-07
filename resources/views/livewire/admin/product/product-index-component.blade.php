<div class="row">

    <div class="col-12 mb-4 position-relative">

        <div class="update-loading" wire:loading wire:target.except="deleteProduct">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a href="{{ route('admin.products.create') }}" wire:navigate class="btn btn-primary">Add Product</a>
            </div>
            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10%;">ID</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr wire:key="{{ $product->id }}">
                                    <td>{{ $product->id }}</td>
                                    <td><img src="{{ asset($product->getImage()) }}" alt="" height="50"></td>
                                    <td>{{ $product->title }}</td>
                                    <td>{{ $product->category->title }}</td>
                                    <td>
                                        <a href="{{ route('product', $product->slug) }}" target="_blank"
                                            class="btn btn-info btn-circle">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                            class="btn btn-warning btn-circle" wire:navigate>
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <button class="btn btn-danger btn-circle"
                                            wire:click="deleteProduct({{ $product->id }})" wire:confirm="Are you sure?"
                                            wire:loading.attr="disabled">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                {{ $products->links() }}

            </div>
        </div>

    </div>

</div>
