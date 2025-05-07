<title>Giao diện sản phẩm</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<link rel="stylesheet" href="{{ asset('component/css/mdb.min.css') }}">
<!-- Link icon  -->
<link rel="Website icon" type="png" href="{{ asset('logo-website/login.png') }}">
<!-- Link fontawesome  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<!-- link google icon -->
<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=account_circle" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    /* phần kế thừa từ header navbar */
    a {
        color: #fff;
    }

    nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #266041;
    }

    nav .logo-header a img {
        background-size: contain;
        /* Giữ nguyên tỉ lệ và thu nhỏ theo phần tử */
        background-position: left center;
        /* Căn trái và căn giữa theo chiều dọc */
        background-repeat: no-repeat;
        height: 100px;
        margin-top: -15px;
    }

    nav ul {
        list-style: none;
        display: flex;
    }

    nav ul li {
        margin: 0 15px;
    }

    nav ul li a {
        text-decoration: none;
    }

    label {
        font-size: 15px;
        opacity: 0.5;
    }

    .nav-1 {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .nav-1 li a {
        font-size: 15px;
    }

    .nav-1 li:first-child form input {
        color: white;
    }

    .nav-1 li:last-child,
    .nav-1 li:nth-last-child(2),
    .nav-1 li:nth-last-child(3) {
        border: 1px solid #fff;
        border-radius: 5px;
        padding: 3px 7px;
    }

    .nav-1 form {
        margin-top: 25px;
    }

    .search-bar {
        margin-top: -10px;
    }

    /* rotate img-logo*/
    .logo-header {
        overflow: hidden;
    }

    .rotate-img {
        animation: rotate-img 4s linear infinite;
    }

    @keyframes rotate-img {
        0% {
            transform: rotate(0);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .nav-1 li:hover a {
        color: orange;
    }

    section.footer {
        margin-top: 30px;
        background: #eeeeee;
        padding: 20px 0;
        position: relative;
    }

    section.footer::after {
        position: absolute;
        content: '';
        top: 0;
        left: 0;
        right: 0;
        height: 50px;
        background: #218838;
    }

    .footer-section h5 {
        font-size: 18px;
        margin-bottom: 15px;
    }

    .footer-section p {
        font-size: 14px;
        margin-bottom: 10px;
        color: #333;
    }

    .footer-section span {
        font-size: 13px;
        color: #555;
        text-align: center;
        display: block;
        margin-top: 5px;
    }

    .social-icons i {
        color: #007bff
    }

    /* ============================================================================ */

    body {
        background-color: #f5f5f5;
    }

    .sidebar {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        height: fit-content;
    }

    .sidebar a {
        display: block;
        padding: 10px 0;
        color: #333;
        text-decoration: none;
    }

    .sidebar a.active {
        background-color: #e0f7fa;
        color: #007bff;
        border-radius: 5px;
        padding-left: 10px;
    }

    .form-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .btn-success {
        background-color: #28a745;
        border: none;
    }

    .btn-success:hover {
        background-color: #218838;
    }


    /* Ảnh gốc nhỏ */
    .thumbnail {
        width: 200px;
        cursor: pointer;
        transition: 0.3s;
    }

    .thumbnail:hover {
        opacity: 0.8;
    }

    /* Overlay nền mờ */
    .lightbox {
        display: none;
        position: fixed;
        z-index: 1000;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.8);
        justify-content: center;
        align-items: center;
    }

    /* Ảnh phóng to */
    .lightbox img {
        max-width: 90%;
        max-height: 90%;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
    }

    /* Nút đóng */
    .lightbox::after {
        content: "✖";
        position: absolute;
        top: 20px;
        right: 30px;
        color: white;
        font-size: 32px;
        cursor: pointer;
    }

    /*code list heart =====================================*/
    .product-container {
        display: flex;
        align-items: center;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 10px;
        max-width: 100%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .product-image img {
        width: 200px;
        object-fit: cover;
        height: auto;
        border-radius: 5px;
        margin-right: 15px;
    }

    .product-details {
        flex: 1;
    }

    .product-name {
        font-size: 18px;
        font-weight: bold;
        margin: 0 0 5px;
        color: #333;
    }

    .product-description {
        font-size: 14px;
        color: #666;
        margin: 0 0 10px;
    }

    .product-price {
        display: flex;
        align-items: center;
    }

    .current-price {
        font-size: 16px;
        font-weight: bold;
        /* color: #e74c3c; */
        margin-right: 10px;
    }

    .original-price {
        font-size: 14px;
        color: #999;
        text-decoration: line-through;
    }

    .product-actions {
        display: flex;
        gap: 20px;
    }


    .remove-goods {
        color: #999;
    }

    .remove-goods:hover {
        color: #e74c3c;
    }

    .pagination {
        background-color: transparent !important;
        color: white;
        padding: 10px;
    }

    .pagination .page-link {
        background-color: transparent !important;
        color: white;
        border: 1px solid #dee2e6;
    }

    .page-item.active .page-link {
        background-color: #007bff !important;
        border-color: #007bff !important;
    }
</style>


<nav class="navbar">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center w-100">

            <div class="logo-header">
                <a href="{{ route('website-main') }}">
                    <img importance="high" class="rotate-img" src="{{ asset('logo-website/login.png') }}"
                        alt="logo">
                </a>
            </div>

            <ul class="nav-1 d-flex align-items-center">
                <li class="search-bar">
                    <form action="#" method="get">
                        @csrf
                        <div class="form-outline input-group mb-0 " data-mdb-input-init>
                            <input type="text" id="key-word" value="" name="search" class="form-control"
                                required>
                            <label class="form-label text-white" for="key-word">Nhập nội dung tìm kiếm</label>
                            <button class="btn btn-secondary" type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </form>
                </li>

                <li>
                    <a href="#"><i class="fa-solid fa-bell px-2"></i><span>Thông báo nội dung</span></a>
                </li>

                <li>
                    @if (!Auth::check())
                        <a class="d-flex justify-content-center align-items-center"
                            href="{{ url('/information-client') }}">
                            <span class="material-symbols-outlined">account_circle</span><span class="px-2">Đăng
                                nhập</span>
                        </a>
                    @endif
                </li>

                <li style="margin-left: -20px">
                    @if (!Auth::check())
                        <a href="{{ route('wayLogin', ['page' => 'register']) }}"><span>Đăng ký</span></a>
                    @else
                        <a href="#"><span>{{ Auth::user()->name }}</span></a>
                    @endif
                </li>

                <li>
                    <a href="#"><span><i class="fa-solid fa-warehouse"></i> Giao hàng từ kho: </span><b
                            class="text-warning fw-bold">Quảng Nam</b></a>
                </li>

                <li>
                    <a style="display: inline-block; position: relative;" href="{{ route('cart.shows_goods') }}"><i
                            class="fa-solid fa-cart-shopping"></i></a>
                    <span id="cartCount" style="position: absolute; top: 10%; left:92%;"
                        class="btn-sm btn btn-success">{{ $amount_cart_header ?? 0 }}</span>
                </li>
            </ul>
        </div>
    </div>
</nav>




<!-- code trang wensite này -->
<section class="container">

    <div class="container mt-5">
        <div class="row">
            <!-- Barre latérale -->
            <div class="col-md-3">
                <div class="sidebar">
                    <a href="{{ url('/information-client') }}">
                        <h5 class="btn btn-success">Tài khoản</h5>
                    </a>

                    <style>
                        .btn-save {
                            opacity: 0;
                            position: fixed;
                            z-index: -1;
                        }

                        .btn-avatar {
                            position: absolute;
                            opacity: 1;
                            z-index: 999;
                        }
                    </style>


                    <!-- hiện name & email -->
                    <p>
                        <strong>{{ Auth::user()->name }}</strong><br>{{ Auth::user()->email }}
                    </p>
                    <a href="#">Số dư </a>
                    <a href="#">Đơn hàng </a>
                    <a href="#">My Farm</a>
                    <a href="#">Voucher </a>
                    <a href="{{ route('goods.heart.giang') }}">Sản phẩm yêu thích</a>
                    <a href="#">Nhật xét </a>
                    <a href="#">Thông báo </a>
                    <!-- logout  -->
                    <div class="">
                        <!-- check user login yet? -->
                        @if (Auth::check())
                            <form style="z-index: 1" class="" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" style="border: 1px solid green"
                                    class="btn btn-link text-black">Đăng xuất</button>
                            </form>
                        @endif
                    </div>
                    <a href="#" class="text-success mt-3">Bán hàng cùng foodmap</a>
                </div>
            </div>

            <!-- danh sách yêu thích -->
            <div class="col-md-9">
                <h3 class="btn btn-success"> danh sách đơn hàng</h3>
                @if ($my_order->isEmpty())
                    <div class="alert alert-info text-center" role="alert">
                        Chưa có sản phẩm nào trong danh sách yêu thích!
                    </div>
                @else
                    <div class="bg-success p-2">
                        {{ $my_order->links('pagination::bootstrap-4') }}
                    </div>

                    <div class="heart-list">
                        @foreach ($my_order as $order)
                            <div class="heart-item card mb-3 shadow-sm">
                                @foreach ($order->products as $product)
                                    <div class="row g-0">
                                        <h5 class="btn btn-primary">Đơn hàng #{{ $order->bill_id }}</h5>
                                        <!-- Hình ảnh sản phẩm -->
                                        <div class="col-md-3">
                                            <img src="{{ asset('component/image-product/' . $product->product_image) }}"
                                                class="img-fluid rounded-start heart-image"
                                                alt="{{ $product->product_name }}">
                                        </div>
                                        <!-- Thông tin sản phẩm -->
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <h5 class="card-title heart-name">{{ $product->product_name }}</h5>
                                                <p class="card-text heart-description text-muted">
                                                    Theo giỏ Đà Lạt - Túi 250g - Độc sản Ngọt Lành - Màu Cam Vàng
                                                </p>
                                                <p class="card-text heart-description text-muted">
                                                    {{ $product->pivot->quantity }}
                                                </p>
                                                <div class="heart-price">
                                                    <span class="current-price price-display text-success fw-bold">
                                                        {{ number_format($product->product_price) }} đ
                                                    </span>
                                                </div>
                                                <p>Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                    </div>
                @endif
            </div>
        </div>
    </div>
</section>




<!-- Footer -->
<section class="footer ">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3">
                <h5>Về chúng tôi</h5>
                <p>Foodmap là nền tảng kết nối nông dân, nhà sản xuất thực phẩm với người tiêu dùng thông qua các sản
                    phẩm
                    chất lượng và an toàn.</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi, repudiandae!</p>
            </div>
            <div class="col-md-4 mb-3">
                <h5>Liên hệ</h5>
                <p>Email: contact@foodmap.vn</p>
                <p>Điện thoại: 0123 456 789</p>
                <p>Địa chỉ: 123 Đường ABC, TP.HCM</p>
            </div>
            <div class="col-md-4 mb-3">
                <h5>Theo dõi chúng tôi</h5>
                <div class="social-icons">
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center mt-3">
                <p class="copyright">&copy; 2025 Foodmap. All rights reserved.</p>
            </div>
        </div>
    </div>
</section>
<!-- js header -->
<script src="{{ asset('component/js/mdb.umd.min.js') }}"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
