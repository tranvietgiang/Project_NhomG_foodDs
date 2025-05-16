<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tất cả sản phẩm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .product {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 30px;
        }

        .item {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin: 15px;
            padding: 15px;
            width: 300px;
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .product-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 10px;
        }

        .name-product a {
            color: #333;
            text-decoration: none;
            font-size: 18px;
            font-weight: 600;
            display: block;
            margin-top: 10px;
        }

        .giatien {
            margin-top: 10px;
        }

        .giatien strong {
            font-size: 20px;
            color: #e74c3c;
        }

        .giatien p {
            margin: 0;
            font-size: 14px;
            color: #888;
        }

        .btn a {
            display: inline-block;
            margin-right: 10px;
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.2s;
        }

        .btn a:hover {
            background-color: #218838;
        }

        .yeuthich {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 22px;
            z-index: 2;
        }

        .yeuthich button {
            background: transparent;
            border: none;
            outline: none;
            cursor: pointer;
        }

        .fa-heart {
            transition: color 0.3s;
        }

        .fa-heart.fa-solid {
            color: red;
        }

        .fa-heart.fa-regular {
            color: #aaa;
        }

        .out-of-stock-message {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.75);
            color: white;
            padding: 12px 20px;
            font-weight: bold;
            border-radius: 6px;
            z-index: 2;
        }

        .hethang {
            opacity: 0.6;
            pointer-events: none;
            position: relative;
        }

        .btn-outline-success.btn-sm {
            margin-top: 10px;
            width: 100%;
            font-weight: bold;
            transition: all 0.2s;
        }

        .btn-outline-success.btn-sm:hover {
            background-color: #28a745;
            color: white;
        }

        .alert {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 999;
            width: auto;
            max-width: 400px;
        }

        @media (max-width: 768px) {
            .item {
                width: 90%;
            }
        }
    </style>

</head>

<body>
    <button class="btn btn-primary" id="goHome">Home</button>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Tất cả sản phẩm</h1>

        <!-- Thanh tìm kiếm -->
        <form action="{{ route('seach') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="query" class="form-control" value="{{ request('query') }}"
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
            <a href="{{ route('sanphamyeuthich') }}">sản phẩm Yêu thích </a>
        </div>
        <div class="product" id="productContainer">
            <!-- Sản phẩm -->
            @foreach ($products as $product)
                <div class="owl-item col-md-4">
                    <div class="item {{ $product->quantity_store > 0 ? '' : 'hethang' }}">
                        <a href="{{ route('show_cart', ['product_id' => $product->product_id]) }}">
                            <img src="{{ asset('component/image-product/' . $product->product_image) }}" alt="Sản phẩm"
                                class="product-image">
                        </a>
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
                                                class=" fa-heart {{ $product->isFavorited ? 'fa-solid' : 'fa-regular' }}"></i>
                                        </button>
                                    </form>

                                </div>
                                @if ($product->quantity_store > 0)
                                    <form action="{{ route('cart.add') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                        <input type="hidden" name="product_price"
                                            value="{{ $product->product_price }}">
                                        <input type="hidden" name="product_image"
                                            value="{{ $product->product_image }}">
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

</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@if (session('success'))
    <div id="alertMessage" class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var alertMessage = document.getElementById('alertMessage');
        if (alertMessage) {
            setTimeout(function() {
                alertMessage.style.display = 'none';
            }, 2000); // 2000 milliseconds = 2 seconds
        }
    });

    $("#goHome").on('click', function() {
        window.location.href = "{{ route('website-main') }}";
    })
</script>
