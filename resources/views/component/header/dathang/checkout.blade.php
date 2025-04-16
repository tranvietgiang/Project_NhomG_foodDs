<!-- link md bootstrap(thư viên của bootstrap) -->
<link rel="stylesheet" href="{{ asset('component/css/mdb.min.css') }}">
<div class=""><a href="{{ url()->previous() }}">Quay lại</a></div>
<section>
    <!-- Thông tin đơn hàng -->
    <div class="">
        @if (session('address_null'))
            <div class="alert alert-warning text-center">{{ session('address_null') }}, <a
                    href="{{ url('/information-client') }}">tại đây</div>
        @endif
        <h3>Thông tin đơn hàng</h3>
        @foreach ($cart as $item)
            <div class="card mb-3 p-3 d-flex flex-row align-items-center" style="gap: 20px;">
                <div>
                    <strong>
                        <img src="{{ asset('component/image-product/' . $item->product_image) }}" alt="Sản phẩm"
                            class="img-thumbnail" width="150" height="150">
                    </strong>
                </div><br>
                <div>
                    <h6 class="mb-1">Tên: {{ $item->product_name }}</h6>
                    <p>
                        Số lượng: {{ $item->quantity_sp }}
                    </p>
                    <p class="mb-1">Tiền: <strong>{{ $item->total_price }}</strong></p>
                </div>
            </div>

            @php
                /* lấy ra id cart để lưu vào bill*/
                $cart_id_payment = $item->cart_id;
                $product_get_id = $item->product_id;
                $total_price_final = $item->total_price * $item->quantity_sp;
            @endphp
        @endforeach

        <div class="mb-3">
            <label for="cart_discount" class="form-label">Phiếu giảm giá</label>
            <input name="cart_discount" id="cart_discount" type="text" class="form-control"
                placeholder="Nhập mã giảm giá">
        </div>

        <!-- handle total price -->
        <div class="fs-5">
            Tổng tiền: <strong>{{ $total_price_final }}</strong>
        </div>
    </div>


    <form id="paymentForm" method="POST">
        @csrf
        <input type="hidden" name="user_id_payment" value="{{ Auth::id() }}">
        <input type="hidden" name="cart_id_payment" value="{{ $cart_id_payment }}">
        <input type="hidden" name="total_price_payment" value="{{ $total_price_final }}">
        <input type="hidden" name="product_id" value="{{ $product_id }}">

        <!-- Radio chọn phương thức -->
        <div>
            <input type="radio" name="payment_method" value="cod" id="cod" checked>
            <label for="cod">Thanh toán khi nhận hàng</label>
        </div>
        <div>
            <input type="radio" name="payment_method" value="vnpay" id="vnpay">
            <label for="vnpay">VNPAY</label>
        </div>

        <!-- Nút đặt hàng -->
        <button type="submit" class="btn btn-success">Đặt hàng</button>
    </form>

</section>
<script>
    /** chức năng của hàm này là sẽ đưa đến route khi mà client chọn phương thức thanh toán mà không
     * cần phải biết route đó là phương thức gì.
     */
    document.getElementById("paymentForm").addEventListener("submit", (Element) => {
        Element.preventDefault(); // ngăn không cho gửi form default

        const selected = document.querySelector(
            'input[name="payment_method"]:checked'
        ).value;

        const form = Element.target;

        if (selected == "vnpay") {
            form.action = "{{ route('vnpay.payment') }}";
        } else {
            form.action = "{{ route('pptt.payment.cod') }}";
        }




        form.submit(); // Tiến hành submit theo action mới
    });
</script>
