<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
        color: #000;
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

    .hethang {
        opacity: 0.5;
        /* Giảm độ mờ của sản phẩm */
        pointer-events: none;
        /* Ngăn không cho nhấn vào sản phẩm */
        position: relative;
        /* Để sử dụng cho out-of-stock-message */
    }

    .out-of-stock-message {
        position: absolute;
        /* Đặt vị trí tuyệt đối */
        top: 50%;
        /* Đưa vào giữa */
        left: 50%;
        transform: translate(-50%, -50%);
        /* Căn giữa */
        background-color: rgba(0, 0, 0, 0.9);
        /* Nền mờ */
        color: white;
        /* Màu chữ */
        padding: 10px;
        /* Khoảng cách bên trong */
        border-radius: 5px;
        /* Bo góc */
        z-index: 1;
        /* Để đảm bảo nó nằm trên cùng */
    }

    .add-cart-btn {
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
        font-size: 16px;
    }

    .add-cart-btn:hover {
        background-color: var(--primary-dark);
        transform: scale(1.1);
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
                    <div class="section-header">
                        <div class="categories">
                            <a href="{{ route('allproduct') }}" class="category-btn category-sub">XEM TẤT CẢ
                            </a>
                            <a href="#" class="category-btn category-sub">Loại đồ ăn</a>
                            <a href="#" class="category-btn category-sub">Loại thức uống</a>
                            <a href="#" class="category-btn category-sub"> Hoa quả</a>
                        </div>
                    </div>

                </div>
                @foreach ($products as $product)
                    <div class="col-2 col-md-3 mb-3">
                        <div class="frame-image {{ $product->quantity_store > 0 ? '' : 'hethang' }} ">
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
                                <span style="display: inline; color: #000; margin-left: 5px;">(0)</span>
                            </span>

                            <span style="font-size:14px" class="text-success">đã bán 103</span>

                            <span class="new-price"><b>{{ $product->product_price }}</b><sub>đ</sub></span>

                            <div class="d-flex justify-content-center align-items-center gap-3">
                                <span class="old-price">1500.0<sub>đ</sub></span>
                                <span class="discount">-35%</span>

                                @if ($product->quantity_store > 0)
                                    <form action="{{ route('cart.add') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                        <input type="hidden" name="product_price"
                                            value="{{ $product->product_price }}">
                                        <input type="hidden" name="quantity_sp" value="1">
                                        <input type="hidden" name="product_image"
                                            value="{{ $product->product_image }}">
                                        <button type="submit" class="add-cart-btn"
                                            style="display: inline; font-size: 15px">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    </form>
                                @else
                                    <div class="out-of-stock-message">HẾT HÀNG</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
