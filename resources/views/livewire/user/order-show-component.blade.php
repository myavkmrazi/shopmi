<!-- Товары в заказе -->
<div class="mt-8">
    <h3 class="text-lg font-semibold mb-4">Товары в заказе</h3>

    @if (isset($order->order_products) && count($order->order_products) > 0)
        <div class="border rounded-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-4 text-left">Товар</th>
                        <th class="py-3 px-4 text-left">Цена</th>
                        <th class="py-3 px-4 text-left">Количество</th>
                        <th class="py-3 px-4 text-left">Сумма</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                    @endphp

                    @foreach ($order->order_products as $product)
                        @php
                            $itemPrice = $product['price'] ?? 0;
                            $itemQuantity = $product['quantity'] ?? 1;
                            $itemTotal = $itemPrice * $itemQuantity;
                            $total += $itemTotal;

                            // Получаем изображение товара
                            $image = $product['image'] ?? null;
                            $imageUrl = $image
                                ? (str_starts_with($image, 'http')
                                    ? $image
                                    : asset('storage/' . $image))
                                : 'https://via.placeholder.com/80';
                        @endphp
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <!-- Изображение товара -->
                                    <div class="w-16 h-16 flex-shrink-0 mr-3">
                                        <img src="{{ $imageUrl }}" alt="{{ $product['title'] ?? 'Товар' }}"
                                            class="w-full h-full object-cover rounded border border-gray-200">
                                    </div>

                                    <div>
                                        <!-- Название товара -->
                                        <p class="font-medium text-gray-900">
                                            {{ $product['title'] ?? 'Товар' }}
                                        </p>

                                        <!-- Ссылка на товар -->
                                        @if (isset($product['slug']))
                                            <a href="{{ route('product', $product['slug']) }}"
                                                class="text-blue-600 text-xs hover:text-blue-800 inline-flex items-center mt-1">
                                                <i class="fas fa-external-link-alt mr-1"></i> Перейти к товару
                                            </a>
                                        @endif

                                        <!-- Артикул или ID -->
                                        @if (isset($product['product_id']))
                                            <p class="text-xs text-gray-500 mt-1">
                                                Артикул: #{{ $product['product_id'] }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 align-top">
                                <span class="font-medium">{{ number_format($itemPrice, 0, '', ' ') }} ₽</span>
                            </td>
                            <td class="py-3 px-4 align-top">
                                <span class="font-medium">{{ $itemQuantity }}</span>
                            </td>
                            <td class="py-3 px-4 align-top font-bold">
                                {{ number_format($itemTotal, 0, '', ' ') }} ₽
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="3" class="py-3 px-4 text-right font-bold">Итого:</td>
                        <td class="py-3 px-4 font-bold text-lg">{{ number_format($total, 0, '', ' ') }} ₽</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @elseif(isset($orderProducts) && count($orderProducts) > 0)
        <!-- Альтернативный вариант, если передается $orderProducts -->
        <div class="border rounded-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-4 text-left">Товар</th>
                        <th class="py-3 px-4 text-left">Цена</th>
                        <th class="py-3 px-4 text-left">Количество</th>
                        <th class="py-3 px-4 text-left">Сумма</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                    @endphp

                    @foreach ($orderProducts as $product)
                        @php
                            $itemPrice = $product->price ?? 0;
                            $itemQuantity = $product->quantity ?? 1;
                            $itemTotal = $itemPrice * $itemQuantity;
                            $total += $itemTotal;

                            // Получаем изображение товара
                            $image = $product->image ?? ($product['image'] ?? null);
                            $imageUrl = $image
                                ? (str_starts_with($image, 'http')
                                    ? $image
                                    : asset('storage/' . $image))
                                : 'https://via.placeholder.com/80';
                        @endphp
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <!-- Изображение товара -->
                                    <div class="w-16 h-16 flex-shrink-0 mr-3">
                                        <img src="{{ $imageUrl }}"
                                            alt="{{ $product->title ?? ($product['title'] ?? 'Товар') }}"
                                            class="w-full h-full object-cover rounded border border-gray-200">
                                    </div>

                                    <div>
                                        <!-- Название товара -->
                                        <p class="font-medium text-gray-900">
                                            {{ $product->title ?? ($product['title'] ?? 'Товар') }}
                                        </p>

                                        <!-- Ссылка на товар -->
                                        @if (isset($product->slug) || isset($product['slug']))
                                            <a href="{{ route('product', $product->slug ?? $product['slug']) }}"
                                                class="text-blue-600 text-xs hover:text-blue-800 inline-flex items-center mt-1">
                                                <i class="fas fa-external-link-alt mr-1"></i> Перейти к товару
                                            </a>
                                        @endif

                                        <!-- Артикул или ID -->
                                        @if (isset($product->product_id) || isset($product['product_id']))
                                            <p class="text-xs text-gray-500 mt-1">
                                                Артикул: #{{ $product->product_id ?? $product['product_id'] }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 align-top">
                                <span class="font-medium">{{ number_format($itemPrice, 0, '', ' ') }} ₽</span>
                            </td>
                            <td class="py-3 px-4 align-top">
                                <span class="font-medium">{{ $itemQuantity }}</span>
                            </td>
                            <td class="py-3 px-4 align-top font-bold">
                                {{ number_format($itemTotal, 0, '', ' ') }} ₽
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="3" class="py-3 px-4 text-right font-bold">Итого:</td>
                        <td class="py-3 px-4 font-bold text-lg">{{ number_format($total, 0, '', ' ') }} ₽</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @else
        <p class="text-gray-500">Информация о товарах недоступна</p>
    @endif
</div>
