<div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart" aria-labelledby="offcanvasCartLabel"
        wire:ignore.self style="width: 450px;">

        <div class="offcanvas-header border-bottom" style="border-color: #e5e5e5 !important; padding: 1.5rem;">
            <h5 class="offcanvas-title" id="offcanvasCartLabel"
                style="font-family: 'Oswald', sans-serif; font-size: 28px; letter-spacing: 2px; margin: 0;">
                <i class="fas fa-shopping-cart me-2" style="color: #0f0f10;"></i>ВАША КОРЗИНА
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"
                style="opacity: 1; filter: brightness(0);"></button>
        </div>

        <div class="offcanvas-body p-0" style="background: #fff;">
            @php
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
                <div class="cart-items" style="padding: 1.5rem;">
                    @foreach ($cartItems as $id => $item)
                        @php
                            $imageIndex = $id % count($existingImages);
                            $productImage = $existingImages[$imageIndex];
                        @endphp

                        <div class="cart-item mb-4" wire:key="{{ $id }}"
                            style="border-bottom: 1px solid #e5e5e5; padding-bottom: 1.5rem;">
                            <div class="d-flex gap-3">
                                <a href="/product/{{ $item['slug'] ?? $id }}" class="flex-shrink-0">
                                    <img src="{{ asset('img/products/' . $productImage) }}"
                                        alt="{{ $item['title'] ?? 'Товар' }}"
                                        style="width: 100px; height: 120px; object-fit: cover; border: 1px solid #e5e5e5;"
                                        onerror="this.src='{{ asset('img/products/2.jpeg') }}'">
                                </a>

                                <div class="flex-grow-1">
                                    <a href="{{ route('product', $item['slug']) }}"
                                        class="text-decoration-none text-dark d-block mb-2">
                                        <h6
                                            style="font-family: 'Oswald', sans-serif; font-size: 18px; letter-spacing: 1px; margin: 0; line-height: 1.3;">
                                            {{ $item['title'] ?? 'Без названия' }}
                                        </h6>
                                    </a>

                                    @if (!empty($item['except']))
                                        <p
                                            style="font-size: 12px; color: #777; letter-spacing: 0.5px; margin-bottom: 0.5rem; text-transform: uppercase;">
                                            {{ $item['except'] }}
                                        </p>
                                    @endif

                                    <p
                                        style="font-size: 14px; color: #0f0f10; font-weight: 600; margin-bottom: 0.75rem;">
                                        ${{ number_format($item['price'] ?? 0, 2) }}
                                    </p>

                                    <div class="d-flex justify-content-between align-items-end">
                                        <div class="quantity-controls d-flex align-items-center"
                                            style="border: 1px solid #e5e5e5;">
                                            <button class="btn btn-sm"
                                                wire:click="decrementQuantity('{{ $id }}')"
                                                {{ ($item['quantity'] ?? 1) <= 1 ? 'disabled' : '' }}
                                                wire:loading.attr="disabled" wire:target="decrementQuantity"
                                                style="border: none; border-radius: 0; padding: 0.4rem 0.8rem; background: transparent; color: #0f0f10; {{ ($item['quantity'] ?? 1) <= 1 ? 'opacity: 0.3;' : '' }}">
                                                <i class="fas fa-minus" style="font-size: 12px;"></i>
                                            </button>

                                            <span
                                                style="padding: 0.4rem 0.8rem; border-left: 1px solid #e5e5e5; border-right: 1px solid #e5e5e5; font-family: 'Oswald', sans-serif; font-size: 16px; letter-spacing: 1px;">
                                                {{ $item['quantity'] ?? 1 }}
                                            </span>

                                            <button class="btn btn-sm"
                                                wire:click="incrementQuantity('{{ $id }}')"
                                                wire:loading.attr="disabled" wire:target="incrementQuantity"
                                                style="border: none; border-radius: 0; padding: 0.4rem 0.8rem; background: transparent; color: #0f0f10;">
                                                <i class="fas fa-plus" style="font-size: 12px;"></i>
                                            </button>
                                        </div>

                                        <div class="d-flex align-items-center gap-2">
                                            <span
                                                style="font-family: 'Oswald', sans-serif; font-size: 20px; letter-spacing: 1px; color: #0f0f10;">
                                                ${{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 2) }}
                                            </span>

                                            <button class="btn btn-sm"
                                                wire:click="removeFromCart('{{ $id }}')"
                                                wire:loading.attr="disabled" wire:target="removeFromCart"
                                                style="border: none; background: transparent; color: #777; padding: 0.4rem;">
                                                <i class="fas fa-times" style="font-size: 16px;"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="cart-total mt-4 pt-4" style="border-top: 2px solid #0f0f10;">
                        @php
                            $totalQuantity = 0;
                            $totalPrice = 0;

                            foreach ($cartItems as $item) {
                                $totalQuantity += $item['quantity'] ?? 1;
                                $totalPrice += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
                            }
                        @endphp

                        <div class="d-flex justify-content-between mb-3"
                            style="font-size: 14px; color: #777; letter-spacing: 0.5px;">
                            <span>ТОВАРЫ ({{ $totalQuantity }})</span>
                            <span>${{ number_format($totalPrice, 2) }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-3"
                            style="font-size: 14px; color: #777; letter-spacing: 0.5px;">
                            <span>ДОСТАВКА</span>
                            <span>БЕСПЛАТНО</span>
                        </div>

                        <div class="d-flex justify-content-between fw-bold pt-3 mb-4"
                            style="border-top: 1px solid #e5e5e5; font-family: 'Oswald', sans-serif; font-size: 28px; letter-spacing: 2px;">
                            <span>ИТОГО:</span>
                            <span style="color: #0f0f10;">${{ number_format($totalPrice, 2) }}</span>
                        </div>

                        <button onclick="window.location.href='{{ route('cart') }}'"
                            style="width: 100%; background: #0f0f10; color: white; border: none; padding: 1rem; font-family: 'Oswald', sans-serif; font-size: 18px; letter-spacing: 2px; cursor: pointer; transition: background 0.3s ease; margin-bottom: 0.75rem;">
                            ОФОРМИТЬ ЗАКАЗ
                        </button>

                        <button class="btn-close-cart" data-bs-dismiss="offcanvas"
                            style="width: 100%; background: transparent; color: #0f0f10; border: 1px solid #e5e5e5; padding: 1rem; font-family: 'Oswald', sans-serif; font-size: 18px; letter-spacing: 2px; cursor: pointer; transition: all 0.3s ease;">
                            ПРОДОЛЖИТЬ ПОКУПКИ
                        </button>
                    </div>
                </div>
            @else
                <div class="cart-empty text-center py-5" style="padding: 3rem 1.5rem;">
                    <i class="fas fa-shopping-cart fa-3x mb-4" style="color: #e5e5e5;"></i>
                    <h6
                        style="font-family: 'Oswald', sans-serif; font-size: 24px; letter-spacing: 2px; margin-bottom: 0.5rem; color: #0f0f10;">
                        КОРЗИНА ПУСТА
                    </h6>
                    <p
                        style="color: #777; letter-spacing: 0.5px; margin-bottom: 2rem; font-family: 'Oswald', sans-serif;">
                        Добавьте товары из каталога
                    </p>
                    <button class="btn-close-cart" data-bs-dismiss="offcanvas"
                        style="background: #0f0f10; color: white; border: none; padding: 1rem 2rem; font-family: 'Oswald', sans-serif; font-size: 18px; letter-spacing: 2px; cursor: pointer;">
                        НАЧАТЬ ПОКУПКИ
                    </button>
                </div>
            @endif
        </div>
    </div>

    <style>
        .offcanvas {
            border-left: 1px solid #e5e5e5 !important;
        }

        .offcanvas-header {
            background: #fff;
        }

        .offcanvas,
        .offcanvas-header,
        .offcanvas-body,
        .btn-close-cart:hover {
            border-radius: 0 !important;

        }

        .quantity-controls button:hover {
            background: #f5f5f5 !important;
        }

        .btn-close-cart:hover {
            background: #7FFF00 !important;
            border-color: #0f0f10 !important;
        }

        .offcanvas-body::-webkit-scrollbar {
            width: 6px;
        }

        .offcanvas-body::-webkit-scrollbar-track {
            background: #f5f5f5;
        }

        .offcanvas-body::-webkit-scrollbar-thumb {
            background: #0f0f10;
        }

        .offcanvas-body::-webkit-scrollbar-thumb:hover {
            background: #333;
        }

        .cart-item {
            transition: opacity 0.3s ease;
        }

        .cart-item:hover {
            opacity: 0.9;
        }

        button {
            transition: all 0.3s ease !important;
        }

        button:active {
            transform: scale(0.98);
        }

        .quantity-controls button:disabled {
            cursor: not-allowed;
            opacity: 0.3;
        }

        .quantity-controls button:disabled:hover {
            background: transparent !important;
        }
    </style>
</div>
