<div>
    <button class="btn p-1 position-relative border-0" type="button" data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
        <i class="fas fa-shopping-cart fs-5 text-dark"></i>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
            {{ \App\Helpers\Cart\Cart::getCartQuantityItems() }}
        </span>
    </button>

</div>
