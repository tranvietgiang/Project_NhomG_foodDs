<!-- link css -->
<link rel="stylesheet" href="{{ asset('component/header/header.css') }}">

<style>
    li.li-suggest {
        transition: all 0.25s linear;
        cursor: pointer;
    }

    li.li-suggest:hover {
        background-color: #eeeeee;
    }
</style>
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

                    <!-- handle event input search -->
                    <li class="search-bar">
                        <form id="form-search" action="{{ route('seach') }}" method="get">
                            <div class="form-outline input-group mb-0 " data-mdb-input-init>
                                <input type="text" id="key-word" name="query" class="form-control" required>
                                <label class="form-label text-white" for="key-word">Nhập nội dung tìm kiếm</label>
                                <button class="btn btn-secondary" type="submit">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
                        <div id="search-suggestions"
                            style="position: absolute; background: white; width: 100%; display: none; box-shadow: 0 2px 5px rgba(0,0,0,0.2); z-index: 999;">
                        </div>

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
                            {{-- <a href=""><span style="font-size: 3em;"
                                    class="material-symbols-outlined">account_circle</span></a> --}}
                        @endif
                    </li>

                    <li style="margin-left: -20px">
                        @if (!Auth::check())
                            <a href="{{ route('wayLogin', ['page' => 'register']) }}"><span>Đăng ký</span></a>
                        @else
                            <a href="{{ url('/information-client') }}"><span>{{ Auth::user()->name }}</span></a>
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
                        <img class="img-fluid"
                            src="{{ asset('component/header/img/navbar-2/icon-agri.svg') }}"alt="">
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

    <!-- Zalo Official Chat Widget -->
    <div class="zalo-chat">
        <a href="https://zalo.me/0336833827" target="_blank">
            <img src="{{ asset('image-store/zalo.png') }}" alt="">
        </a>
    </div>

    <!-- run on top -->
    <button id="go-to-top" onclick="scrollToTop()">↑</button>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $("#key-word").on("input", function() {
        let search = $(this).val().trim().toLowerCase();

        if (search.length === 0) {
            $("#search-suggestions").hide();
            return;
        }

        $.ajax({
            url: "{{ route('header.show.render') }}",
            type: "GET",
            data: {
                valueSearch: search,
                _token: "{{ csrf_token() }}",
            },
            success: function(response) {
                /* reason(lý do) why attached variable currentInput = search on top
                                            Vì search được gán trước khi gọi Ajax, còn success là callback bất đồng bộ, nó được chạy sau khi nhận phản hồi từ server.
                                            Trong thời gian chờ server trả kết quả, người dùng có thể đã gõ hoặc xóa thêm ⇒ giá trị ô input đã thay đổi, nhưng biến search thì vẫn là giá trị cũ.*/
                let currentInput = $("#key-word").val().trim().toLowerCase();

                console.log(currentInput);
                if (currentInput == "") {
                    $("#search-suggestions").hide();
                    return;
                }

                const products = response.data;
                let html = "";

                // Gợi ý tìm kiếm (hiển thị phía trên)
                let htmlSuggest =
                    `<div><h5>Gợi ý tìm kiếm</h5><ul style="all:unset; padding: 0; margin: 0">`;
                products.forEach((item) => {
                    htmlSuggest += ` 
                    <li class="li-suggest">
                        <form method="GET" action="{{ route('seach') }}">
                            @csrf
                            <input type="hidden" value="${item.product_name}" name="query">
                            <button type="submit" style="background: none; border: none; cursor: pointer;">
                                <p style="margin: 0;">${item.product_name}</p>
                            </button>
                        </form> 
                    </li>`;
                });
                htmlSuggest += `</ul></div>`;

                // Danh sách sản phẩm
                let htmlItem = `<div><h4>Kết quả</h4><ul style="all:unset; padding: 0; margin: 0">`;
                const showCartBaseUrl = "{{ route('show_cart', ['product_id' => '__ID__']) }}";

                products.forEach((item) => {
                    const url = showCartBaseUrl.replace('__ID__', item.product_id);

                    const highlightedName = item.product_name.replace(
                        new RegExp(search, "gi"),
                        (match) => `<mark>${match}</mark>`
                    );

                    htmlItem += `
                    <li style="border-bottom: 1px solid #eeeeee; padding: 5px 0" class="d-block li-suggest">
                        <a href="${url}" class="d-block" style="all: unset;">
                            <div class="d-flex gap-4">
                                <img src="component/image-product/${item.product_image}" alt="" width="40" height="40">
                                <div class="">
                                    <div class="fw-bold">${highlightedName}</div>
                                    <div style="color: #000;">${item.product_price} ₫</div>
                                </div>
                            </div>
                        </a>
                    </li>`;
                });
                htmlItem += "</ul></div>";

                // Gộp lại toàn bộ
                html = htmlSuggest + htmlItem;

                // Gắn vào DOM
                $("#search-suggestions").html(html).show();

            },
            error: function(xhr) {
                console.error(xhr.responseText);
            },
        });
    });
</script>
<!-- js header -->
<script src="{{ asset('component/header/header.js') }}"></script>
