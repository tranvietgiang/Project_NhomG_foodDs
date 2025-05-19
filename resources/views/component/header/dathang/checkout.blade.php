<!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{ asset('component/css/mdb.min.css') }}">

<div class="container py-4">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i>Quay lại
        </a>
    </div>

    <!-- Error Alert -->
    @if (session('payment-error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('payment-error') }}
            <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Missing Address Alert -->
    @if (session('address_null'))
        <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
            {{ session('address_null') }},
            <a href="{{ url('/information-client') }}" class="alert-link">tại đây</a>
            <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Order Information -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h3 class="mb-0">Thông tin đơn hàng</h3>
                </div>
                <div class="card-body">
                    @foreach ($cart as $item)
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-3 mb-3 mb-md-0">
                                        <img src="{{ asset('component/image-product/' . $item->product_image) }}"
                                            alt="{{ $item->product_name }}" class="img-fluid rounded" width="100">
                                    </div>
                                    <div class="col-md-9">
                                        <h5 class="card-title">{{ $item->product_name }}</h5>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Số lượng: <strong>{{ $item->quantity_sp }}</strong></span>
                                            <span>Giá: <strong>{{ number_format($item->total_price, 0, ',', '.') }}
                                                    ₫</strong></span>
                                        </div>
                                        <div class="text-end">
                                            <span>Thành tiền:
                                                <strong>{{ number_format($item->total_price * $item->quantity_sp, 0, ',', '.') }}
                                                    ₫</strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @php
                            /* lấy ra id cart để lưu vào bill*/
                            $cart_id_payment = $item->cart_id;
                            $product_get_id = $item->product_id;
                            $total_price_final = $item->total_price * $item->quantity_sp;
                            $product_name = $item->product_name;
                            $product_quantity = $item->quantity_sp;
                            $product_image = $item->product_image;
                            $product_price = $item->total_price;
                        @endphp
                    @endforeach

                    <!-- Coupon -->
                    <div class="mt-4">
                        <div class="input-group">
                            <input type="text" class="form-control" id="cart_discount" name="cart_discount"
                                placeholder="Nhập mã giảm giá">
                            <button class="btn btn-outline-primary" type="button" id="apply-coupon">Áp dụng</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Summary -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h4 class="mb-0">Thanh toán</h4>
                </div>
                <div class="card-body">
                    <form id="paymentForm" method="POST">
                        @csrf
                        <input type="hidden" name="user_id_payment" value="{{ Auth::id() }}">
                        <input type="hidden" name="cart_id_payment" value="{{ $cart_id_payment }}">
                        <input type="hidden" name="total_price_payment" value="{{ $total_price_final }}">
                        <input type="hidden" name="product_id" value="{{ $product_get_id }}">
                        <input type="hidden" name="product_name" value="{{ $product_name }}">
                        <input type="hidden" name="product_quantity" value="{{ $product_quantity }}">
                        <input type="hidden" name="product_image" value="{{ $product_image }}">
                        <input type="hidden" name="product_price" value="{{ $product_price }}">

                        <!-- Total Price -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">Tổng tiền:</h5>
                            <h5 class="mb-0 text-primary">{{ number_format($total_price_final, 0, ',', '.') }} ₫</h5>
                        </div>

                        <!-- Payment Methods -->
                        <div class="mb-4">
                            <p class="fw-bold mb-2">Phương thức thanh toán:</p>

                            <!-- COD -->
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod"
                                    value="cod" checked>
                                <label class="form-check-label" for="cod">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-money-bill-wave me-2 text-success"></i>
                                        Thanh toán khi nhận hàng
                                    </div>
                                </label>
                            </div>

                            <!-- VNPAY -->
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="vnpay"
                                    value="vnpay">
                                <label class="form-check-label" for="vnpay">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-credit-card me-2 text-primary"></i>
                                        VNPAY
                                    </div>
                                </label>
                            </div>

                            <!-- ZaloPay -->
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="zalopay"
                                    value="zalopay">
                                <label class="form-check-label" for="zalopay">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-wallet me-2 text-info"></i>
                                        ZALOPAY
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-shopping-cart me-2"></i>Đặt hàng
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for form submission chọn các phương thức thanh toán mua ngay -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle form submission based on payment method
        document.getElementById("paymentForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent default form submission

            const selectedPaymentMethod = document.querySelector('input[name="payment_method"]:checked')
                .value;
            const form = event.target;

            // Set the action based on selected payment method
            switch (selectedPaymentMethod) {
                case "vnpay":
                    form.action = "{{ route('vnpay.payment') }}";
                    break;
                case "zalopay":
                    form.action = "{{ route('zalo.payment') }}";
                    break;
                default: // COD
                    form.action = "{{ route('pptt.payment.cod') }}";
                    break;
            }

            form.submit(); // Submit the form with the appropriate action
        });

        // // Handle coupon button click (you can implement coupon validation here)
        // document.getElementById("apply-coupon").addEventListener("click", function() {
        //     const couponCode = document.getElementById("cart_discount").value;
        //     if (couponCode.trim() === "") {
        //         alert("Vui lòng nhập mã giảm giá");
        //         return;
        //     }

        //     // You can add AJAX call to validate the coupon code
        //     // For now, just show an alert
        //     alert("Áp dụng mã giảm giá: " + couponCode);
        // });
    });
</script>
