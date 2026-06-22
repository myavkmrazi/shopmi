<div class="row">

    <div class="col-12 mb-4 position-relative">

        <div class="update-loading" wire:loading>
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a href="{{ route('admin.orders.index') }}" wire:navigate class="btn btn-primary">Order List</a>
            </div>
            <div class="card-header py-3">
                Orders #{{ $order->id }} ({{ $order->statusLabel() }})
            </div>
            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered">
                        <tbody>

                            <tr wire:key="{{ $order->id }}">
                                <th>#</th>
                                <td>{{ $order->id }}</td>
                            </tr>
                            <tr>
                                <th>Customer name</th>
                                <td>{{ $order->name }}</td>
                            </tr>
                            <tr>
                                <th>Customer email</th>
                                <td>{{ $order->email }}</td>
                            </tr>
                            <tr>
                                <th>Customer surname</th>
                                <td>{{ $order->surname }}</td>
                            </tr>
                            <tr>
                                <th>Customer phone</th>
                                <td>{{ $order->phone }}</td>
                            </tr>
                            <tr>
                                <th>Delivery city</th>
                                <td>{{ $order->city }}</td>
                            </tr>
                            <tr>
                                <th>Delivery address</th>
                                <td>{{ $order->address }}</td>
                            </tr>
                            <tr>
                                <th>Payment method</th>
                                <td>{{ ucfirst($order->payment_method) }}</td>
                            </tr>
                            <tr>
                                <th>Customer status</th>
                                <td>
                                    <select class="form-control" wire:model.live="status">
                                        @foreach ($statuses as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td>{{ $order->total }}</td>
                            </tr>
                            <tr>
                                <th>Created</th>
                                <td>{{ $order->created_at }}</td>
                            </tr>
                            </tr>
                            <tr>
                                <th>Updated</th>
                                <td>{{ $order->updated_at }}</td>
                            </tr>
                            <tr>
                                <th>Note</th>
                                <td>{{ $order->note }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    Orders products
                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderProducts as $product)
                                    <tr wire:key="{{ $product->id }}">
                                        <td><img src="{{ asset($product->image) }}" height="50" alt=""></td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->quantity }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4" class="text-right font-weight-bold">
                                        Total: ${{ $order->total }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
