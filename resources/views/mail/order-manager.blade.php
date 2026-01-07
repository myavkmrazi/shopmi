<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ваш заказ #{{ $order->id }}</title>
    <style>
        /* Основные стили */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .order-number {
            font-size: 24px;
            margin: 20px 0;
            color: white;
        }

        .order-status {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 14px;
            margin-top: 10px;
        }

        .content {
            padding: 30px;
        }

        .section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .section:last-child {
            border-bottom: none;
        }

        .section-title {
            color: #764ba2;
            font-size: 18px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 10px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .info-item {
            margin-bottom: 10px;
        }

        .info-label {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .info-value {
            font-weight: 500;
            color: #333;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .products-table th {
            background-color: #f8f9fa;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            color: #555;
            border-bottom: 2px solid #dee2e6;
        }

        .products-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        .product-name {
            font-weight: 500;
            color: #333;
        }

        .product-price {
            color: #764ba2;
            font-weight: 600;
        }

        .totals {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
        }

        .total-row:last-child {
            border-bottom: none;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 25px 30px;
            text-align: center;
            border-top: 1px solid #dee2e6;
        }

        .contact-info {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .contact-info a {
            color: #764ba2;
            text-decoration: none;
        }

        .social-links {
            margin: 20px 0;
        }

        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #764ba2;
            text-decoration: none;
            font-weight: 500;
        }

        .copyright {
            color: #999;
            font-size: 12px;
            margin-top: 20px;
        }

        /* Адаптивность */
        @media (max-width: 600px) {
            .container {
                margin: 10px;
                border-radius: 8px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .header {
                padding: 20px 15px;
            }

            .content {
                padding: 20px 15px;
            }

            .products-table {
                display: block;
                overflow-x: auto;
            }
        }

        /* Иконки (используем emoji или символы) */
        .icon::before {
            content: "✓";
            margin-right: 8px;
            color: #28a745;
        }

        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Шапка письма -->
        <div class="header">
            <div class="logo">{{ config('app.name', 'Магазин') }}</div>
            <h1 class="order-number">Заказ #{{ $order->id }}</h1>
            <div class="order-status">
                @switch($order->status)
                    @case('pending')
                        ⏳ Ожидает обработки
                    @break

                    @case('processing')
                        🔄 В обработке
                    @break

                    @case('shipped')
                        🚚 Отправлен
                    @break

                    @case('delivered')
                        ✅ Доставлен
                    @break

                    @case('cancelled')
                        ❌ Отменен
                    @break

                    @default
                        📝 Новый заказ
                @endswitch
            </div>
        </div>

        <!-- Основное содержимое -->
        <div class="content">
            <!-- Приветствие -->
            <div class="section">
                <h2>Здравствуйте, {{ $order->user->name ?? 'Уважаемый клиент' }}!</h2>
                <p>Благодарим вас за заказ в нашем магазине. Вот детали вашего заказа:</p>
            </div>

            <!-- Информация о заказе -->
            <div class="section">
                <h3 class="section-title">📋 Информация о заказе</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Номер заказа</div>
                        <div class="info-value">#{{ $order->id }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Дата заказа</div>
                        <div class="info-value">{{ $order->created_at->format('d.m.Y H:i') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Статус</div>
                        <div class="info-value">
                            @switch($order->status)
                                @case('pending')
                                    <span style="color: #ffc107;">⏳ Ожидает обработки</span>
                                @break

                                @case('processing')
                                    <span style="color: #17a2b8;">🔄 В обработке</span>
                                @break

                                @case('shipped')
                                    <span style="color: #007bff;">🚚 Отправлен</span>
                                @break

                                @case('delivered')
                                    <span style="color: #28a745;">✅ Доставлен</span>
                                @break

                                @case('cancelled')
                                    <span style="color: #dc3545;">❌ Отменен</span>
                                @break

                                @default
                                    <span style="color: #6c757d;">📝 Новый заказ</span>
                            @endswitch
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Способ оплаты</div>
                        <div class="info-value">
                            @if ($order->payment_method == 'card')
                                💳 Банковская карта
                            @elseif($order->payment_method == 'cash')
                                💵 Наличными при получении
                            @else
                                {{ $order->payment_method }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Информация о доставке -->
            <div class="section">
                <h3 class="section-title">🚚 Информация о доставке</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Получатель</div>
                        <div class="info-value">{{ $order->name ?? ($order->user->name ?? 'Не указано') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $order->email ?? $order->user->email }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Телефон</div>
                        <div class="info-value">{{ $order->phone ?? ($order->user->phone ?? 'Не указан') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Адрес доставки</div>
                        <div class="info-value">{{ $order->address ?? 'Не указан' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Город</div>
                        <div class="info-value">{{ $order->city ?? 'Не указан' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Комментарий</div>
                        <div class="info-value">{{ $order->note ?? 'Без комментариев' }}</div>
                    </div>
                </div>
            </div>

            <!-- Товары в заказе -->
            <div class="section">
                <h3 class="section-title">🛒 Состав заказа</h3>

                На сайте был сделан новый заказ..
                <tbody>
                    @foreach ($order->orderProducts as $product)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center;">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->title }}" class="product-image"
                                            onerror="this.style.display='none'">
                                    @endif
                                    <div style="margin-left: {{ $product->image ? '15px' : '0' }}">
                                        <div class="product-name">{{ $product->title }}</div>
                                        @if ($product->slug)
                                            <small style="color: #666;">Арт: {{ $product->slug }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="product-price">${{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td class="product-price">${{ number_format($product->price * $product->quantity, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>

            <!-- Итоги -->
            <div class="section">
                <h3 class="section-title">💰 Итоговая сумма</h3>
                <div class="totals">
                    <div class="total-row">
                        <span>Товары ({{ $order->orderProducts->sum('quantity') }} шт.)</span>
                        <span>${{ number_format(
                            $order->orderProducts->sum(function ($product) {
                                return $product->price * $product->quantity;
                            }),
                            2,
                        ) }}</span>
                    </div>
                    <div class="total-row">
                        <span>Доставка</span>
                        <span style="color: #28a745;">Бесплатно</span>
                    </div>
                    @if ($order->discount > 0)
                        <div class="total-row">
                            <span>Скидка</span>
                            <span style="color: #dc3545;">-${{ number_format($order->discount, 2) }}</span>
                        </div>
                    @endif
                    <div class="total-row">
                        <span>Итого к оплате</span>
                        <span style="color: #764ba2; font-weight: bold;">
                            ${{ number_format($order->total, 2) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Дополнительная информация -->
            <div class="section">
                <h3 class="section-title">ℹ️ Дополнительная информация</h3>
                <p>Мы свяжемся с вами для подтверждения заказа в ближайшее время.</p>
                <p>Вы можете отслеживать статус вашего заказа в <a href="{{ route('profile.orders') }}"
                        style="color: #764ba2;">личном кабинете</a>.</p>

                @if ($order->payment_method == 'cash')
                    <div
                        style="background-color: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin-top: 15px;">
                        <strong>💵 Оплата наличными:</strong> Оплата производится при получении заказа.
                    </div>
                @endif
            </div>

            <!-- Кнопка отслеживания -->
            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ route('order.track', ['id' => $order->id]) }}" class="btn">
                    📱 Отследить заказ
                </a>
            </div>
        </div>

        <!-- Подвал -->
        <div class="footer">
            <div class="contact-info">
                <p>Если у вас есть вопросы по заказу, свяжитесь с нами:</p>
                <p>📧 Email: <a href="mailto:support@example.com">support@example.com</a></p>
                <p>📞 Телефон: <a href="tel:+78001234567">8 (800) 123-45-67</a></p>
                <p>🕐 Часы работы: Пн-Пт с 9:00 до 18:00</p>
            </div>

            <div class="social-links">
                <a href="#">Facebook</a> |
                <a href="#">Instagram</a> |
                <a href="#">Telegram</a> |
                <a href="#">VK</a>
            </div>

            <div class="copyright">
                © {{ date('Y') }} {{ config('app.name', 'Магазин') }}. Все права защищены.<br>
                Это письмо отправлено автоматически, пожалуйста, не отвечайте на него.
            </div>
        </div>
    </div>
</body>

</html>
