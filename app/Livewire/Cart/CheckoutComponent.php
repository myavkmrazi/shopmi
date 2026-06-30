<?php

namespace App\Livewire\Cart;

use App\Helpers\Cart\Cart;
use App\Mail\OrderClient;
use App\Mail\OrderManager;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class CheckoutComponent extends Component
{
    public string $name = '';

    public string $surname = '';

    public string $email = '';

    public string $phone = '';

    public string $city = '';

    public string $address = '';

    public string $payment_method = 'cash';

    public string $note = '';

    public bool $agreed = false;

    public function mount()
    {
        $this->name = auth()->user()->name ?? '';
        $this->surname = auth()->user()->surname ?? '';
        $this->email = auth()->user()->email ?? '';
        $this->phone = auth()->user()->phone ?? '';
        $this->city = auth()->user()->city ?? '';
        $this->address = auth()->user()->address ?? '';
    }

    public function saveOrder()
    {
        $validated = $this->validate([
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|max:255',
            'city' => 'required|max:255',
            'address' => 'required|max:500',
            'payment_method' => 'required|in:cash,card',
            'note' => 'nullable|string',
            'agreed' => 'accepted',
        ], [
            'agreed.accepted' => 'Необходимо согласие с условиями покупки',
        ]);

        $cartCheck = Cart::validateForCheckout();

        if (! $cartCheck['success']) {
            foreach ($cartCheck['errors'] as $error) {
                $this->addError('cart', $error);
            }

            $this->dispatch('showToast', message: $cartCheck['errors'][0] ?? 'Ошибка корзины', type: 'error');

            return;
        }

        $cart = Cart::getCart();

        $total = 0;
        foreach ($cart as $product) {
            $total += ($product['price'] ?? 0) * ($product['quantity'] ?? 1);
        }

        $orderData = array_merge($validated, [
            'user_id' => auth()->id(),
            'total' => $total,
            'status' => 'new',
        ]);

        try {
            DB::beginTransaction();

            $order = Order::create($orderData);

            $orderProducts = [];
            foreach ($cart as $productId => $product) {
                $orderProducts[] = [
                    'product_id' => $productId,
                    'title' => $product['title'] ?? 'Product',
                    'price' => $product['price'] ?? 0,
                    'quantity' => $product['quantity'] ?? 1,
                    'slug' => $product['slug'] ?? '',
                    'image' => $product['image'] ?? '',
                ];

                \App\Models\Product::query()
                    ->whereKey($productId)
                    ->decrement('stock', (int) ($product['quantity'] ?? 1));
            }

            $order->orderProducts()->createMany($orderProducts);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Order checkout failed: '.$e->getMessage());
            Log::error('Trace: '.$e->getTraceAsString());

            $this->js("
                toastr.error('Order checkout failed');
                console.error('Order checkout failed:', ".json_encode([
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]).');
            ');

            return;
        }

        session([
            'cart' => [],
            'checkout_success_order_id' => $order->id,
        ]);
        $this->dispatch('cart-updated');

        try {
            Mail::to($validated['email'])->send(new OrderClient(
                $cart,
                $total,
                $order->id,
                $validated['note'] ?? ''
            ));
            Log::info('Order client email sent');
        } catch (\Exception $mailException) {
            Log::warning('Order client email failed: '.$mailException->getMessage());
        }

        try {
            Mail::to('manager@laravel-myavka.ru')->send(new OrderManager($order->id));
            Log::info('Order manager email sent');
        } catch (\Exception $mailException) {
            Log::warning('Order manager email failed: '.$mailException->getMessage());
        }

        return $this->redirectRoute('checkout.success', navigate: true);
    }

    public function render()
    {
        return view('livewire.cart.checkout-component');
    }
}
