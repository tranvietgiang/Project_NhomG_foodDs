<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt</title>
    <style>
        :root {
            --primary-color: #3f51b5;
            --accent-color: #7986cb;
            --light-gray: #f5f7fa;
            --text-dark: #333;
            --text-light: #777;
            --success: #4caf50;
        }

        body {
            font-family: 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            color: var(--text-dark);
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .receipt-header h1 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 5px;
        }

        .receipt-header p {
            color: var(--text-light);
            font-size: 16px;
        }

        .product-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .product-card {
            border: 1px solid #eee;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #eee;
        }

        .product-details {
            padding: 15px;
        }

        .product-name {
            font-weight: 600;
            font-size: 18px;
            margin-bottom: 5px;
            color: var(--primary-color);
        }

        .product-price {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .product-quantity {
            font-size: 16px;
            color: var(--text-light);
        }

        .receipt-footer {
            background-color: var(--light-gray);
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .total-price {
            font-size: 24px;
            font-weight: 600;
            color: var(--primary-color);
            text-align: right;
            margin-bottom: 20px;
        }

        .thank-you {
            text-align: center;
            margin: 20px 0;
            font-size: 18px;
            font-weight: 500;
        }

        .home-button {
            display: block;
            width: 200px;
            margin: 0 auto;
            background-color: var(--primary-color);
            color: white;
            text-align: center;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 500;
            transition: background-color 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .home-button:hover {
            background-color: var(--accent-color);
        }

        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;
            text-align: center;
            font-weight: 500;
        }

        .alert-success {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--success);
            border: 1px solid rgba(76, 175, 80, 0.3);
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
                margin: 20px;
            }

            .product-list {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="receipt-header">
            <h1>Order Receipt</h1>
            <p>Thank you for your purchase</p>
        </div>

        <div class="product-list">
            @foreach ($show_bill as $item)
                <div class="product-card">
                    <img src="{{ asset('component/image-product/' . $item->product_image) }}" class="product-image"
                        alt="{{ $item->product_name }}">
                    <div class="product-details">
                        <div class="product-name">{{ $item->product_name }}</div>
                        <div class="product-price"><strong>Price:</strong>
                            {{ number_format($item->product_price, 0, ',', '.') }} đ</div>
                        <div class="product-quantity"><strong>Quantity:</strong> {{ $item->quantity_sp }}</div>
                    </div>
                </div>
                @php
                    $total_price = $item->TOTAL_PRICE;
                @endphp
            @endforeach
        </div>

        <div class="receipt-footer">
            <div class="total-price">Total: {{ number_format($total_price, 0, ',', '.') }} đ</div>
            <div class="thank-you">
                <strong>Thank you for your purchase and trust in our products!</strong>
            </div>
            <a href="{{ route('website-main') }}" class="home-button">Return to Home</a>
        </div>
    </div>

    @if (session('order-success'))
        <div class="container">
            <div class="alert alert-success">
                {{ session('order-success') }}
            </div>
        </div>
    @endif
</body>

</html>
