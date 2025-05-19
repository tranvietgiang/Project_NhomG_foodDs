<link rel="stylesheet" href="{{ asset('component/content/content.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

<section class="container">
    <div class="content-part-1">
        <div class="title-part-1">
            <span id="home" class="btn btn-success">Sản phẩm mới</span>
            <span id="saleRating" data-url="{{ route('sale.item.index') }}" class="btn btn-outline-success">Bán chạy
                nhất
            </span>
        </div>
        <div id="bestSaleContainer" class="d-flex justify-contet-center align-items-center gap-2">

            @foreach ($content_data as $item)
                <div class="frame-image">
                    {{-- <span>{{ $item->product_id }}</span> --}}
                    <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                    <!-- cart -->
                    <div>
                        <a href="{{ route('show_cart', ['product_id' => $item->product_id]) }}">
                            <img class="image-product-content-1 img-fluid"
                                src="{{ asset('component/image-product/' . $item->product_image) }}" alt="">
                        </a>
                    </div>
                    <h5 class="product_name"><b>
                            {{ $item->product_name }}
                        </b></h5>
                    <span class="text-warning product_star">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <span style="display: inline; color: #000">({{ $amount_star_5[$item->product_id] ?? 0 }})</span>
                    </span>

                    <span style="font-size:14px " class="text-success"> <i class="bi bi-bag-check"></i> đã bán
                        {{ $product_sold[$item->product_id] ?? 0 }}</span>
                    @php
                        $price_coupon = $item->product_price - ($item->product_price * 35) / 100;
                    $price_discount = round($price_coupon, 0); @endphp
                    <span class="new-price"><b> {{ number_format($price_discount) }}</b><sub>đ</sub></span>
                    <div class="d-flex justify-content-center align-items-center gap-5">
                        <span class="old-price">1500.0<sub>đ</sub></span>
                        <span style="margin-left: -10px" class="discount">-35%</span>
                        <span>
                            <a class="add-cart-btn addCartMany"
                                data-url="{{ route('add.cartMany.giang', [
                                    'product_id' => $item->product_id,
                                    'price_goods' => $item->product_price,
                                ]) }}">
                                <i class="fas fa-cart-plus"></i>
                            </a>
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- part-2 -->
<section class="container pt-5">
    <div class="content-part-1">
        <div class="section-header">
            <h2 class="section-title text-uppercase">Tinh hoa đất việt</h2>
            <div class="categories">
                <a href="#" class="category-btn category-main">SẢN PHẨM MỚI</a>
                <a href="#" class="category-btn category-sub">?????????</a>
                <a href="#" class="category-btn category-sub">?????????</a>
                <a href="#" class="category-btn category-sub">?????????</a>
            </div>
        </div>

        <div class="row">
            @foreach ($content_data_hung as $product)
                <div class="col-6 col-md-3 mb-3">
                    {{-- <span>{{ $product->product_id }}</span> --}}
                    <div class="frame-image">
                        <div>
                            <a href="{{ route('show_cart', ['product_id' => $product->product_id]) }}">
                                <img class="image-product-content-1 img-fluid"
                                    src="{{ asset('component/image-product/' . $product->product_image) }}"
                                    alt="">
                            </a>
                        </div>
                        <h5 class="product_name text-center"><b>
                                {{ $product->product_name }}
                            </b></h5>

                        <span class="text-warning product_star">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <!-- web showIndex -->
                            <span
                                style="display: inline; color: #000; margin-left: 5px;">({{ $amount_star_5[$product->product_id] ?? 0 }})
                            </span>
                        </span>

                        <span style="font-size:14px" class="text-success"> <i class="bi bi-bag-check"></i> đã bán
                            {{ $product_sold[$product->product_id] ?? 0 }}
                        </span>

                        <span class="new-price">
                            <b class="price_new_giang" id="price-new">{{ number_format($price_discount) }}</b>
                            <sub>đ</sub>
                        </span>

                        <div class="d-flex align-items-center gap-5">
                            <span id="price_old_giang" class="old-price">
                                {{ $product->product_price }}<sub>đ</sub></span>
                            <span class="discount">-35%</span>
                            <!-- click để thêm sản phẩm  -->
                            <span>
                                <a class="add-cart-btn addCartMany"
                                    data-url="{{ route('add.cartMany.giang', [
                                        'product_id' => $product->product_id,
                                        'price_goods' => $product->product_price,
                                    ]) }}">
                                    <i class="fas fa-cart-plus"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>


<div id="alert-add-cart" class="alert alert-success d-none" role="alert"></div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    /* handle thêm cart*/
    $('.addCartMany').on('click', function(e) {
        e.preventDefault();
        let url = $(this).data('url'); // Lấy URL từ data-url

        $.ajax({
            url: url,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(value) {
                $('#cartCount').text(value.cartCount);
                console.log(value.alert_add_cart)
                if (value.alertCart) {
                    showCartAlert('Thêm sản phẩm vào giỏ hàng thành công!');
                } else {
                    showCartAlert('Quý khách vui lòng đăng nhập');
                }
            }
        });
    });

    // let productId = $(this).next('.frame-image').find('input[name="product_id"]').val(); // lấy nhất xác luôn
    // let productId = $('input[name="product_id"]').first().val(); // lấy cái đầu tiên
    $('#home').on('click', function() {
        const url = $(this).data('url');
        window.location.href = "{{ route('website-main') }}"
    });

    $('#saleRating').on('click', function() {
        const url = $(this).data('url');

        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                let html = '';
                let data2 = response.data;
                let numberStar = response.amount_star_5;
                console.log("Dữ liệu nhận được:", numberStar);
                // console.log("Kiểm tra data2:", response.data2);


                data2.forEach(item => {
                    let price_discount = Math.round(item.product_price - (item
                        .product_price * 35) / 100);

                    html += `
                <div class="frame-image">
                    <input type="hidden" name="product_id" value="${item.product_id}">
                    <div>
                        <a href="/cart/${item.product_id}">
                            <img class="image-product-content-1 img-fluid"
                                 src="/component/image-product/${item.product_image}" alt="">
                        </a>
                    </div>
                    <h5 class="product_name"><b>${item.product_name}</b></h5>
                    <span class="text-warning product_star">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <span style="color:#000">(${numberStar[item.product_id] ?? 0})</span>
                    </span>
                    <span style="font-size:14px" class="text-success"> <i class="bi bi-bag-check"></i> đã bán ${item.SOLUONG}</span>
                    <span class="new-price"><b>${price_discount}</b><sub>đ</sub></span>
                    <div class="d-flex justify-content-center align-items-center gap-3">
                        <span class="old-price">${item.product_price}<sub>đ</sub></span>
                        <span class="discount">-35%</span>
                        <span>
                            <div style="font-size: 10px" 
                    class="btn-sm btn btn-success renDeraddCartMany"
                    data-render-id="${item.product_id}"
                    data-render-price="${item.product_price}">
                    Thêm vào giỏ
                            </div>

                        </span>
                    </div>
                </div>`;
                });

                $('#bestSaleContainer').html(html);
            },
            error: function(err) {
                console.error("Lỗi khi lấy sản phẩm bán chạy", err);
            }
        });
    });


    /*click để thêm giỏ hàng*/
    $(document).on('click', '.renDeraddCartMany', function(e) {
        e.preventDefault();

        const product_id = $(this).data('render-id');
        const price_goods = $(this).data('render-price');

        $.ajax({
            url: `/add/cartMany/${product_id}/${price_goods}`,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#cartCount').text(response.cartCount);
                if (response.alertCart) {
                    showCartAlert('Thêm sản phẩm vào giỏ hàng thành công!');
                } else {
                    showCartAlert('Quý khách vui lòng đăng nhập');
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    });



    // Hàm hiển thị thông báo state sản phẩm
    function showCartAlert(message) {
        var alertMessage = $('#alert-add-cart');
        alertMessage.text(message); // Đặt nội dung thông báo
        alertMessage.removeClass('d-none'); // Hiện thông báo
        setTimeout(function() {
            alertMessage.addClass('d-none'); // Ẩn sau 8 giây
        }, 3000);
    }
</script>
