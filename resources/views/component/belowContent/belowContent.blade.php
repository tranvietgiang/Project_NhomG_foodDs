<style>
    /* Phần chứa toàn bộ sản phẩm */
    .belowcontent {
        background: #ffffff;
        margin-top: 10px;
    }

    /* Khung của mỗi sản phẩm */
    .belowcontent .frame-image {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        background-color: #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .belowcontent .frame-image:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    }

    .belowcontent .image-product-content-1 {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .belowcontent .product_name {
        font-size: 14px;
        color: #333;
    }

    .belowcontent .new-price {
        color: #d9534f;
        font-weight: bold;
    }

    /* Giá cũ */
    .belowcontent .old-price {
        font-size: 12px;
        color: #999;
    }

    /* Phần giảm giá */
    .belowcontent .discount {
        background-color: #d9534f;
        color: #fff;
        border-radius: 5px;
        padding: 2px 5px;
    }

    /* Các nút bấm */
    .belowcontent .btn-sm {
        padding: 3px 10px;
    }

    /* Phần hiển thị số lượng bán */
    .belowcontent .text-success {
        font-size: 12px;
    }
</style>


<section class="container belowcontent">
    <div class="row">
        <div class="col-3 col-md-3">
            <img style="background-size: cover; width: 100%; height: 100%;"
                src="{{ asset('component/image-product/ban-do-vn.png') }}" alt="">
        </div>

        <div class="col-9 col-md-9">
            <div class="row">
                <style>
                    .abc {
                        color: #000;
                    }
                </style>
                <div style="margin: 10px 0;">
                    <span class="btn btn-success"><a class="abc" href="#">aaaaaaaaaaaaaa</a></span>
                    <span class="btn btn-success"><a class="abc" href="">sắp xếp theo giá cao đén
                            thấp</a></span>
                    <span class="btn btn-success"><a class="abc" href="#">sắp xếp theo giá thấp đén
                            cao</a></span>
                    <span class="btn btn-success"><a class="abc " href="{{ route('allproduct') }}">Xem tất
                            cả</a></span>
                </div>
                @foreach ($products as $product)
                    <div class="col-2 col-md-3 mb-3">
                        <div class="frame-image">
                            <div>
                                <img class="image-product-content-1 img-fluid"
                                    src="{{ asset('images/' . $product->product_image) }}" alt="">
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
                                <span style="display: inline; color: #000; margin-left: 5px;">(0)</span>
                            </span>

                            <span style="font-size:14px" class="text-success">đã bán 103</span>

                            <span class="new-price"><b>{{ $product->product_price }}</b><sub>đ</sub></span>

                            <div class="d-flex justify-content-center align-items-center gap-3">
                                <span class="old-price">1500.0<sub>đ</sub></span>
                                <span class="discount">-35%</span>
                                <form action="{{ route('cart.add') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                    <input type="hidden" name="quantity_sp" value="1">
                                    <!-- Thêm trường quantity_sp nếu cần -->
                                    <button type="submit" class="btn btn-outline-success btn-sm"
                                        style="display: inline; font-size: 12px;">Thêm vào giỏ hàng</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
