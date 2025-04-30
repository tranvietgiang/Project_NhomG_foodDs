<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Giỏ Hàng</h1>
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Tên Sản Phẩm</th>
                    <th>Số Lượng</th>
                    <th>Giá</th>
                    <th>Tổng</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>


                @foreach ($cartItems as $item)
                    <tr>
                        <td><img src="{{ asset('images/' . $item->product_image) }}" alt=""></td>
                        <td>{{ $item->product_name }}</td>
                        <td>
                            <form action="{{ route('cart.update', $item->product_id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('PUT') <!-- Xác định yêu cầu PUT cho cập nhật -->
                                <input type="number" name="quantity" value="{{ $item->quantity_sp }}" min="1"
                                    class="form-control" onchange="this.form.submit()" />
                            </form>
                        </td>
                        <td>{{ number_format($item->product_price, 0, ',', '.') }} VND</td>
                        <td>
                            {{ number_format($item->product_price * $item->quantity_sp, 0, ',', '.') }} VND
                        </td>
                        <td>
                            <form action="{{ route('cart.removeCart', $item->product_id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE') <!-- Yêu cầu DELETE cho xóa sản phẩm -->
                                <button class="btn btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="total">
            <h3>Tổng Tiền: {{ number_format($totalAmount, 0, ',', '.') }} VND</h3>
        </div>

        <!-- tùy chọn thanh toán -->
        <button class="btn btn-primary">Chọn phương thức thanh toán</button>
        <div class="mt-2">
            <form id="select_pay" action="{{ route('momo_payment') }}" method="post">
                @csrf
                {{-- <input type="hidden" name="totalAmount" value="{{ $totalAmount }}">
                <button class="momo btn btn-primary">Thanh toán bằng momo </button> --}}
                <!-- Radio chọn phương thức -->

                <!-- thanh toán khi nhận hàng -->
                <div>
                    <input type="radio" name="payment_method" value="cod" id="cod" checked>
                    <label for="cod">Thanh toán khi nhận hàng</label>
                </div>

                <!-- thanh toán vnpay -->
                <div>
                    <input type="radio" name="payment_method" value="vnpay" id="vnpay">
                    <label for="vnpay">VNPay</label>
                </div>

                <!-- thanh toán zalopay -->
                <div>
                    <input type="radio" name="payment_method" value="zalopay" id="zalopay">
                    <label for="zalopay">ZaloPay</label>
                </div>

                <!-- thanh toán momo -->
                <div>
                    <input type="hidden" name="totalAmount" value="{{ $totalAmount }}">
                    <input type="radio" name="payment_method" value="momo" id="momo">
                    <label for="momo">momo</label>
                </div>
                <div>
                    <button class="btn btn-outline-success" type="submit">Thanh toán</button>
                </div>
            </form>
        </div>


    </div>
    <script>
        document.getElementById("select_pay").addEventListener("submit", function(e) {
            e.preventDefault();

            const choose_pay = document.querySelector(
                "input[name='payment_method']:checked"
            ).value;

            console.log(choose_pay);
            const action = e.target;
            if (choose_pay == 'zalopay') {
                action.form = "";
            } else if (choose_pay == 'vnpay') {
                action.form = "";
            } else if (choose_pay == 'momo') {
                action.form = "";
            } else {
                action.form = "";
            }

            form.submit();
        })
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
