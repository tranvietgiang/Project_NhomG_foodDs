<!-- hiển thị giỏ hàng của khách hàng  -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Giỏ Hàng</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
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

    #alert-add-cart {
        position: fixed;
        /* Cố định vị trí trên màn hình */
        top: 50%;
        /* Đặt ở giữa theo chiều dọc */
        left: 50%;
        /* Đặt ở giữa theo chiều ngang */
        transform: translate(-50%, -50%);
        /* Dịch chuyển để căn giữa chính xác */
        z-index: 1050;
        /* Đảm bảo thông báo nằm trên các phần tử khác */
        width: 90%;
        /* Chiều rộng linh hoạt */
        max-width: 500px;
        /* Giới hạn chiều rộng tối đa */
        padding: 15px;
        /* Khoảng cách bên trong */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        /* Thêm bóng để nổi bật */
        opacity: 0;
        /* Ban đầu ẩn (dùng cho hiệu ứng) */
        transition: opacity 0.3s ease-in-out;
        /* Hiệu ứng mượt mà */
    }

    /* Khi thông báo hiển thị */
    #alert-add-cart:not(.d-none) {
        opacity: 1;
        /* Hiện thông báo */
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
                <!-- qua danh sách yêu thích -->
                <a class="btn btn-outline-danger" href="{{ route('goods.heart.giang') }}">List Heart</a>

                <div>
                    <input type="checkbox" id="all-checked" class="me-3 check-tamTinh-all">
                    <label for="all-checked">All</label>
                </div>
                <h4 class="mt-2">Loại ({{ $amount_cart_header ?? 0 }} sản phẩm)</h4>
            </div>
            <button id="delete_goods_all" class="btn btn-outline-danger"><i class="bi bi-trash"></i> Xóa tất cả</button>
        </div>

        <!-- Danh sách sản phẩm -->
        @php
            //
            $tamTinh = 0;
        @endphp
        <!-- mã hóa id sản phẩm trách bị phá -->
        @foreach ($cartMany as $cart)
            @php
                $encryptedProductId = encrypt($cart->product_id);
            @endphp
            <div class="cart-item d-flex align-items-center border-bottom py-3">
                <!-- checked -->
                <input data-client-image="{{ $cart->image }}" data-carted-id="{{ $cart->cart_id }}"
                    data-product-id="{{ $encryptedProductId }}" data-client-amount="{{ $cart->quantity_sp }}"
                    data-client-price="{{ $cart->total_price }}" type="checkbox" class="me-3 check-tamTinh">

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
                        <span class="quantity_goods">{{ $cart->quantity_sp ?? 0 }}</span>
                        <button class="btn btn-outline-secondary quantity_asc">+</button>
                        <button class="btn btn-outline-danger ms-2 remove-goods"><i class="bi bi-trash"></i></button>

                        <!-- heart git heart -->
                        <button data-goods-id="{{ $cart->product_id }}" data-goods-price="{{ $cart->total_price }}"
                            class="btn btn-outline-success ms-2 heart-choose"><i class="bi bi-heart"></i>
                        </button>
                    </div>
                </div>
            </div>
            @php
                $price = $cart->product_price * $cart->quantity_sp;
                $tamTinh += $price;

                $cartSl = $cart->quantity_sp;
                $cartPrice = $cart->total_price;
            @endphp
        @endforeach
        <!-- Tổng tiền khách hàng phải chọn sản phẩm mới xác nhận được -->
        <div class="subtotal-section mt-4 text-end">
            <h5>Thông tin đơn hàng</h5>
            @php
                $price_final = $tamTinh;
            @endphp

            <p id="totalItemSelect">Tiền đơn hàng bạn chọn(?): 0 đ</p>

            <p id="totalAmount">Tổng tiền đơn hàng: {{ number_format($price_final) ?? 0 }} đ</p>
            <p class="text-danger">
                @if (session('address_exists'))
                    {{ session('address_exists') }} <a href="{{ url('/information-client') }}">điền</a>
                @endif
            </p>

            <!-- form confirm payment -->
            <form id="confirm-payment" style="padding: 0; margin: 0;" method="get">
                {{-- @csrf --}}
                <button type="submit" class="btn btn-secondary btn-payment">XÁC
                    NHẬN GIỎ HÀNG
                </button>
            </form>
        </div>
    </div>
    <!-- git -->
    <div></div>


    @if (session('success'))
        <div id ="alertMessage" class = "alert alert-success" role = "alert">
            {{ session('success') }}
        </div>
    @endif

    <div id="alert-add-cart" class="alert alert-success d-none" role="alert"></div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        /* handle button payment*/
        $(document).ready(function() {
            const $btn = $('.btn-payment');
            const $form = $('#confirm-payment');
            const $all_checked = $('#all-checked');


            /* handle kiểm tra khách hàng có chọn sản phẩm chưa*/
            $('.check-tamTinh').on('change', function() {
                if ($('.check-tamTinh:checked').length > 0) {
                    $btn.addClass("btn-success").removeClass("btn-secondary");
                    $btn.prop('disabled', false);


                    let total = 0;
                    $('.check-tamTinh:checked').each(function() {
                        const amount = Number($(this).data('client-amount'));
                        const price = Number($(this).data('client-price'));
                        total += amount * price;
                    });

                    $.ajax({
                        url: "/get/money/select",
                        type: "POST",
                        data: {
                            amount: 1,
                            priceClient: total,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            $('#totalItemSelect').text(
                                `Tiền đơn hàng bạn chọn: ${response.totalItemSelect} đ`
                            );
                        }
                    });

                } else {
                    $btn.removeClass("btn-success").addClass("btn-secondary");
                    $btn.prop('disabled', true);
                    $('#totalItemSelect').text(
                        `Tiền đơn hàng bạn chọn: 0 đ`);
                }
            });

            /* qua trang bill*/
            $form.on('submit', function(e) {
                e.preventDefault(); // Ngăn submit mặc định

                let items = [];
                $('.check-tamTinh:checked').each(function() {
                    items.push({
                        cart_id: $(this).data('carted-id'),
                        product_id: $(this).data('product-id'),
                        amount: $(this).data('client-amount'),
                        price: $(this).data('client-price'),
                        image: $(this).data('client-image'),
                    });
                });

                $.ajax({
                    url: "/show/url/cartMany",
                    type: "post",
                    data: {
                        arrItems: JSON.stringify(items),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        window.location.href = response.redirect_url;
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });

        });




        /*xử lý tăng giảm*/
        $('.quantity-control').each(function() {
            const $amountItem = $(this);
            const $btnAsc = $amountItem.find('.quantity_asc');
            const $btnDesc = $amountItem.find('.quantity_desc');
            const $quantityElem = $amountItem.find('.quantity_goods');
            const itemId = $amountItem.data('item-id');



            function updateQuantity(newQty) {
                $.ajax({
                    url: "{{ route('cartMany.amount.item') }}",
                    type: "POST",
                    data: {
                        item_id: itemId,
                        quantity: newQty,
                        _token: '{{ csrf_token() }}'
                    },


                    success: function(value) {
                        if (value.success) {
                            // Cập nhật lại số lượng trên giao diện
                            $quantityElem.text(newQty);
                            $('#totalAmount').text(`Tạm tính ${value.totalAmount}`);
                            console.log(value.totalAmount)
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


            // xóa
            const remove_goods = $amountItem.find('.remove-goods');

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
                        location.reload();
                    },

                });
            });

            // heart git
            const heart_choose = $amountItem.find('.heart-choose');
            heart_choose.on('click', function() {
                const idProduct = $(this).data('goods-id');
                const price = $(this).data('goods-price');
                console.log([idProduct, price]);

                $.ajax({
                    url: "{{ route('heart.list.client') }}",
                    type: "POST",
                    data: {
                        heartID: idProduct,
                        priceHeart: price,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('Thành công:', response);
                        showCartAlert("Thêm sản phâm yêu thích thành công!");
                    },
                });

            });


            // đóng
        });

        /* xóa all item của client*/
        const remove_goods_all = document.getElementById('delete_goods_all');

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

        /* hiển thị alert client đã thêm vào dánh yêu thích*/
        document.addEventListener("DOMContentLoaded", function() {
            var alertMessage = document.getElementById('alertMessage');
            if (alertMessage) {
                setTimeout(function() {
                    alertMessage.style.display = 'none';
                }, 2000); // 2000 milliseconds = 2 seconds
            }
        });


        // Hàm hiển thị thông báo
        function showCartAlert(message) {
            var alertMessage = $('#alert-add-cart');
            alertMessage.text(message); // Đặt nội dung thông báo
            alertMessage.removeClass('d-none'); // Hiện thông báo
            setTimeout(function() {
                alertMessage.addClass('d-none'); // Ẩn sau 8 giây
            }, 3000);
        }
    </script>
