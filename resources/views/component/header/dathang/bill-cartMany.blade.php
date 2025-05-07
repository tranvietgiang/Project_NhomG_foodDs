<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mt-5">
    <h2 class="text-center mb-4 text-primary">Thông tin đơn hàng</h2>

    <style>
        .payment-option {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .payment-option label {
            cursor: pointer;
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .payment-option input[type="radio"] {
            display: none;
        }

        .payment-option input[type="radio"]:checked+label {
            border-color: #007bff;
            background-color: #e6f0ff;
        }
    </style>
    @php
        $tongTien = 0;
    @endphp
    <div class="row">
        @foreach ($cartShow as $item)
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="row g-0">
                        <div class="col-md-5">
                            <img src="{{ asset('component/image-product/' . $item->image) }}"
                                class="img-fluid rounded-start" alt="Ảnh sản phẩm">
                        </div>
                        <div class="col-md-7">
                            <div class="card-body">
                                <h5 class="card-title text-success">
                                    {{ $item->products->product_name ?? 'Không có tên' }}</h5>
                                <p class="mb-1"><strong>Số lượng:</strong> {{ $item->quantity_sp }}</p>
                                <p class="mb-1"><strong>Giá:</strong>
                                    {{ number_format($item->total_price, 0, ',', '.') }} VND</p>
                                <p class="mb-0 text-muted"><i class="bi bi-check-circle-fill text-success"></i> Sẵn
                                    sàng giao hàng</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @php
                $totalPrice = $item->quantity_sp * $item->total_price;
                $tongTien += $totalPrice;
            @endphp
        @endforeach
    </div>

    @if (session('addressNotExists'))
        <div>{{ session('addressNotExists') }} <a href="{{ url('/information-client') }}">click</a></div>
    @endif

    <div class="card p-3 mt-3 shadow-sm">
        <h4 class="text-end text-danger">
            Tổng tiền đơn hàng: {{ number_format($tongTien) }} VND
        </h4>
        <h3>Chọn phương thức thanh toán</h3>

        <form id="paymentForm">
            @csrf
            <div class="payment-option">
                <input type="text" class="d-none" name="arrShow" value="{{ $cartShow }}">
                <input type="text" class="d-none" name="total_price_payment" value="{{ $tongTien ?? 0 }}">
                <input type="radio" id="cod" name="payment_method" checked value="cod">
                <label for="cod">Thanh toán khi nhận hàng (COD)</label>

                <input type="radio" id="vnpay" name="payment_method" value="vnpay">
                <label for="vnpay">VNPay</label>

                <input type="radio" id="zalopay" name="payment_method" value="zalopay">
                <label for="zalopay">ZaloPay</label>

                <input type="radio" id="momo" name="payment_method" value="momo">
                <label for="momo">Momo</label>
            </div>

            <button class="btn btn-primary">Thanh toán</button>
        </form>
    </div>
</div>
<script>
    document.getElementById("paymentForm").addEventListener("submit", (Element) => {
        Element.preventDefault(); // ngăn không cho gửi form default

        const selected = document.querySelector(
            'input[name="payment_method"]:checked'
        ).value;

        const form = Element.target;

        form.method = "POST";
        if (selected == "vnpay") {

        } else if (selected == "zalopay") {
            form.action = "{{ route('zalo.many.payment') }}";
        } else if (selected == "momo") {

        } else {
            form.action = "{{ route('cod.ttknh.cartMany') }}";
        }

        form.submit();
    });
</script>
