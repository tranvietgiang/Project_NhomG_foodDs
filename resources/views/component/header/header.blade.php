<!-- link css -->
<link rel="stylesheet" href="{{ asset('component/header/header.css') }}">

<section class="header-container">
    <!-- nav header -->
    <nav class="navbar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center w-100">

                <div class="logo-header">
                    <p class="nav-responsive"><i class="fa-solid fa-bars"></i></p>

                    <a href="">
                        <img importance="high" class="rotate-img" src="{{ asset('logo-website/login.png') }}"
                            alt="logo">
                    </a>
                </div>

                <ul class="nav-1 d-flex align-items-center">
                    <li class="search-bar">
                        <form action="#" method="get">
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
                        <a class="d-flex justify-content-center align-items-center"
                            href="{{ url('/information-client') }}">
                            <span class="material-symbols-outlined">account_circle</span><span class="px-2">Đăng
                                nhập</span>
                        </a>
                    </li>

                    <li>
                        <a href="#"><span>Đăng ký</span></a>
                    </li>

                    <li>
                        <a href="#"><span><i class="fa-solid fa-warehouse"></i> Giao hàng từ kho: </span><b
                                class="text-warning fw-bold">Quảng Nam</b></a>
                    </li>

                    <li>
                        <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- bạn đầu sẽ none nav-sidebar -->
    <div class="content-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="">Trang Chủ</a></li>
                <li><a href="#">Về FoodMap</a></li>
                <li><a href="#">Xuất Khẩu</a></li>
                <li><a href="#">Agrishow</a></li>
                <li><a href="#">Foodmap CSR</a></li>
                <li><a href="#">Hỗ Trợ <i class="fa fa-caret-down"></i></a></li>
                <li><a href="#">Cộng Tác Viên</a></li>
                <li><a href="#">Mua Sỉ</a></li>
            </ul>
        </aside>
    </div>

    <!-- navbar-2 -->
    <div class="navbar-2-bg">
        <div class="container">
            <ul class="d-flex justify-content-center align-items-center text-uppercase navbar-2">
                <li class="menu-item"><a class="navbar-a-menu-1" href="#"><i
                            class="fa-solid fa-bars px-1"></i><span>Danh mục sản
                            phẩm</span></a>

                    <!-- hover navbar dropdown my navbar-2-bg -->
                    <div class="dropdown-1">
                        <span class="text-black">
                            <a href="#">1232132132131221a3</a>
                            <div class="sub-dropdown-1">
                                <span class="">
                                    <a class="" href="#">12321321321312213</a>
                                </span>
                                <span class="">
                                    <a class="" href="#">12321321321312213</a>
                                </span>
                                <span class="">
                                    <a class="" href="#">12321321321312213</a>
                                </span>
                                <span class="">
                                    <a class="" href="#">12321321321312213</a>
                                </span>
                                <span class="">
                                    <a class="" href="#">12321321321312213</a>
                                </span>

                                <span class="">
                                    <a class="" href="#">12321321321312213</a>
                                </span>
                                <span class="">
                                    <a class="" href="#">12321321321312213</a>
                                </span>
                                <span class="">
                                    <a class="" href="#">12321321321312213</a>
                                </span>
                            </div>
                        </span>

                        <span class="text-black">
                            <a href="#">12321321321312213</a>
                        </span>

                        <span class="text-black">
                            <a href="#">12321321321312213</a>
                        </span>

                        <span class="text-black">
                            <a href="#">12321321321312213</a>
                        </span>

                        <span class="text-black">
                            <a href="#">12321321321312213</a>
                        </span>
                        <span class="text-black">
                            <a href="#">12321321321312213</a>
                        </span>

                        <span class="text-black">
                            <a href="#">12321321321312213</a>
                        </span>

                        <span class="text-black">
                            <a href="#">12321321321312213</a>
                        </span>

                        <span class="text-black">
                            <a href="#">12321321321312213</a>
                        </span>

                    </div>
                </li>

                <li><a href="#"><span>Sale đến 50%</span></a></li>

                <li>
                    <a href="#">
                        <img importance="high" src="{{ asset('component/header/img/navbar-2/icon-necessary.svg') }}"
                            alt="">
                        <span>Đi chợ online</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <img importance="high" class="img-fluid"
                            src="{{ asset('component/header/img/navbar-2/icon-fruit.svg') }}" alt="">
                        <span>Trái cây</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <img importance="high" class="img-fluid"
                            src="{{ asset('component/header/img/navbar-2/icon-tea-coffee.svg') }}"alt="">
                        <span>Trà - Cà Phê</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <img importance="high" class="img-fluid"
                            src="{{ asset('component/header/img/navbar-2/icon-specialties.svg') }}" alt="">
                        <span>Đặc sản</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <img class="img-fluid" src="{{ asset('component/header/img/navbar-2/icon-agri.svg') }}"alt="">
                        <span>Agrishow</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </a>
                </li>

                <li>
                    <a href="#"><span>Hỗ Trợ</span></a>

                    <!-- dropdown-2 -->
                    <div class="dropdown-last">
                        <span><a href="a">12321321321312213</a></span>
                        <span><a href="a">12321321321312213</a></span>
                        <span><a href="a">12321321321312213</a></span>
                        <span><a href="a">12321321321312213</a></span>
                        <span><a href="a">12321321321312213</a></span>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!-- banner-animation -->
    <div class="img-animation">
        <div class="container">
            <div class="row">
                <div class="col-9">
                    <!-- Tối ưu load image on website importance="high" -->
                    <img importance="high" loading="lazy" class="animation-header position-relative "
                        src="{{ asset('component/header/img/img-animation-1.jpg') }}" alt="FoodMap Promotion">

                    <!-- image-move-left-right -->
                    <div class="position-absolute">
                        <p><i class="fa-solid fa-chevron-left"></i></p>

                        <p><i class="fa-solid fa-chevron-right"></i></p>
                    </div>
                </div>
                <div class="col-3">
                    <ul class="animation-ul">
                        <li>
                            <a href="#">
                                <p class="text-uppercase">Tin nổi bật</p>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <img importance="high" class="animation-header-left-1"
                                    src="{{ asset('component/header/img/img-animation-1.jpg') }}"
                                    alt="FoodMap Promotion">
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <img importance="high" class="animation-header-left-2"
                                    src="{{ asset('component/header/img/img-animation-2.jpg') }}"
                                    alt="FoodMap Promotion">
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <img importance="high" class="animation-header-left-3"
                                    src="{{ asset('component/header/img/img-animation-6.jpg') }}"
                                    alt="FoodMap Promotion">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- js header -->
<script src="{{ asset('component/header/header.js') }}"></script>
