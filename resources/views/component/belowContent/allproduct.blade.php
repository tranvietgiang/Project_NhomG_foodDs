<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tất cả sản phẩm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .product {
            display: flex;
            flex-wrap: wrap;
            /* Cho phép sản phẩm xuống dòng */
            justify-content: space-around;
            margin-top: 20px;
            /* Căn giữa các sản phẩm */
        }

        .item {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin: 10px;
            text-align: center;
            transition: box-shadow 0.3s;
            /* Hiệu ứng chuyển tiếp */
        }

        .item:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            /* Hiệu ứng khi hover */
        }

        .product-image {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .price {
            margin-top: 10px;
        }

        .btn a {
            border: 1px solid black;
            padding: 10px;
            margin-left: 10px;
            text-decoration: none;
            background-color: green;
            color: white;

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

        .yeuthich {
            position: absolute;
            left: 20%;
            top: 83%;
            font-size: 20px;
        }

        .fa-heart {
            color: green;
            /* Màu mặc định */
        }

        .fa-heart.fa-solid {
            color: red;
            /* Màu khi yêu thích */
        }

        .alert {
            margin-top: 20px;
            /* Khoảng cách trên thông báo */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Tất cả sản phẩm</h1>

        <!-- Thanh tìm kiếm -->
        <form action="{{ route('seach') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" value="{{ request('query') }}" name="query" class="form-control"
                    placeholder="Tìm kiếm sản phẩm..." required>
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                </div>
            </div>
        </form>

        <div class="btn">
            <a href="{{ route('allproduct') }}">Tất cả sản phẩm </a>
            <a href="{{ route('thaplencao') }}">Giá từ thấp đến cao </a>
            <a href="{{ route('caoxuongthap') }}">Giá từ cao đến thấp </a>
        </div>
        <div class="product" id="productContainer">
            <!-- Sản phẩm -->
            @foreach ($products as $product)
                <div class="owl-item col-md-4">
                    <div class="item {{ $product->quantity_store > 0 ? '' : 'hethang' }}">
                        <a href="#"><img src="{{ asset('component/image-product/' . $product->product_image) }}"
                                alt="Sản phẩm" class="product-image"></a>
                        <div class="divtext">
                            <h3 class="name-product"><a href="#">{{ $product->product_name }}</a></h3>
                            <div class="price">
                                <div class="giatien">
                                    <strong>{{ $product->product_price }} đ</strong>
                                    <p><span style="text-decoration: line-through;">50,000 ₫</span><span
                                            style="color: #e00;">-20%</span></p>
                                </div>
                                <div class="yeuthich">
                                    <form action="{{ route('addspyeuthich') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                        <button type="submit">
                                            <i
                                                class="fa-regular fa-heart {{ $product->isFavorited ? 'fa-solid' : '' }}"></i>
                                        </button>
                                    </form>

                                </div>
                                @if ($product->quantity_store > 0)
                                    <form action="{{ route('cart.add') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                        <input type="hidden" name="quantity_sp" value="1">
                                        <button type="submit" class="btn btn-outline-success btn-sm">Add</button>
                                    </form>
                                @else
                                    <div class="out-of-stock-message">HẾT HÀNG</div>
                                    <button type="submit" class="btn btn-outline-success btn-sm">Add</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Phân trang -->
        <div class="mt-4">
            {{ $products->links('pagination::bootstrap-4') }}
            <!-- Hiển thị các link phân trang -->
        </div>
    </div>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var alertMessage = document.getElementById('alertMessage');
        if (alertMessage) {
            setTimeout(function() {
                alertMessage.style.display = 'none';
            }, 2000); // 2000 milliseconds = 2 seconds
        }
    });
</script>
@if (session('success'))
    <div id="alertMessage" class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

</html>
