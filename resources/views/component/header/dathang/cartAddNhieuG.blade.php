<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Giỏ Hàng</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<style>
    .cart-item img {
        width: 80px;
        height: 80px;
        object-fit: cover;
    }

    .cart-item .quantity-control {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .cart-item .btn-outline-secondary {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    .cart-item .btn-outline-danger {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    .subtotal-section {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
    }
</style>
</head>

<body>
    <div class="container mt-5">
        <!-- Tiêu đề -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <a href="{{ route('website-main') }}" class=" text-decoration-none btn btn-outline-success "><i
                        class="bi bi-arrow-left"></i> TIẾP TỤC
                    MUA SẮM</a>
                <h4 class="mt-2">Loại ({{ $amount_cart_header ?? 0 }} sản phẩm)</h4>
            </div>
            <button id="delete_goods_all" class="btn btn-outline-danger"><i class="bi bi-trash"></i> Xóa tất cả</button>
        </div>

        <!-- Danh sách sản phẩm -->
        @php
            $tamTinh = 0;
        @endphp
        @foreach ($cartMany as $cart)
            <div class="cart-item d-flex align-items-center border-bottom py-3">
                <input type="checkbox" class="me-3">
                <img width="300" height="300" src="{{ asset('component/image-product/' . $cart->image) }}"
                    alt="" class="me-3 object-fit-cover">
                <div class="flex-grow-1">
                    <h5>{{ $cart->product_name }}</h5>
                    <p>Khối lượng (g): 250g</p>
                    <p>Đóng gói: Túi</p>
                </div>

                <div class="text-end">
                    <h5>{{ number_format($cart->product_price) }} đ</h5>
                    <div class="quantity-control" data-item-id="{{ $cart->product_id }}">
                        <button class="btn
                        btn-outline-secondary quantity_desc">-</button>
                        <span class="quantity_goods">{{ $cart->quantity_sp }}</span>
                        <button class="btn btn-outline-secondary quantity_asc">+</button>
                        <button class="btn btn-outline-danger ms-2 remove-goods"><i class="bi bi-trash"></i></button>
                        <button class="btn btn-outline-success ms-2"><i class="bi bi-heart"></i></button>
                    </div>
                </div>
            </div>
            @php
                $price = $cart->product_price * $cart->quantity_sp;
                $tamTinh += $price;
            @endphp
        @endforeach
        <!-- Tổng tiền -->
        <div class="subtotal-section mt-4 text-end">
            <h5>Thông tin đơn hàng</h5>
            <p><input type="text" value="" id="coupon_price" placeholder="nhập mã giảm giá(nếu có)"
                    name="coupon_price"></p>
            @php
                $price_final = $tamTinh - 0;
            @endphp
            <p id="totalAmount">Tạm tính: {{ number_format($price_final) ?? 0 }} đ</p>
            <p class="text-danger">
                @if (session('address_exists'))
                    {{ session('address_exists') }} <a href="{{ url('/information-client') }}">điền</a>
                @endif
            </p>
            <button class="btn btn-success">XÁC NHẬN GIỎ HÀNG</button>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $('.quantity-control').each(function() {
            const $amountItem = $(this);
            const $btnAsc = $amountItem.find('.quantity_asc');
            const $btnDesc = $amountItem.find('.quantity_desc');
            const $quantityElem = $amountItem.find('.quantity_goods');
            const itemId = $amountItem.data('item-id');

            // xóa
            const remove_goods = $amountItem.find('.remove-goods');
            /* xóa all item của client*/


            function updateQuantity(newQty) {
                $.ajax({
                    url: "{{ route('cartMany.amount.item') }}",
                    type: "POST",
                    data: {
                        item_id: itemId,
                        quantity: newQty,
                        _token: '{{ csrf_token() }}' // Đảm bảo CSRF token có trong request
                    },


                    success: function(value) {
                        if (value.success) {
                            // Cập nhật lại số lượng trên giao diện
                            $quantityElem.text(newQty);
                            $('#totalAmount').text(`Tạm tính ${value.totalAmount}`);
                            console.log(value.totalAmount)
                            // location.reload();
                        }
                    }
                });
            }

            $btnAsc.on('click', function() {
                let current = parseInt($quantityElem.text());
                let newQty = current + 1;
                $quantityElem.text(newQty);
                updateQuantity(newQty);
            });

            $btnDesc.on('click', function() {
                let current = parseInt($quantityElem.text());
                if (current > 1) {
                    let newQty = current - 1;
                    $quantityElem.text(newQty);
                    updateQuantity(newQty);
                }
            });



            remove_goods.on('click', function() {
                const itemId = $amountItem.data('item-id');

                $.ajax({
                    url: "{{ route('remove.cartMany.giang') }}",
                    type: "GET",
                    data: {
                        goods_remove: itemId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Ví dụ: làm mới lại trang hoặc cập nhật DOM
                        location.reload();
                    },

                });
            });

        });

        const remove_goods_all = document.getElementById('delete_goods_all');
        console.log(remove_goods_all)



        $('#delete_goods_all').on('click', function() {

            if (confirm('Bạn có chắc muốn xóa tất cả sản phẩm?')) {
                $.ajax({
                    url: "{{ route('goods.cartManyAll') }}",
                    type: "get",
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        location.reload();
                    }
                })
            }
        })
    </script>
