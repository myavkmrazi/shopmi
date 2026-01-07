<?php

namespace App\Livewire\Cart;

use App\Mail\OrderClient;
use App\Mail\OrderManager;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use App\Helpers\Cart\Cart;

class CheckoutComponent extends Component
{
    public string $name = '';
    public string $surname = '';
    public string $email = '';
    public string $note = '';

    public function mount()
    {

        $this->name = auth()->user()->name ?? '';
        $this->surname = auth()->user()->surname ?? '';
        $this->email = auth()->user()->email ?? '';
    }

    public function saveOrder()
    {
        // Валидация полей
        $validated = $this->validate([
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'email' => 'required|email|max:255',
            'note' => 'nullable|string',
        ]);

        // Получаем корзину
        $cart = \App\Helpers\Cart\Cart::getCart();

        // Проверяем, что корзина не пуста
        if (empty($cart)) {
            $this->js("toastr.error('Корзина пуста!')");
            return;
        }

        // Вычисляем общую сумму
        $total = 0;
        foreach ($cart as $product) {
            $total += ($product['price'] ?? 0) * ($product['quantity'] ?? 1);
        }

        // Подготавливаем данные для заказа
        $orderData = array_merge($validated, [
            'user_id' => auth()->id(),
            'total' => $total, // Используем вычисленную сумму, а не количество
            'status' => 'pending', // Добавляем статус
            'payment_method' => 'cash', // Добавляем способ оплаты
        ]);

        try {
            DB::beginTransaction();

            // Создаем заказ
            $order = Order::create($orderData);

            // Подготавливаем товары для заказа
            $order_products = [];
            foreach ($cart as $product_id => $product) {
                $order_products[] = [
                    'product_id' => $product_id,
                    'title' => $product['title'] ?? 'Товар',
                    'price' => $product['price'] ?? 0,
                    'quantity' => $product['quantity'] ?? 1,
                    'slug' => $product['slug'] ?? '',
                    'image' => $product['image'] ?? '',
                ];
            }

            // Сохраняем товары заказа
            $order->orderProducts()->createMany($order_products);

            // ОТПРАВКА ПИСЕМ - временно закомментируйте для теста
            try {
                Mail::to($validated['email'])->send(new OrderClient(
                    $cart, // Передаем корзину, а не order_products
                    $total, // Общую сумму
                    $order->id,
                    $validated['note'] ?? ''
                ));
                Log::info('Письмо клиенту отправлено');
            } catch (\Exception $mailException) {
                Log::warning('Ошибка отправки письма клиенту: ' . $mailException->getMessage());
                // Не прерываем выполнение из-за ошибки почты
            }

            try {
                Mail::to('manager@laravel-myavka.ru')->send(new OrderManager($order->id));
                Log::info('Письмо менеджеру отправлено');
            } catch (\Exception $mailException) {
                Log::warning('Ошибка отправки письма менеджеру: ' . $mailException->getMessage());
            }

            session(['cart' => []]);
            $this->dispatch('cart-updated');

            // Успешное сообщение с номером заказа
            $this->js("
            toastr.success('Заказ #{$order->id} успешно оформлен!');
            setTimeout(function() {
                window.location.href = '/';
                }, 2000);
                ");
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Ошибка оформления заказа: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());

            // Показываем детальную ошибку в консоли
            $this->js("
                toastr.error('Ошибка при оформлении заказа');
                console.error('Ошибка заказа:', " . json_encode([
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]) . ");
            ");
        }
    }

    public function render()
    {
        return view('livewire.cart.checkout-component');
    }
}
