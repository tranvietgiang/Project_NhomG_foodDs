<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Xác nhận đơn hàng | FoodDS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('component/css/foodds.css') }}">
    <style>
        .bill-page {
            padding: 24px 0 42px;
        }

        .bill-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 360px;
            gap: 18px;
            align-items: start;
        }

        .bill-products {
            display: grid;
            gap: 12px;
        }

        .bill-product {
            display: grid;
            grid-template-columns: 96px minmax(0, 1fr) auto;
            gap: 14px;
            align-items: center;
            border: 1px solid var(--fd-border);
            border-radius: 16px;
            padding: 12px;
            background: #fff;
        }

        .bill-product img {
            width: 96px;
            height: 96px;
            border-radius: 14px;
            object-fit: cover;
            background: #f1f5f9;
        }

        .bill-product h2 {
            margin: 0 0 6px;
            font-size: 17px;
            font-weight: 900;
        }

        .bill-product p {
            margin: 0;
            color: var(--fd-muted);
            font-size: 13px;
        }

        .bill-money {
            color: var(--fd-red);
            font-weight: 900;
            white-space: nowrap;
        }

        .summary-panel {
            position: sticky;
            top: 16px;
        }

        .summary-line {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding: 11px 0;
            border-bottom: 1px dashed var(--fd-border);
        }

        .payment-grid {
            display: grid;
            gap: 10px;
            margin: 14px 0;
        }

        .payment-card {
            border: 1px solid var(--fd-border);
            border-radius: 14px;
            padding: 12px 13px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .payment-card input {
            accent-color: var(--fd-green);
            width: 18px;
            height: 18px;
        }

        .payment-card:has(input:checked) {
            border-color: #86efac;
            background: #f0fdf4;
            color: var(--fd-green-dark);
        }

        @media (max-width: 860px) {
            .bill-layout {
                grid-template-columns: 1fr;
            }

            .summary-panel {
                position: static;
            }
        }

        @media (max-width: 560px) {
            .bill-product {
                grid-template-columns: 82px minmax(0, 1fr);
            }

            .bill-product img {
                width: 82px;
                height: 82px;
            }

            .bill-money {
                grid-column: 2;
            }
        }
    </style>
</head>

<body>
    @php
        $tongTien = $cartShow->sum(fn($item) => $item->quantity_sp * $item->total_price);
    @endphp

    <main class="bill-page">
        <div class="fd-container">
            <div class="fd-section-head">
                <div>
                    <p class="fd-eyebrow">Checkout</p>
                    <h1 class="fd-title">Xác nhận đơn hàng</h1>
                    <p class="fd-muted">Kiểm tra lại món đã chọn và chọn phương thức thanh toán.</p>
                </div>
                <a href="{{ route('cart.shows_goods') }}" class="fd-btn fd-btn-outline">
                    <i class="bi bi-arrow-left"></i> Quay lại giỏ
                </a>
            </div>

            @if (session('addressNotExists'))
                <div class="fd-alert warning">
                    {{ session('addressNotExists') }}
                    <a href="{{ url('/information-client') }}" style="color:#9a3412;font-weight:900">Cập nhật địa chỉ</a>
                </div>
            @endif

            @if (session('payment-error'))
                <div class="fd-alert warning">{{ session('payment-error') }}</div>
            @endif

            <div class="bill-layout">
                <section class="fd-panel">
                    @if ($cartShow->isEmpty())
                        <div style="text-align:center;padding:46px 18px">
                            <i class="bi bi-receipt-cutoff" style="font-size:54px;color:var(--fd-green)"></i>
                            <h2 class="fd-title" style="font-size:24px;margin-top:12px">Chưa có sản phẩm để thanh toán</h2>
                            <p class="fd-muted">Bạn hãy quay lại giỏ hàng và chọn món trước.</p>
                        </div>
                    @else
                        <div class="bill-products">
                            @foreach ($cartShow as $item)
                                <article class="bill-product">
                                    <img src="{{ asset('component/image-product/' . $item->image) }}" alt="{{ $item->products->product_name ?? 'Sản phẩm' }}">
                                    <div>
                                        <h2>{{ $item->products->product_name ?? 'Không có tên' }}</h2>
                                        <p>Số lượng: {{ $item->quantity_sp }}</p>
                                        <p>Đơn giá: {{ number_format($item->total_price) }} đ</p>
                                    </div>
                                    <strong class="bill-money">{{ number_format($item->quantity_sp * $item->total_price) }} đ</strong>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </section>

                <aside class="fd-panel summary-panel">
                    <h2 class="fd-title" style="font-size:24px">Thanh toán</h2>
                    <div class="summary-line">
                        <span>Tạm tính</span>
                        <strong>{{ number_format($tongTien) }} đ</strong>
                    </div>
                    <div class="summary-line">
                        <span>Phí vận chuyển</span>
                        <strong>0 đ</strong>
                    </div>
                    <div class="summary-line" style="border-bottom:0">
                        <span>Tổng thanh toán</span>
                        <strong class="fd-price">{{ number_format($tongTien) }} đ</strong>
                    </div>

                    <form id="paymentForm" method="POST" style="margin-top:16px">
                        @csrf
                        <input type="hidden" name="arrShow" value="{{ e($cartShow->toJson()) }}">
                        <input type="hidden" name="total_price_payment" value="{{ $tongTien }}">

                        <div class="payment-grid">
                            <label class="payment-card" for="cod">
                                <input type="radio" id="cod" name="payment_method" checked value="cod">
                                <span><i class="bi bi-cash-coin"></i> Thanh toán khi nhận hàng</span>
                            </label>

                            <label class="payment-card" for="vnpay">
                                <input type="radio" id="vnpay" name="payment_method" value="vnpay">
                                <span><i class="bi bi-credit-card-2-front"></i> VNPay</span>
                            </label>

                            <label class="payment-card" for="zalopay">
                                <input type="radio" id="zalopay" name="payment_method" value="zalopay">
                                <span><i class="bi bi-wallet2"></i> ZaloPay</span>
                            </label>

                            <label class="payment-card" for="momo">
                                <input type="radio" id="momo" name="payment_method" value="momo">
                                <span><i class="bi bi-phone"></i> MoMo</span>
                            </label>
                        </div>

                        <button class="fd-btn" style="width:100%" @disabled($cartShow->isEmpty())>
                            <i class="bi bi-shield-check"></i> Thanh toán
                        </button>
                    </form>
                </aside>
            </div>
        </div>
    </main>

    <script>
        document.getElementById("paymentForm").addEventListener("submit", function(event) {
            event.preventDefault();

            const selected = document.querySelector('input[name="payment_method"]:checked').value;
            const form = event.target;

            form.method = "POST";

            if (selected === "vnpay") {
                form.action = "{{ route('vnpay.payment.many') }}";
            } else if (selected === "zalopay") {
                form.action = "{{ route('zalo.many.payment') }}";
            } else if (selected === "momo") {
                form.action = "{{ route('momo_payment') }}";
            } else {
                form.action = "{{ route('cod.ttknh.cartMany') }}";
            }

            form.submit();
        });
    </script>
</body>

</html>
