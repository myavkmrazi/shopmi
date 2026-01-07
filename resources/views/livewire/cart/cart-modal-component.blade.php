<div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart" aria-labelledby="offcanvasCartLabel"
        wire:ignore.self style="width: 450px;">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasCartLabel">
                <i class="fas fa-shopping-cart me-2"></i>Ваша корзина
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-3">
            @php
                // ЗАРАНЕЕ получаем список существующих картинок
                $availableImages = [
                    '1.jpg',
                    '2.jpeg',
                    '3.jpg',
                    '4.jpg',
                    '5.jpg',
                    '6.jpg',
                    '7.jpg',
                    '8.jpg',
                    '9.jpg',
                    '10.jpg',
                    '11.jpg',
                    '12.jpg',
                    '13.jpg',
                    '14.jpg',
                    '15.jpg',
                    '16.jpg',
                    '17.jpg',
                    '18.jpg',
                    '19.jpg',
                    '20.jpg',
                    '21.jpg',
                    '22.jpg',
                    '23.jpg',
                    '24.jpg',
                    '25.jpg',
                    '26.jpg',
                    '27.jpg',
                    '28.jpg',
                    '29.jpg',
                    '30.jpg',
                    '31.jpg',
                    '32.jpg',
                    '33.jpg',
                    '34.jpg',
                    '35.jpg',
                    '36.jpg',
                    '37.jpg',
                    '38.jpg',
                    '39.jpg',
                    '40.jpg',
                    '41.jpg',
                    '42.jpg',
                    '43.jpg',
                    '44.jpg',
                    '45.jpg',
                ];
                $existingImages = [];

                foreach ($availableImages as $img) {
                    if (file_exists(public_path('img/products/' . $img))) {
                        $existingImages[] = $img;
                    }
                }

                if (empty($existingImages)) {
                    $existingImages = ['2.jpeg'];
                }
            @endphp

            @if (!empty($cartItems))
                <div class="cart-items">
                    @foreach ($cartItems as $id => $item)
                        @php
                            $imageIndex = $id % count($existingImages);
                            $productImage = $existingImages[$imageIndex];
                        @endphp

                        <div class="cart-item mb-3 p-3 border rounded" wire:key="{{ $id }}">
                            <div class="d-flex align-items-start">
                                {{-- Картинка --}}
                                <a href="/product/{{ $item['slug'] ?? $id }}" class="shrink-0">
                                    <img src="{{ asset('img/products/' . $productImage) }}"
                                        alt="{{ $item['title'] ?? 'Товар' }}"
                                        style="width: 80px; height: 80px; object-fit: cover;" class="rounded"
                                        onerror="this.src='{{ asset('img/products/2.jpeg') }}'">
                                </a>

                                <div class="grow">
                                    <a href="{{ route('product', $item['slug']) }}"
                                        class="text-decoration-none text-dark">
                                        <h6 class="mb-2 fw-bold">{{ $item['title'] ?? 'Без названия' }}</h6>
                                    </a>
                                    <p class="mb-2 text-muted small">{{ $item['except'] ?? '' }}</p>

                                    <p class="mb-2 text-muted small">
                                        ${{ number_format($item['price'] ?? 0, 2) }} × {{ $item['quantity'] ?? 1 }}
                                    </p>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="quantity-controls d-flex align-items-center">
                                            {{-- Кнопка уменьшить --}}
                                            <button class="btn btn-sm btn-outline-secondary"
                                                wire:click="decrementQuantity('{{ $id }}')"
                                                {{ ($item['quantity'] ?? 1) <= 1 ? 'disabled' : '' }}
                                                wire:loading.attr="disabled" wire:target="decrementQuantity">
                                                <i class="fas fa-minus"></i>
                                            </button>

                                            {{-- Количество --}}
                                            <span class="mx-2 fw-bold">{{ $item['quantity'] ?? 1 }}</span>

                                            {{-- Кнопка увеличить --}}
                                            <button class="btn btn-sm btn-outline-secondary"
                                                wire:click="incrementQuantity('{{ $id }}')"
                                                wire:loading.attr="disabled" wire:target="incrementQuantity">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>

                                        <div class="d-flex align-items-center">
                                            <span class="fw-bold text-primary me-3 fs-6">
                                                ${{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 2) }}
                                            </span>
                                            <button class="btn btn-sm btn-outline-danger"
                                                wire:click="removeFromCart('{{ $id }}')"
                                                wire:loading.attr="disabled" wire:target="removeFromCart">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- ИТОГО --}}
                    <div class="cart-total mt-4 pt-3 border-top">
                        @php
                            // В Blade нельзя использовать "use", поэтому вычисляем вручную
                            $totalQuantity = 0;
                            $totalPrice = 0;

                            foreach ($cartItems as $item) {
                                $totalQuantity += $item['quantity'] ?? 1;
                                $totalPrice += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
                            }
                        @endphp

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Товары ({{ $totalQuantity }})</span>
                            <span>${{ number_format($totalPrice, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Доставка</span>
                            <span>Бесплатно</span>
                        </div>
                        <div class="d-flex justify-content-between fw-bold fs-5 mt-2 pt-2 border-top">
                            <span>Итого:</span>
                            <span class="text-primary">${{ number_format($totalPrice, 2) }}</span>
                        </div>
                        <button onclick="window.location.href='{{ route('cart') }}'"
                            class="btn btn-primary w-100 mt-3 py-2 fw-bold">
                            <i class="fas fa-credit-card me-2"></i>Оформить заказ
                        </button>
                        <button class="btn btn-outline-secondary w-100 mt-2" data-bs-dismiss="offcanvas">
                            Продолжить покупки
                        </button>
                    </div>
                </div>
            @else
                <div class="cart-empty text-center py-5">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-1">Ваша корзина пуста</p>
                    <p class="small text-muted">Добавьте товары из каталога</p>
                    <button class="btn btn-primary mt-3" data-bs-dismiss="offcanvas">
                        Начать покупки
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
