<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказ #{{ $order_id }}</title>
    <style>
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
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .order-number {
            font-size: 20px;
            margin: 15px 0;
            color: white;
        }

        .content {
            padding: 30px;
        }

        .section {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .section:last-child {
            border-bottom: none;
        }

        .section-title {
            color: #764ba2;
            font-size: 18px;
            margin-bottom: 15px;
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
            padding: 20px 30px;
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

        .copyright {
            color: #999;
            font-size: 12px;
            margin-top: 20px;
        }

        @media (max-width: 600px) {
            .container {
                margin: 10px;
                border-radius: 8px;
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
    </style>
</head>

<body>
    <div class="container">
        <!-- Шапка письма -->
        <div class="header">
            <div class="logo">Магазин</div>
            <h1 class="order-number">Заказ #{{ $order_id }}</h1>
            <p>Благодарим за покупку!</p>
        </div>

        <!-- Основное содержимое -->
        <div class="content">
            <!-- Приветствие -->
            <div class="section">
                <h2>Здравствуйте!</h2>
                <p>Ваш заказ успешно оформлен. Вот детали вашего заказа:</p>
            </div>

            <!-- Информация о заказе -->
            <div class="section">
                <h3 class="section-title">📋 Информация о заказе</h3>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; color: #666;">Номер заказа:</td>
                        <td style="padding: 8px 0; font-weight: 500;">#{{ $order_id }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #666;">Дата заказа:</td>
                        <td style="padding: 8px 0;">{{ date('d.m.Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #666;">Статус:</td>
                        <td style="padding: 8px 0; color: #ffc107;">⏳ Ожидает обработки</td>
                    </tr>
                </table>
            </div>

            <!-- Товары в заказе -->
            <div class="section">
                <h3 class="section-title">🛒 Состав заказа</h3>
                @if (count($cart) > 0)
                    <table class="products-table">
                        <thead>
                            <tr>
                                <th>Товар</th>
                                <th>Цена</th>
                                <th>Кол-во</th>
                                <th>Сумма</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalQuantity = 0;
                            @endphp
                            @foreach ($cart as $product_id => $product)
                                @php
                                    $totalQuantity += $product['quantity'] ?? 1;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="product-name">{{ $product['title'] ?? 'Товар' }}</div>
                                        @if (!empty($product['slug']))
                                            <small style="color: #666;">Арт: {{ $product['slug'] }}</small>
                                        @endif
                                    </td>
                                    <td class="product-price">${{ number_format($product['price'] ?? 0, 2) }}</td>
                                    <td>{{ $product['quantity'] ?? 1 }}</td>
                                    <td class="product-price">
                                        ${{ number_format(($product['price'] ?? 0) * ($product['quantity'] ?? 1), 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Корзина пуста</p>
                @endif
            </div>

            <!-- Итоги -->
            <div class="section">
                <h3 class="section-title">💰 Итоговая сумма</h3>
                <div class="totals">
                    <div class="total-row">
                        <span>Товары ({{ $totalQuantity ?? 0 }} шт.)</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="total-row">
                        <span>Доставка</span>
                        <span style="color: #28a745;">Бесплатно</span>
                    </div>
                    <div class="total-row">
                        <span>Итого к оплате</span>
                        <span style="color: #764ba2; font-weight: bold;">
                            ${{ number_format($total, 2) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Комментарий -->
            @if (!empty($note))
                <div class="section">
                    <h3 class="section-title">💬 Ваш комментарий</h3>
                    <p>{{ $note }}</p>
                </div>
            @endif

            <!-- Дополнительная информация -->
            <div class="section">
                <h3 class="section-title">ℹ️ Дополнительная информация</h3>
                <p>Мы свяжемся с вами для подтверждения заказа в ближайшее время.</p>
                <p>Спасибо, что выбрали наш магазин!</p>
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

            <div class="copyright">
                © {{ date('Y') }} Магазин. Все права защищены.<br>
                Это письмо отправлено автоматически, пожалуйста, не отвечайте на него.
            </div>
        </div>
    </div>
</body>

</html>
