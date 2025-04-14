<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Giỏ Hàng</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Tên Sản Phẩm</th>
                    <th>Giá</th>
                    <th>Số Lượng</th>
                    <th>Tổng</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                
                <!-- Giả sử bạn sẽ thêm sản phẩm vào đây bằng PHP -->
                 @foreach($cartItems as $item)
                <tr>
                    <td><img src="{{ asset('images/'. $item->product_image) }}" alt=""></td>
                    <td>{{$item->product_name}}</td>
                    <td>
                        <input type="number" value="1" min="1" class="form-control" />
                    </td>
                    <td>{{$item->product_price}}</td>
                    
                    <td>
                        <button class="btn btn-danger">Xóa</button>
                    </td>
                </tr>
               @endforeach
            </tbody>
        </table>
        <div class="total">
            <h3>Tổng Tiền: 300,000 VND</h3>
        </div>
        <button class="btn btn-primary">Tiến Hành Thanh Toán</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>