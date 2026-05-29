<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $cart[0]->product_name ?? 'Chi tiết sản phẩm' }} - FoodDS</title>
    <link rel="stylesheet" href="{{ asset('component/css/foodds.css') }}">
    <link rel="stylesheet" href="{{ asset('component/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <main class="fd-container fd-section">
        <a href="{{ route('website-main') }}" class="fd-btn fd-btn-outline" style="margin-bottom:16px">
            <i class="bi bi-arrow-left"></i>
            Tiếp tục mua sắm
        </a>

        <section class="fd-panel" style="padding:0;overflow:hidden">
            <div class="fd-detail">
                <div class="fd-detail-image">
                    <img src="{{ asset('component/image-product/' . $cart[0]->product_image) }}"
                        alt="{{ $cart[0]->product_name }}" id="mainImage">
                </div>

                <div class="fd-detail-info">
                    <p class="fd-eyebrow">Chi tiết sản phẩm</p>
                    <h1 class="fd-title">{{ $cart[0]->product_name }}</h1>

                    <div style="display:flex;gap:12px;flex-wrap:wrap;margin:14px 0">
                        <span class="fd-stars">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        </span>
                        <span class="fd-muted">{{ $quantity_item_review ?? 0 }} đánh giá 5 sao</span>
                        <span class="fd-muted"><i class="bi bi-bag-check"></i> Đã bán {{ $goods_sold ?? 0 }}</span>
                    </div>

                    <div style="background:#fef2f2;border-radius:16px;padding:16px;margin:18px 0">
                        <div class="fd-price" style="font-size:32px">{{ number_format($cart[0]->product_price) }}đ</div>
                        <div class="fd-muted">Giá đã bao gồm ưu đãi tại FoodDS.</div>
                    </div>

                    <div class="fd-info-boxes">
                        <div class="fd-info-box">
                            <div class="fd-muted">Tồn kho</div>
                            <strong id="amount_item" style="font-size:22px">{{ $quantity_store ?? 0 }}</strong>
                        </div>
                        <div class="fd-info-box">
                            <div class="fd-muted">Trạng thái</div>
                            <strong style="color:{{ ($quantity_store ?? 0) > 0 ? '#15803d' : '#dc2626' }}">
                                {{ ($quantity_store ?? 0) > 0 ? 'Còn hàng' : 'Hết hàng' }}
                            </strong>
                        </div>
                    </div>

                    <form id="form_immediately"
                        action="{{ url('/cart/show_checkout', ['product_id' => $cart[0]->product_id]) }}" method="get">
                        @csrf
                        <label style="font-weight:800;margin-bottom:8px;display:block">Số lượng</label>
                        <div class="fd-qty">
                            <button type="button" class="minus">-</button>
                            <input name="cart_quantity" type="number" value="1" min="1" class="input-qty">
                            <button type="button" class="plus" style="background:#16a34a;color:#fff">+</button>
                        </div>

                        <div class="fd-detail-actions">
                            <button id="button_pay" class="fd-btn" type="submit">
                                <i class="bi bi-bag-check-fill"></i>
                                Mua ngay
                            </button>
                            <button class="fd-btn fd-btn-outline" type="submit" form="form_add_to_cart">
                                <i class="bi bi-cart-plus"></i>
                                Thêm vào giỏ
                            </button>
                        </div>
                    </form>

                    <form id="form_add_to_cart" action="{{ route('cart.add') }}" method="POST" style="display:none">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $cart[0]->product_id }}">
                        <input type="hidden" name="product_price" value="{{ $cart[0]->product_price }}">
                        <input type="hidden" name="product_image" value="{{ $cart[0]->product_image }}">
                        <input type="hidden" name="quantity_sp" id="cartQuantityHidden" value="1">
                    </form>

                    <form action="{{ route('addspyeuthich') }}" method="POST" style="margin-top:10px">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $cart[0]->product_id }}">
                        <button type="submit" class="fd-btn fd-btn-outline" style="width:100%;color:#dc2626">
                            <i class="bi bi-heart"></i>
                            Thêm vào yêu thích
                        </button>
                    </form>
                </div>
            </div>

            <div style="border-top:1px solid var(--fd-border);padding:24px">
                <h2 class="fd-title" style="font-size:24px">Mô tả sản phẩm</h2>
                <p style="line-height:1.8;color:#475569">
                    {{ $cart[0]->description ?: 'Sản phẩm đang được cập nhật mô tả chi tiết.' }}
                </p>
            </div>
        </section>

        <section class="fd-panel" style="margin-top:20px">
            <h2 class="fd-title" style="font-size:24px;margin-bottom:16px">Đánh giá từ khách hàng</h2>
            @include('component.header.admin.keThua.review-form')
        </section>
    </main>

    <script>
        const minus = document.querySelector(".minus");
        const plus = document.querySelector(".plus");
        const input_qty = document.querySelector(".input-qty");
        const cartQuantityHidden = document.getElementById("cartQuantityHidden");
        const stockAmount = parseInt(document.getElementById('amount_item').innerText || '0');
        const form_immediately = document.getElementById('form_immediately');

        function syncQuantity() {
            let value = Math.max(1, parseInt(input_qty.value || '1'));
            input_qty.value = value;
            cartQuantityHidden.value = value;
        }

        minus.addEventListener("click", () => {
            input_qty.value = Math.max(1, parseInt(input_qty.value || '1') - 1);
            syncQuantity();
        });

        plus.addEventListener("click", () => {
            input_qty.value = parseInt(input_qty.value || '1') + 1;
            syncQuantity();
        });

        input_qty.addEventListener('input', syncQuantity);

        form_immediately.addEventListener('submit', (event) => {
            syncQuantity();
            if (stockAmount < parseInt(input_qty.value)) {
                event.preventDefault();
                alert('Số lượng trong kho không đủ, bạn vui lòng chọn ít hơn.');
            }
        });
    </script>
</body>

</html>
