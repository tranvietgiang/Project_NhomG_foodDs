<link rel="stylesheet" href="{{ asset('component/content/content.css') }}">
<section class="container">
    <div class="content-part-1">
        <div class="title-part-1">
            <span class="btn btn-success">Sản phẩm mới</span>
            <span class="btn btn-outline-success">Bán chạy nhất</span>
        </div>
        <div class="d-flex justify-content-center align-items-center gap-2">
            @foreach ($newProducts as $product)
                <div class="frame-image">
                    <div>
                        <img class="image-product-content-1 img-fluid"
                            src="{{ asset('images/' . $product->product_image) }}" 
                            alt="{{ $product->product_name }}">
                    </div>
                    <h5 class="product_name"><b>{{ $product->product_name }}</b></h5>
                    <span class="text-warning product_star">
                        @for($i = 0; $i < 5; $i++)
                            <i class="fa-solid fa-star"></i>
                        @endfor
                        <span style="display: inline; color: #000">({{ $product->rating_count ?? 0 }})</span>
                    </span>

                    <span style="font-size:14px" class="text-success">đã bán {{ $product->sold_count }}</span>
                    <span class="new-price"><b>{{ number_format($product->product_price, 0, ',', '.') }}</b><sub>đ</sub></span>
                    <div class="d-flex justify-content-center align-items-center gap-3">
                        @if($product->original_price)
                            <span class="old-price">{{ number_format($product->original_price, 0, ',', '.') }}<sub>đ</sub></span>
                            <span class="discount">-{{ round((($product->original_price - $product->product_price) / $product->original_price) * 100) }}%</span>
                        @endif
                        <span class="btn btn-outline-success"><a class="text-danger" href="#">Cart</a></span>
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
            <span>Đặc sản</span>
            <span>Truyền thống</span>
            <span>Cao cấp</span>
        </div>

        <div class="row">
            @foreach($newProducts as $product)
                <div class="col-6 col-md-3 mb-3">
                    <div class="frame-image">
                        <div>
                            <img class="image-product-content-1 img-fluid"
                                src="{{ asset('images/' . $product->product_image) }}" 
                                alt="{{ $product->product_name }}">
                        </div>
                        <h5 class="product_name text-center">
                            <b>{{ $product->product_name }}</b>
                        </h5>

                        <span class="text-warning product_star">
                            @for($i = 0; $i < 5; $i++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                            <span style="display: inline; color: #000; margin-left: 5px;">({{ $product->rating_count ?? 0 }})</span>
                        </span>

                        <span style="font-size:14px" class="text-success">đã bán {{ $product->sold_count }}</span>
                        <span class="new-price"><b>{{ number_format($product->product_price, 0, ',', '.') }} </b><sub>đ</sub></span>

                        <div class="d-flex justify-content-center align-items-center gap-3">
                            @if($product->original_price)
                                <span class="old-price">{{ number_format($product->original_price, 0, ',', '.') }}<sub>đ</sub></span>
                                <span class="discount">-{{ round((($product->original_price - $product->product_price) / $product->original_price) * 100) }}%</span>
                            @endif
                            <span class="btn btn-outline-success btn-sm">cart</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
