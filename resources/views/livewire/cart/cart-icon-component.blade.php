<li class="nav-item position-relative">
    <button
        class="nav-link shopmi-cart-trigger position-relative"
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasCart"
        aria-controls="offcanvasCart"
    >
        КОРЗИНА
        @if ($cartCount > 0)
            <span class="shopmi-cart-count">{{ $cartCount }}</span>
        @endif
    </button>
</li>
