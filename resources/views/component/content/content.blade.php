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
                        <span style="display: inline; color: #000">(0)</span>
                    </span>

                    <span style="font-size:14px " class="text-success">đã bán 103</span>
                    <span class="new-price"><b> {{ $item->product_price }}</b><sub>đ</sub></span>
                    <div class="d-flex justify-content-center align-items-center gap-3">
                        <span class="old-price">1500.0<sub>đ</sub></span>
                        <span class="discount">-35%</span>
                        <span class="btn btn-outline-success "><a class="text-danger" href="">Cart</a></span>
                    </div>
                    <p>
                        <a class="text-black" href="#">Review</a>
                    </p>
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
            @for ($i = 1; $i <= 8; $i++)
                <div class="col-6 col-md-3 mb-3">
                    <div class="frame-image">
                        <div>
                            <img class="image-product-content-1 img-fluid"
                                src="{{ asset('component/image-product/mi-tron-cay.png') }}" alt="">
                        </div>
                        <h5 class="product_name text-center"><b>
                                Cà phê muối thơm ngon đặc biệt đậm vị Việt Nam, hương vị độc đáo khó quên.
                            </b></h5>

                        <span class="text-warning product_star">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <span style="display: inline; color: #000; margin-left: 5px;">(0)</span>
                        </span>

                        <span style="font-size:14px" class="text-success">đã bán 103</span>

                        <span class="new-price"><b>1000.0 </b><sub>đ</sub></span>

                        <div class="d-flex justify-content-center align-items-center gap-3">
                            <span class="old-price">1500.0<sub>đ</sub></span>
                            <span class="discount">-35%</span>
                            <span class="btn btn-outline-success btn-sm">cart</span>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>
