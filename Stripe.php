<?php
require 'vendor/autoload.php'; // Загрузка библиотеки Stripe

\Stripe\Stripe::setApiKey('YOUR_STRIPE_SECRET_KEY');

function create_checkout_session($amount, $currency = 'usd') {
    try {
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => $currency,
                    'product_data' => [
                        'name' => 'Test Product',
                    ],
                    'unit_amount' => $amount * 100, // Сумма в центах
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => 'https://yourdomain.com/success',
            'cancel_url' => 'https://yourdomain.com/cancel',
        ]);

        return $session->url; // URL для переадресации на оплату
    } catch (Exception $e) {
        return 'Ошибка: ' . $e->getMessage();
    }
}

// Пример использования
$checkout_url = create_checkout_session(100); // Сумма в долларах
echo "<a href='$checkout_url'>Перейти к оплате</a>";
?>
