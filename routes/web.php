<?php

use App\Http\Controllers\Api\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\HomeComponent::class)->name('home');
Route::get('/category/{slug}', \App\Livewire\Product\CategoryComponent::class)->name('category');
Route::get('/products/{slug}', \App\Livewire\Product\ProductComponent::class)->name('product');
Route::get('/cart', \App\Livewire\Cart\Cart::class)->name('cart');
Route::get('/checkout', \App\Livewire\Cart\CheckoutComponent::class)->name('checkout');
Route::get('/checkout/success', \App\Livewire\Cart\CheckoutSuccessComponent::class)->name('checkout.success');
Route::get('/search', \App\Livewire\Search\SearchComponent::class)->name('search');
Route::get('/wishlist', \App\Livewire\Wishlist\WishlistComponent::class)->name('wishlist');


Route::middleware('guest')->group(function () {
    Route::get('/register', \App\Livewire\User\RegisterComponent::class)->name('register');
    Route::get('/login', \App\Livewire\User\LoginComponent::class)->name('login');
});


Route::middleware('auth')->group(function () {
    Route::get('/account', \App\Livewire\User\AccountComponent::class)->name('account');
    Route::get('/change-account', \App\Livewire\User\ChangeAccountComponent::class)->name('change-account');
    Route::get('/orders', \App\Livewire\User\OrderComponent::class)->name('orders');
    Route::get('/order-show/{id}', \App\Livewire\User\OrderShowComponent::class)->name('orders-show');


    Route::post('/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});




Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/', App\Livewire\Admin\HomeComponent::class)->name('admin');

    Route::get('/categories', \App\Livewire\Admin\Category\CategoryIndexComponent::class)->name('admin.categories.index');
    Route::get('/categories/create', \App\Livewire\Admin\Category\CategoryCreateComponent::class)->name('admin.categories.create');
    Route::get('/categories/{category}/edit', \App\Livewire\Admin\Category\CategoryEditComponent::class)->name('admin.categories.edit');

    Route::get('/products', \App\Livewire\Admin\Product\ProductIndexComponent::class)->name('admin.products.index');
    Route::get('/products/create', \App\Livewire\Admin\Product\ProductCreateComponent::class)->name('admin.products.create');
    Route::get('/products/{product}/edit', \App\Livewire\Admin\Product\ProductEditComponent::class)->name('admin.products.edit');

    Route::get('/filter-groups', \App\Livewire\Admin\Filter\FilterGroupIndexComponent::class)->name('admin.filter-groups.index');
    Route::get('/filter-groups/create', \App\Livewire\Admin\Filter\FilterGroupCreateComponent::class)->name('admin.filter-groups.create');
    Route::get('/filter-groups/{filter_group}/edit', \App\Livewire\Admin\Filter\FilterGroupEditComponent::class)->name('admin.filter-groups.edit');

    Route::get('/filters', \App\Livewire\Admin\Filter\FilterIndexComponent::class)->name('admin.filters.index');
    Route::get('/filters/create', \App\Livewire\Admin\Filter\FilterCreateComponent::class)->name('admin.filters.create');
    Route::get('/filters/{filter}/edit', \App\Livewire\Admin\Filter\FilterEditComponent::class)->name('admin.filters.edit');

    Route::get('/orders', \App\Livewire\Admin\Order\OrderIndexComponent::class)->name('admin.orders.index');
    Route::get('/orders/{order}/edit', \App\Livewire\Admin\Order\OrderEditComponent::class)->name('admin.orders.edit');

    Route::get('/users', \App\Livewire\Admin\User\UserIndexComponent::class)->name('admin.users.index');
    Route::get('/users/create', \App\Livewire\Admin\User\UserCreateComponent::class)->name('admin.users.create');
    Route::get('/users/{user}/edit', \App\Livewire\Admin\User\UserEditComponent::class)->name('admin.users.edit');
});

Route::get('/api/cart', [CartController::class, 'index']);
Route::post('/api/cart', [CartController::class, 'store']);
Route::delete('/api/cart/{id}', [CartController::class, 'destroy']);
