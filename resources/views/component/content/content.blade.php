<link rel="stylesheet" href="{{ asset('component/content/content.css') }}">
<section class="container">
    <div class="content-part-1">
        <div class="title-part-1">
            <span class="btn btn-success">Sản phẩm mới</span>
            <span class="btn btn-outline-success">Bán chạy nhất</span>
        </div>
        <div class="d-flex justify-content-center align-items-center gap-2">
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

                    <span style="font-size:14px " class="text-success">đã bán
                        {{ $product_sold[$item->product_id] ?? 0 }}</span>
                    @php
                        $price_coupon = $item->product_price - ($item->product_price * 35) / 100;
                    $price_discount = round($price_coupon, 0); @endphp
                    <span class="new-price"><b> {{ $price_discount }}</b><sub>đ</sub></span>
                    <div class="d-flex justify-content-center align-items-center gap-3">
                        <span class="old-price">1500.0<sub>đ</sub></span>
                        <span class="discount">-35%</span>
                        <span>
                            <a style="font-size: 10px" class="btn-sm btn btn-success addCartMany"
                                data-url="{{ route('add.cartMany.giang', [
                                    'product_id' => $item->product_id,
                                    'price_goods' => $item->product_price,
                                ]) }}">
                                Thêm vào giỏ
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
        <div class="title-part-1 d-flex gap-3">
            <span>TINH HOA QUÀ VIỆT</span>
            <span>aaaaaaaat</span>
            <span>aaaaaaaat</span>
            <span>aaaaaaaat</span>
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
                            <span
                                style="display: inline; color: #000; margin-left: 5px;">({{ $amount_star_5[$product->product_id] ?? 0 }})</span>
                        </span>

                        <span style="font-size:14px" class="text-success">đã bán
                            {{ $product_sold[$product->product_id] ?? 0 }}
                        </span>

                        <span class="new-price">
                            <b class="price_new_giang" id="price-new">{{ number_format($price_discount) }}</b>
                            <sub>đ</sub>
                        </span>

                        <div class="d-flex justify-content-center align-items-center gap-5">

                            <div class="d-flex justify-content-center align-items-center">
                                <span id="price_old_giang" class="old-price">
                                    {{ $product->product_price }}<sub>đ</sub></span>
                                <span class="discount">-35%</span>
                            </div>
                            <div>
                                <a class="btn-sm btn btn-success addCartMany"
                                    data-url="{{ route('add.cartMany.giang', [
                                        'product_id' => $product->product_id,
                                        'price_goods' => $product->product_price,
                                    ]) }}">
                                    Thêm vào giỏ
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
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
            }
        });
    });
</script>
