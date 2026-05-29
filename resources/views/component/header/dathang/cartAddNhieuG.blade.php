<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Giỏ hàng | FoodDS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('component/css/foodds.css') }}">
    <style>
        .cart-page {
            padding: 24px 0 40px;
        }

        .cart-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 340px;
            gap: 18px;
            align-items: start;
        }

        .cart-toolbar,
        .cart-row,
        .bill-line {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .cart-toolbar {
            justify-content: space-between;
            margin-bottom: 14px;
            flex-wrap: wrap;
        }

        .cart-list {
            display: grid;
            gap: 12px;
        }

        .cart-row {
            border: 1px solid var(--fd-border);
            border-radius: 16px;
            background: #fff;
            padding: 12px;
            transition: 0.2s ease;
        }

        .cart-row:hover {
            border-color: #86efac;
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
        }

        .cart-check {
            width: 20px;
            height: 20px;
            accent-color: var(--fd-green);
            flex: 0 0 auto;
        }

        .cart-img {
            width: 96px;
            height: 96px;
            border-radius: 14px;
            object-fit: cover;
            background: #f1f5f9;
            flex: 0 0 auto;
        }

        .cart-info {
            min-width: 0;
            flex: 1;
        }

        .cart-name {
            margin: 0 0 6px;
            font-size: 17px;
            font-weight: 900;
            color: var(--fd-ink);
        }

        .cart-meta {
            margin: 0;
            color: var(--fd-muted);
            font-size: 13px;
        }

        .cart-side {
            display: grid;
            justify-items: end;
            gap: 10px;
        }

        .cart-price {
            color: var(--fd-red);
            font-size: 18px;
            font-weight: 900;
        }

        .qty-box {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid var(--fd-border);
            border-radius: 999px;
            padding: 5px;
        }

        .qty-box button,
        .cart-small-btn {
            border: 0;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #f1f5f9;
            color: var(--fd-ink);
        }

        .cart-small-btn.danger {
            color: var(--fd-red);
        }

        .cart-small-btn.heart {
            color: var(--fd-green-dark);
        }

        .quantity_goods {
            min-width: 26px;
            text-align: center;
            font-weight: 900;
        }

        .summary-panel {
            position: sticky;
            top: 16px;
        }

        .bill-line {
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px dashed var(--fd-border);
        }

        .empty-cart {
            text-align: center;
            padding: 56px 20px;
        }

        .empty-cart i {
            font-size: 54px;
            color: var(--fd-green);
        }

        #alert-add-cart,
        #alertMessage {
            position: fixed;
            left: 50%;
            top: 22px;
            transform: translateX(-50%);
            z-index: 9999;
            width: min(420px, calc(100% - 24px));
            border-radius: 14px;
            padding: 12px 14px;
            box-shadow: var(--fd-shadow);
            font-weight: 800;
        }

        #alertMessage {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        @media (max-width: 860px) {
            .cart-layout {
                grid-template-columns: 1fr;
            }

            .summary-panel {
                position: static;
            }

            .cart-row {
                align-items: flex-start;
            }

            .cart-side {
                justify-items: start;
                width: 100%;
            }
        }

        @media (max-width: 560px) {
            .cart-row {
                display: grid;
                grid-template-columns: auto 82px minmax(0, 1fr);
            }

            .cart-img {
                width: 82px;
                height: 82px;
            }

            .cart-side {
                grid-column: 2 / -1;
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <main class="cart-page">
        <div class="fd-container">
            <div class="fd-section-head">
                <div>
                    <p class="fd-eyebrow">FoodDS Cart</p>
                    <h1 class="fd-title">Giỏ hàng của bạn</h1>
                    <p class="fd-muted">Chọn món muốn thanh toán, chỉnh số lượng rồi xác nhận đơn hàng.</p>
                </div>
                <div class="fd-actions">
                    <a href="{{ route('website-main') }}" class="fd-btn fd-btn-outline"><i class="bi bi-arrow-left"></i> Tiếp tục mua</a>
                    <a href="{{ route('goods.heart.giang') }}" class="fd-icon-btn fd-btn-outline" title="Sản phẩm yêu thích"><i class="bi bi-heart"></i></a>
                </div>
            </div>

            @if (session('success'))
                <div id="alertMessage">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="fd-alert warning">{{ session('error') }}</div>
            @endif

            <div class="cart-layout">
                <section class="fd-panel">
                    <div class="cart-toolbar">
                        <label class="fd-chip" for="all-checked">
                            <input type="checkbox" id="all-checked" class="check-tamTinh-all" style="accent-color: var(--fd-green)">
                            Chọn tất cả
                        </label>
                        <button id="delete_goods_all" class="fd-btn fd-btn-outline" type="button">
                            <i class="bi bi-trash3"></i> Xóa tất cả
                        </button>
                    </div>

                    @if ($cartMany->isEmpty())
                        <div class="empty-cart">
                            <i class="bi bi-bag-x"></i>
                            <h2 class="fd-title" style="font-size:24px;margin-top:12px">Giỏ hàng đang trống</h2>
                            <p class="fd-muted">Thêm vài món ngon rồi quay lại thanh toán nha.</p>
                            <a href="{{ route('website-main') }}" class="fd-btn">Đi mua hàng</a>
                        </div>
                    @else
                        <div class="cart-list">
                            @foreach ($cartMany as $cart)
                                @php
                                    $encryptedProductId = encrypt($cart->product_id);
                                @endphp
                                <article class="cart-row">
                                    <input data-client-image="{{ $cart->image }}" data-carted-id="{{ $cart->cart_id }}"
                                        data-product-id="{{ $encryptedProductId }}" data-client-amount="{{ $cart->quantity_sp }}"
                                        data-client-price="{{ $cart->total_price }}" type="checkbox" class="cart-check check-tamTinh">

                                    <img class="cart-img" src="{{ asset('component/image-product/' . $cart->image) }}" alt="{{ $cart->product_name }}">

                                    <div class="cart-info">
                                        <h2 class="cart-name">{{ $cart->product_name }}</h2>
                                        <p class="cart-meta">Đóng gói: Túi • Khối lượng: 250g</p>
                                        <p class="cart-meta">Mã giỏ: #{{ $cart->cart_id }}</p>
                                    </div>

                                    <div class="cart-side">
                                        <div class="cart-price">{{ number_format($cart->product_price) }} đ</div>
                                        <div class="qty-box quantity-control" data-item-id="{{ $cart->product_id }}">
                                            <button type="button" class="quantity_desc" title="Giảm"><i class="bi bi-dash"></i></button>
                                            <span class="quantity_goods">{{ $cart->quantity_sp ?? 0 }}</span>
                                            <button type="button" class="quantity_asc" title="Tăng"><i class="bi bi-plus"></i></button>
                                            <button type="button" class="cart-small-btn danger remove-goods" title="Xóa"><i class="bi bi-trash3"></i></button>
                                            <button type="button" data-goods-id="{{ $cart->product_id }}" data-goods-price="{{ $cart->total_price }}"
                                                class="cart-small-btn heart heart-choose" title="Yêu thích"><i class="bi bi-heart"></i></button>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </section>

                <aside class="fd-panel summary-panel">
                    @php
                        $cartTotal = $cartMany->sum(fn($cart) => $cart->product_price * $cart->quantity_sp);
                    @endphp
                    <h2 class="fd-title" style="font-size:24px">Thông tin đơn hàng</h2>
                    <div class="bill-line">
                        <span>Sản phẩm trong giỏ</span>
                        <strong>{{ $amount_cart_header ?? 0 }}</strong>
                    </div>
                    <div class="bill-line">
                        <span>Tổng tiền giỏ hàng</span>
                        <strong id="totalAmount">{{ number_format($cartTotal) }} đ</strong>
                    </div>
                    <div class="bill-line">
                        <span>Đang chọn</span>
                        <strong id="totalItemSelect">0 đ</strong>
                    </div>

                    @if (session('address_exists'))
                        <p class="fd-alert warning" style="margin-top:12px">
                            {{ session('address_exists') }}
                            <a href="{{ url('/information-client') }}" style="color:#9a3412;font-weight:900">Cập nhật địa chỉ</a>
                        </p>
                    @endif

                    <form id="confirm-payment" method="post" style="margin-top:14px">
                        @csrf
                        <button type="submit" class="fd-btn btn-payment" style="width:100%" disabled>
                            <i class="bi bi-receipt"></i> Xác nhận giỏ hàng
                        </button>
                    </form>
                </aside>
            </div>
        </div>
    </main>

    <div id="alert-add-cart" class="fd-alert success d-none"></div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        const csrfToken = "{{ csrf_token() }}";

        function formatVnd(value) {
            return new Intl.NumberFormat('vi-VN').format(value) + ' đ';
        }

        function refreshSelectedTotal() {
            let total = 0;
            $('.check-tamTinh:checked').each(function() {
                total += Number($(this).data('client-amount')) * Number($(this).data('client-price'));
            });

            $('#totalItemSelect').text(formatVnd(total));
            $('.btn-payment').prop('disabled', total <= 0);
        }

        $('.check-tamTinh').on('change', refreshSelectedTotal);

        $('#all-checked').on('change', function() {
            $('.check-tamTinh').prop('checked', $(this).is(':checked'));
            refreshSelectedTotal();
        });

        $('#confirm-payment').on('submit', function(event) {
            event.preventDefault();

            const items = [];
            $('.check-tamTinh:checked').each(function() {
                items.push({
                    cart_id: $(this).data('carted-id'),
                    product_id: $(this).data('product-id'),
                    amount: $(this).data('client-amount'),
                    price: $(this).data('client-price'),
                    image: $(this).data('client-image'),
                });
            });

            if (!items.length) {
                showCartAlert('Bạn hãy chọn ít nhất một sản phẩm để thanh toán.', 'warning');
                return;
            }

            $.post("/show/url/cartMany", {
                arrItems: JSON.stringify(items),
                _token: csrfToken
            }).done(function(response) {
                window.location.href = response.redirect_url;
            }).fail(function() {
                showCartAlert('Chưa tạo được trang thanh toán, vui lòng thử lại.', 'warning');
            });
        });

        $('.quantity-control').each(function() {
            const $control = $(this);
            const $quantity = $control.find('.quantity_goods');
            const $checkbox = $control.closest('.cart-row').find('.check-tamTinh');
            const itemId = $control.data('item-id');

            function updateQuantity(newQty) {
                $.post("{{ route('cartMany.amount.item') }}", {
                    item_id: itemId,
                    quantity: newQty,
                    _token: csrfToken
                }).done(function(response) {
                    if (response.success) {
                        $quantity.text(newQty);
                        $checkbox.data('client-amount', newQty);
                        $('#totalAmount').text(response.totalAmount + ' đ');
                        refreshSelectedTotal();
                    }
                });
            }

            $control.find('.quantity_asc').on('click', function() {
                updateQuantity(parseInt($quantity.text(), 10) + 1);
            });

            $control.find('.quantity_desc').on('click', function() {
                const current = parseInt($quantity.text(), 10);
                if (current > 1) {
                    updateQuantity(current - 1);
                }
            });

            $control.find('.remove-goods').on('click', function() {
                $.get("{{ route('remove.cartMany.giang') }}", {
                    goods_remove: itemId,
                    _token: csrfToken
                }).done(function() {
                    location.reload();
                });
            });

            $control.find('.heart-choose').on('click', function() {
                $.post("{{ route('heart.list.client') }}", {
                    heartID: $(this).data('goods-id'),
                    priceHeart: $(this).data('goods-price'),
                    _token: csrfToken
                }).done(function(response) {
                    showCartAlert(response.status === 'error' ? 'Không thêm được sản phẩm yêu thích.' : 'Đã thêm vào danh sách yêu thích.', response.status === 'error' ? 'warning' : 'success');
                });
            });
        });

        $('#delete_goods_all').on('click', function() {
            if (!confirm('Bạn có chắc muốn xóa tất cả sản phẩm khỏi giỏ hàng?')) {
                return;
            }

            $.get("{{ route('goods.cartManyAll') }}", {
                _token: csrfToken
            }).done(function() {
                location.reload();
            });
        });

        function showCartAlert(message, type = 'success') {
            const $alert = $('#alert-add-cart');
            $alert.text(message)
                .toggleClass('success', type === 'success')
                .toggleClass('warning', type !== 'success')
                .removeClass('d-none');

            setTimeout(function() {
                $alert.addClass('d-none');
            }, 2600);
        }

        setTimeout(function() {
            $('#alertMessage').fadeOut(250);
        }, 2200);
    </script>
</body>

</html>
