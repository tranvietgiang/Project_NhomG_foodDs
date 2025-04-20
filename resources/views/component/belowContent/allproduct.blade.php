<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tất cả sản phẩm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .product {
            display: flex;
            flex-wrap: wrap; /* Cho phép sản phẩm xuống dòng */
            justify-content: space-around; /* Căn giữa các sản phẩm */
        }
        .item {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin: 10px;
            text-align: center;
            transition: box-shadow 0.3s; /* Hiệu ứng chuyển tiếp */
        }
        .item:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Hiệu ứng khi hover */
        }
        .product-image {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .price {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Tất cả sản phẩm</h1>
        
        <!-- Thanh tìm kiếm -->
        <form action="" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="query" class="form-control" placeholder="Tìm kiếm sản phẩm..." required>
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                </div>
            </div>
        </form>

        <div class="product" id="productContainer">
            <!-- Sản phẩm -->
            @foreach($products as $product)
                <div class="owl-item col-md-4">
                    <div class="item">
                        <a href="#"><img src="{{ asset('images/'. $product->product_image) }}" alt="Sản phẩm" class="product-image"></a>
                        <div class="divtext">
                            <h3 class="name-product"><a href="#">{{$product->product_name}}</a></h3>
                            <div class="price">
                                <div class="giatien">
                                    <strong>{{$product->product_price}} đ</strong>
                                    <p><span style="text-decoration: line-through;">50,000 ₫</span><span style="color: #e00;">-20%</span></p>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                    <input type="hidden" name="quantity_sp" value="1">
                                    <button type="submit" class="btn btn-outline-success btn-sm">Add</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
         <!-- Phân trang -->
         <div class="mt-4">
            {{ $products->links() }} <!-- Hiển thị các link phân trang -->
        </div>
    </div>
</body>
</html>