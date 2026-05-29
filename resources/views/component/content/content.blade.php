<meta name="csrf-token" content="{{ csrf_token() }}">

@php
    function fdProductCard($product, $amount_star_5, $product_sold) {
        $price_discount = round($product->product_price * 0.65);
        return [
            'sale_price' => $price_discount,
            'sold' => $product_sold[$product->product_id] ?? 0,
            'stars' => $amount_star_5[$product->product_id] ?? 0,
        ];
    }
@endphp

<section class="fd-section fd-container">
    <div class="fd-panel">
        <div class="fd-section-head">
            <div>
                <p class="fd-eyebrow">Món ngon mới mỗi ngày</p>
                <h2 class="fd-title">Sản phẩm nổi bật</h2>
            </div>
            <div class="fd-chip-row">
                <button id="home" type="button" class="fd-chip active" style="border:0">Sản phẩm mới</button>
                <button id="saleRating" data-url="{{ route('sale.item.index') }}" type="button" class="fd-chip" style="border:0">Bán chạy nhất</button>
            </div>
        </div>

        <div id="bestSaleContainer" class="fd-product-grid">
            @foreach ($content_data as $item)
                @php $meta = fdProductCard($item, $amount_star_5, $product_sold); @endphp
                <article class="fd-card">
                    <a href="{{ route('show_cart', ['product_id' => $item->product_id]) }}">
                        <img class="fd-card-img" src="{{ asset('component/image-product/' . $item->product_image) }}"
                            alt="{{ $item->product_name }}">
                    </a>
                    <div class="fd-card-body">
                        <a class="fd-card-title" href="{{ route('show_cart', ['product_id' => $item->product_id]) }}">{{ $item->product_name }}</a>
                        <div class="fd-stars">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                            <span class="fd-muted">({{ $meta['stars'] }})</span>
                        </div>
                        <div class="fd-muted"><i class="bi bi-bag-check"></i> Đã bán {{ $meta['sold'] }}</div>
                        <div class="fd-price-line">
                            <div>
                                <div class="fd-price">{{ number_format($meta['sale_price']) }}đ</div>
                                <span class="fd-old-price">{{ number_format($item->product_price) }}đ</span>
                                <span class="fd-sale">-35%</span>
                            </div>
                            <a class="fd-add addCartMany"
                                data-url="{{ route('add.cartMany.giang', ['product_id' => $item->product_id, 'price_goods' => $item->product_price]) }}"
                                aria-label="Thêm vào giỏ hàng"><i class="fas fa-cart-plus"></i></a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="fd-section fd-container">
    <div class="fd-panel">
        <div class="fd-section-head">
            <div>
                <p class="fd-eyebrow">Đặc sản và đồ uống</p>
                <h2 class="fd-title">Tinh hoa đất Việt</h2>
            </div>
            <div class="fd-chip-row">
                <a href="{{ route('allproduct') }}" class="fd-chip active">Xem tất cả</a>
                <a href="#" class="fd-chip">Đồ ăn</a>
                <a href="#" class="fd-chip">Thức uống</a>
                <a href="#" class="fd-chip">Trái cây</a>
            </div>
        </div>

        <div class="fd-product-grid">
            @foreach ($content_data_hung as $product)
                @php $meta = fdProductCard($product, $amount_star_5, $product_sold); @endphp
                <article class="fd-card">
                    <a href="{{ route('show_cart', ['product_id' => $product->product_id]) }}">
                        <img class="fd-card-img" src="{{ asset('component/image-product/' . $product->product_image) }}"
                            alt="{{ $product->product_name }}">
                    </a>
                    <div class="fd-card-body">
                        <a class="fd-card-title" href="{{ route('show_cart', ['product_id' => $product->product_id]) }}">{{ $product->product_name }}</a>
                        <div class="fd-stars">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                            <span class="fd-muted">({{ $meta['stars'] }})</span>
                        </div>
                        <div class="fd-muted"><i class="bi bi-bag-check"></i> Đã bán {{ $meta['sold'] }}</div>
                        <div class="fd-price-line">
                            <div>
                                <div class="fd-price">{{ number_format($meta['sale_price']) }}đ</div>
                                <span class="fd-old-price">{{ number_format($product->product_price) }}đ</span>
                                <span class="fd-sale">-35%</span>
                            </div>
                            <a class="fd-add addCartMany"
                                data-url="{{ route('add.cartMany.giang', ['product_id' => $product->product_id, 'price_goods' => $product->product_price]) }}"
                                aria-label="Thêm vào giỏ hàng"><i class="fas fa-cart-plus"></i></a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<div id="alert-add-cart" class="alert alert-success d-none" role="alert"></div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('.addCartMany').on('click', function(e) {
        e.preventDefault();
        let url = $(this).data('url');

        $.ajax({
            url: url,
            type: "POST",
            data: {_token: "{{ csrf_token() }}"},
            success: function(value) {
                $('#cartCount').text(value.cartCount);
                showCartAlert(value.alertCart ? 'Thêm sản phẩm vào giỏ hàng thành công!' : 'Quý khách vui lòng đăng nhập.');
            }
        });
    });

    $('#home').on('click', function() {
        window.location.href = "{{ route('website-main') }}";
    });

    $('#saleRating').on('click', function() {
        const url = $(this).data('url');
        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                let html = '';
                let data2 = response.data || [];
                let numberStar = response.amount_star_5 || {};

                data2.forEach(item => {
                    let price_discount = Math.round(item.product_price * 0.65);
                    html += `
                    <article class="fd-card">
                        <a href="/cart/${item.product_id}">
                            <img class="fd-card-img" src="/component/image-product/${item.product_image}" alt="${item.product_name}">
                        </a>
                        <div class="fd-card-body">
                            <a class="fd-card-title" href="/cart/${item.product_id}">${item.product_name}</a>
                            <div class="fd-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i> <span class="fd-muted">(${numberStar[item.product_id] ?? 0})</span></div>
                            <div class="fd-muted"><i class="bi bi-bag-check"></i> Đã bán ${item.SOLUONG}</div>
                            <div class="fd-price-line">
                                <div>
                                    <div class="fd-price">${Number(price_discount).toLocaleString('vi-VN')}đ</div>
                                    <span class="fd-old-price">${Number(item.product_price).toLocaleString('vi-VN')}đ</span>
                                    <span class="fd-sale">-35%</span>
                                </div>
                                <button type="button" class="fd-add renDeraddCartMany" data-render-id="${item.product_id}" data-render-price="${item.product_price}" aria-label="Thêm vào giỏ hàng"><i class="fas fa-cart-plus"></i></button>
                            </div>
                        </div>
                    </article>`;
                });
                $('#bestSaleContainer').html(html);
            }
        });
    });

    $(document).on('click', '.renDeraddCartMany', function(e) {
        e.preventDefault();
        const product_id = $(this).data('render-id');
        const price_goods = $(this).data('render-price');
        $.ajax({
            url: `/add/cartMany/${product_id}/${price_goods}`,
            type: "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(response) {
                $('#cartCount').text(response.cartCount);
                showCartAlert(response.alertCart ? 'Thêm sản phẩm vào giỏ hàng thành công!' : 'Quý khách vui lòng đăng nhập.');
            }
        });
    });

    function showCartAlert(message) {
        var alertMessage = $('#alert-add-cart');
        alertMessage.text(message).removeClass('d-none');
        setTimeout(function() { alertMessage.addClass('d-none'); }, 3000);
    }
</script>
