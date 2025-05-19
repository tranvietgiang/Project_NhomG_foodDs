<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('component/css/bootstrap.min.css') }}">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Poppins:wght@400;500;600;700&display=swap">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: #212529;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .back-button {
            margin-bottom: 20px;
        }

        .product-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }

        .product-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }

        .product-images {
            position: relative;
        }

        .main-image {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .thumbnail-container {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            overflow-x: auto;
            padding-bottom: 10px;
        }

        .thumbnail {
            width: 80px;
            height: 80px;
            border-radius: 4px;
            cursor: pointer;
            object-fit: cover;
            border: 2px solid transparent;
            transition: all 0.2s ease;
        }

        .thumbnail.active {
            border-color: #ff6b6b;
        }

        .thumbnail:hover {
            transform: translateY(-3px);
        }

        .product-info {
            padding-left: 20px;
        }


        .star-rating {
            color: #ffc107;
        }

        .sales-info {
            font-size: 14px;
            color: #28a745;
            margin-bottom: 15px;
        }

        .product-price {
            font-size: 24px;
            font-weight: 700;
            color: #343a40;
            margin-bottom: 20px;
        }

        .product-price sub {
            font-size: 16px;
            font-weight: normal;
        }

        .quantity-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .input-qty {
            width: 60px;
            text-align: center;
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 8px 5px;
            font-size: 16px;
            background-color: #fff;
        }

        input.input-qty[type="number"]::-webkit-inner-spin-button,
        input.input-qty[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .btn.minus,
        .btn.plus {
            width: 40px;
            height: 40px;
            font-size: 18px;
            line-height: 1;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
        }

        .btn-minus {
            background-color: #f8f9fa;
            border: 1px solid #dc3545;
            color: #dc3545;
        }

        .btn-plus {
            background-color: #f8f9fa;
            border: 1px solid #28a745;
            color: #28a745;
        }

        .stock-info {
            font-size: 14px;
            margin-bottom: 15px;
        }

        .cta-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-buy-now {
            background-color: #28a745;
            color: white;
            padding: 12px 25px;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-buy-now:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }

        .btn-action {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 20px;
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.3s ease;
            gap: 8px;
        }

        .btn-cart {
            background-color: #f8f9fa;
            border: 1px solid #28a745;
            color: #28a745;
        }

        .btn-cart:hover {
            background-color: #e9ecef;
        }

        .btn-wishlist {
            background-color: #f8f9fa;
            border: 1px solid #dc3545;
            color: #dc3545;
        }

        .btn-wishlist:hover {
            background-color: #e9ecef;
        }

        .product-description {
            margin-top: 40px;
        }

        .section-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .product-container {
                padding: 20px;
            }

            .product-info {
                padding-left: 0;
                margin-top: 30px;
            }

            .cta-buttons {
                flex-direction: column;
            }

            .btn-action {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Back button -->
        <div class="back-button">
            <a href="{{ route('website-main') }}" class="btn btn-outline-success">
                <i class="bi bi-arrow-left"></i> TIẾP TỤC MUA SẮM
            </a>
        </div>

        <!-- route show_cart_mua_ngay -->
        <div class="product-container">
            <div class="row">
                <!-- Product images -->
                <div class="col-md-6">
                    <div class="product-images">
                        <img src="{{ asset('component/image-product/' . $cart[0]->product_image) }}"
                            alt="{{ $cart[0]->product_name }}" class="main-image" id="mainImage">

                        <!-- handle image -->
                        <div class="thumbnail-container">
                            <img src="{{ asset('component/image-product/1746353995_messi.jpg') }}" alt="Thumbnail 1"
                                class="thumbnail active" onclick="changeImage(this)">
                            <img src="{{ asset('component/image-product/' . $cart[0]->product_image) }}"
                                alt="Thumbnail 2" class="thumbnail" onclick="changeImage(this)">
                            <img src="{{ asset('component/image-product/' . $cart[0]->product_image) }}"
                                alt="Thumbnail 3" class="thumbnail" onclick="changeImage(this)">
                            <img src="{{ asset('component/image-product/' . $cart[0]->product_image) }}"
                                alt="Thumbnail 4" class="thumbnail" onclick="changeImage(this)">
                        </div>
                    </div>
                </div>

                <!-- Product info -->
                <div class="col-md-6">
                    <div class="product-info">
                        <h1 class="product-title">{{ $cart[0]->product_name }}</h1>
                        <div class="product-rating d-flex gap-3 "><br>
                            <span class="star-rating">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </span>
                            <span>({{ $quantity_item_review ?? '0' }})</span>
                        </div>

                        <div class="sales-info">
                            <i class="bi bi-bag-check"></i> Đã bán {{ $goods_sold ?? '0' }}
                        </div>

                        <div class="product-price">
                            {{ number_format($cart[0]->product_price) }}<sub>đ</sub>
                        </div>

                        <form id="form_immediately"
                            action="{{ url('/cart/show_checkout', ['product_id' => $cart[0]->product_id]) }}"
                            method="get">
                            @csrf

                            <div class="stock-info">
                                <label class="form-label">Số lượng còn: <b
                                        id="amount_item">{{ $quantity_store ?? '0' }}</b></label>
                            </div>

                            <div class="quantity-container">
                                <button type="button" class="btn btn-minus minus">−</button>
                                <input name="cart_quantity" type="number" value="1" min="1"
                                    class="input-qty">
                                <button type="button" class="btn btn-plus plus">+</button>
                            </div>

                            <!-- click để mua ngay sản phẩm -->
                            <div class="cta-buttons">
                                <button id="button_pay" class="btn btn-buy-now" type="submit">
                                    <i class="bi bi-bag-check-fill"></i> MUA NGAY
                                </button>

                                <a class="btn btn-action btn-cart" href="#">
                                    <i class="bi bi-cart-plus"></i> THÊM VÀO GIỎ
                                </a>

                                <a class="btn btn-action btn-wishlist" href="#">
                                    <i class="bi bi-heart"></i> YÊU THÍCH
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Product description -->
            <div class="product-description">
                <h3 class="section-title">Mô tả sản phẩm</h3>
                <p>{{ $cart[0]->description ?? 'mota' }}</p>
            </div>
        </div>

        <!-- Reviews section -->
        <div class="product-container">
            <h3 class="section-title">Đánh giá từ khách hàng</h3>
            @include('component.header.admin.keThua.review-form')
        </div>
    </div>

    <script>
        // Change main image when clicking on thumbnails
        function changeImage(thumbnail) {
            // Remove active class from all thumbnails
            document.querySelectorAll('.thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
            });

            // Add active class to clicked thumbnail
            thumbnail.classList.add('active');

            // Update main image
            document.getElementById('mainImage').src = thumbnail.src;
        }

        // Quantity controls
        const minus = document.querySelector(".minus");
        const plus = document.querySelector(".plus");
        const input_qty = document.querySelector(".input-qty");

        minus.addEventListener("click", () => {
            let quality = parseInt(input_qty.value);
            if (quality > 1) {
                input_qty.value = quality - 1;
            }
        });

        plus.addEventListener("click", () => {
            let quality = parseInt(input_qty.value);
            input_qty.value = quality + 1;
        });

        // Form validation
        const check_slSP = document.getElementById('amount_item').innerText;
        const form_immediately = document.getElementById('form_immediately');

        form_immediately.addEventListener('submit', (e) => {
            if (parseInt(check_slSP) < parseInt(input_qty.value)) {
                e.preventDefault();
                alert('Sản phẩm hiện tại đã hết hàng, xin vui lòng quay lại sau.');
            }
        });
    </script>
</body>

</html>
