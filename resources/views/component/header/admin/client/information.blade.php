<!-- git thông tin khách hàng -->
<link rel="stylesheet" href="{{ asset('component/css/mdb.min.css') }}">
<!-- Link icon  -->
<link rel="Website icon" type="png" href="{{ asset('logo-website/login.png') }}">
<!-- Link fontawesome  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<!-- link google icon -->
<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=account_circle" />

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

    /* phần code css của page============================================================================ */

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
                        {{-- <a href="{{ url('/information-client') }}"><span style="font-size: 3em;"
                                class="material-symbols-outlined">account_circle</span></a> --}}
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

    <body>
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


                        <!-- avatar -->
                        <p>
                            <!-- hiện ra ảnh cho clien xem trước -->
                            <img id="show-avatar"
                                style="width: 100%; height: 100%; object-fit: cover; border: 5px solid green"
                                <?php $avatar_user_default = 'avatar_default.png'; ?>
                                src="{{ asset('image-store/' . (!empty($client_image->client_avatar) ? $client_image->client_avatar : $avatar_user_default)) }}"
                                class="thumbnail" onclick="showLightbox(this.src)">

                            <!-- btn-save update avatar vào db -->
                        <form action="{{ url('client-avatar-image-update') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input class="d-none" id="avatar-client" type="file" name="avatar-client">
                            <label class="position-relation " id="select-avatar"
                                style='margin:-40px 0 0 10px; cursor: pointer; z-index: 5;' for="avatar-client">
                                <i style="display: inline-block; position: absolute; font-size: 18px"
                                    class="fas fa-camera"></i>
                            </label>

                            <!-- gửi yêu cầu -->
                            <input class="d-none" id="label-replace" type="submit">
                            <label class="btn-save" id="label-replace" style='margin:-22px 0 0 10px; cursor: pointer;'
                                for="label-replace">
                                <i style="margin: -17px 0 0 -2px;"
                                    class="fw-100 text-success fa-solid fa-circle-check"></i>
                            </label>
                        </form>
                        <!-- phần click vào to ảnh -->
                        <div class="lightbox" id="lightbox" onclick="hideLightbox()">
                            <img id="lightbox-img" />
                        </div>
                        </p>


                        <!-- hiện name & email -->
                        <p>
                            <strong>{{ Auth::user()->name }}</strong><br>{{ Auth::user()->email }}
                        </p>
                        <a href="#">Số dư </a>
                        <a href="{{ route('MyOrder.information') }}">Lịch sử đơn hàng </a>
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
                <!-- Formulaire -->
                <div class="col-md-9">
                    {{-- <!-- show error phải dùng validate -->
                    @if ($errors->any())
                        <!-- Kiểm tra nếu có lỗi validation nào không -->
                        <div class="alert alert-danger">
                            <ul style="list-style: none;">
                                <!-- Lấy tất cả lỗi validation hiện tại -->
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}


                    @foreach ($errors->all() as $error)
                        @if ($loop->first)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endif
                    @endforeach


                    <!-- check update có success -->
                    @if (session('update_client_success'))
                        <div class="alert alert-success">{{ session('update_client_success') }}</div>
                    @endif

                    <!-- client_phone_unique -->
                    @if (session('client_phone_unique'))
                        <div class="alert alert-warning">{{ session('client_phone_unique') }}</div>
                    @endif

                    <!-- client_date -->
                    @if (session('date_int'))
                        <div class="alert alert-warning">{{ session('date_int') }}</div>
                    @endif

                    <!-- client_gender -->
                    @if (session('check_gender'))
                        <div class="alert alert-warning">{{ session('check_gender') }}</div>
                    @endif

                    <h5 class="fw-bold btn btn-success">Thông tin tài khoản</h5>
                    <form action="{{ route('update_client') }}" method="POST">
                        @csrf
                        <!-- 2 column grid layout with text inputs for the first and last names -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <input type="text" id="form6Example2" name="client_name"
                                value="{{ Auth::user()->name }}" class="form-control" required />
                            <label class="form-label" for="form6Example2"> name</label>
                        </div>


                        <!-- lấy dữ liệu thông tin show ra nếu có -->
                        @php

                            $client = optional(Auth::user())->client;
                            $address = $client ? $client->client_address : null;
                            $addressParts = $address ? explode(',', $address) : [];

                            $province = $addressParts[0] ?? null;
                            $district = $addressParts[1] ?? null;
                            $ward = $addressParts[2] ?? null;

                        @endphp

                        <!-- Thành phố (City) -->
                        <div class="form-group mb-4">
                            <select id="province" name="client_province" class="form-control">
                                <option style="color: #000" value="" disabled selected>
                                    {{ !empty(trim($province)) ? $province : 'Thành Phố' }}
                                </option>

                                @foreach ($provinces as $item)
                                    <option value="{{ $item->province_id }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Quận huyện (District) -->
                        <div class="form-group mb-4">
                            <select id="district" name="client_district" class="form-control">
                                <option value="{{ $district ?? null }}" disabled selected>
                                    {{ $district ?? 'Quận/Huyện' }}
                                </option>

                            </select>
                        </div>

                        <!-- Phường/Xã (Ward) -->
                        <div class="form-group mb-4">
                            <select id="wards" name="client_wards" class="form-control">
                                <option value="" disabled selected>
                                    {{ $ward ?? 'Phường/Xã' }}
                                </option>

                            </select>
                        </div>

                        <!-- Email input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <input type="email" value="{{ Auth::user()->email }}" id="form6Example5"
                                class="form-control"readonly />
                            <label class="form-label" for="form6Example5">Email</label>
                        </div>

                        <!-- Number input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <input type="text" id="form6Example6" name="client_phone" class="form-control"
                                pattern="[0-9]{10}" inputmode="numeric" maxlength="10"
                                value="{{ optional(Auth::user()->client)->client_phone ?? '' }}" />
                            <label class="form-label" for="form6Example6">Số điện thoại *</label>
                        </div>

                        <!-- address detail -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <input style="height: 100px" name="client_address_detail" type="text"
                                id="form6Example6"
                                value="{{ optional(Auth::user()->client)->client_address_detail ?? '' }}"
                                class="form-control" />
                            <label class="form-label" for="form6Example6">Address detail(không bắt buộc) *</label>
                        </div>


                        <!-- Giới tính (Gender) -->
                        <div class="mb-4">
                            <label class="form-label">Giới tính</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="client_gender" id="male"
                                    value="Nam"
                                    {{ optional(Auth::user()->client)->client_gender === 'Nam' ? 'checked' : '' }}
                                    checked />
                                <label class="form-check-label" for="male">Nam</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="client_gender" id="female"
                                    value="Nữ"
                                    {{ optional(Auth::user()->client)->client_gender === 'Nu' ? 'checked' : '' }} />
                                <label class="form-check-label" for="female">Nữ</label>
                            </div>
                        </div>

                        <!-- lấy dữ liệu thông tin show ra nếu có -->
                        @php
                            $dat_of_birth = explode('/', optional(Auth::user()->client)->dat_of_birth);
                        @endphp

                        <!-- Sinh nhật (Birthday) -->
                        <div class="row mb-4">
                            <div class="col">
                                <select name="client_day" id="daySelect" class="form-control">
                                    <option value="{{ $dat_of_birth[0] }}" selected>
                                        {{ !empty($dat_of_birth[0]) ? $dat_of_birth[0] : 'ngày' }}
                                    </option>
                                    @foreach ($day as $item)
                                        <option value="{{ $item->day }}">{{ $item->day }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <select id="monthSelect" name="client_month" class="form-control">
                                    <option value="{{ $dat_of_birth[1] ?? null }}" selected>
                                        {{ $dat_of_birth[1] ?? 'Month' }}
                                    </option>
                                </select>
                            </div>

                            <div class="col">
                                <select id="year" name="client_year" class="form-control">
                                    <option value="{{ $dat_of_birth[2] ?? null }}" selected>
                                        <!-- cần sửa lại mỗi lần mà session hết thời gian thì nó sẽ ko coàn hiện nx -->
                                        {{ $dat_of_birth[2] ?? 'Year' }}
                                    </option>
                                    @foreach ($year as $item)
                                        <option value="{{ $item->id }}">{{ $item->year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <!-- Note -->
                        <p style="font-size: 12px; color: gray;">
                            * Để thay đổi số điện thoại, vui lòng nhắn tin vào và nhập nút Cập nhật bên cạnh số điện
                            thoại để liên hệ với chúng tôi qua <a href="#">Thông tin liên hệ</a>
                        </p>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-success btn-block mb-4">LƯU THAY ĐỔI</button>
                    </form>
                </div>
            </div>
        </div>
</section>

<script src="{{ asset('component/js/mdb.umd.min.js') }}"></script>


<!-- JavaScript để chỉ cho phép nhập số -->
<script>
    document.getElementById('form6Example6').addEventListener('input', function(e) {
        // Chỉ giữ lại các ký tự số
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    document.addEventListener("DOMContentLoaded", function() {
        const daySelect = document.getElementById("daySelect");
        const monthSelect = document.getElementById("monthSelect");

        const monthsWith31Days = [1, 3, 5, 7, 8, 10, 12];

        // Khi user chọn ngày
        daySelect.addEventListener("change", function() {
            const selectedDay = parseInt(this.value);
            monthSelect.innerHTML = '<option value=""disabled selected>Tháng</option>';

            // Chỉ hiển thị tháng có 31 ngày
            if (selectedDay === 31) {
                monthsWith31Days.forEach(month => {
                    monthSelect.innerHTML += `<option value="${month}">${month}</option>`;
                });
            } else {
                // Hiển thị tất cả các tháng
                for (let month = 1; month <= 12; month++) {
                    monthSelect.innerHTML += `<option value="${month}">${month}</option>`;
                }
            }
        });
    });
</script>

<!-- link ajax -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $("#province").change(function() {
        let province_id = $(this).val(); // Lấy giá trị province_id từ dropdown tỉnh/thành phố
        $.ajax({
            url: "/get-districts",
            type: "POST",
            data: {
                province_id: province_id,
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                // Cập nhật dropdown quận huyện, xóa tất cả các option cũ
                $("#district").html('<option value="">Chọn quận/huyện</option>');
                $.each(data, function(key, value) { // Duyệt qua danh sách quận huyện trả về
                    // Thêm các option mới vào dropdown quận huyện
                    $("#district").append(
                        `<option value="${value.district_id}">${value.name}</option>`);
                });
            }
        });
    });



    // Khi chọn quận/huyện
    $("#district").change(function() {
        let district_id = $(this).val(); // Lấy giá trị district_id từ dropdown quận/huyện
        $.ajax({
            url: "/get-wards", // Gửi yêu cầu đến đường dẫn route route('/get-wards')
            type: "POST", // Gửi yêu cầu POST
            data: {
                district_id: district_id, // Truyền district_id qua dữ liệu yêu cầu
                _token: "{{ csrf_token() }}" // CSRF token để bảo vệ yêu cầu khỏi tấn công CSRF
            },
            success: function(data) { // Khi server trả về dữ liệu
                // Cập nhật dropdown phường xã, xóa tất cả các option cũ
                $("#wards").html('<option value="">Chọn phường/xã</option>');
                $.each(data, function(key, value) { // Duyệt qua danh sách phường xã trả về
                    // Thêm các option mới vào dropdown phường xã
                    $("#wards").append(
                        `<option value="${value.wards_id}">${value.name}</option>`);
                });
            }
        });
    });


    //phần click vào to ảnh
    function showLightbox(src) {
        document.getElementById("lightbox-img").src = src;
        document.getElementById("lightbox").style.display = "flex";
    }

    function hideLightbox() {
        document.getElementById("lightbox").style.display = "none";
    }

    // hiện ra ảnh cho clien xem trước
    const select_avatar = document.querySelector('#select-avatar')
    const btn_save = document.querySelector('.btn-save')

    function show_avatar() {
        const avatar = document.getElementById('avatar-client').files;
        if (avatar.length > 0) {

            btn_save.classList.add('btn-avatar');
            select_avatar.classList.add('btn-save')

            const storeAvatar = avatar[0];
            const readAvatar = new FileReader();

            readAvatar.onload = (e) => {
                const copy_src = e.target.result;
                const pathAvatar = document.getElementById('show-avatar');
                if (pathAvatar.tagName === 'IMG') {
                    pathAvatar.src = copy_src;
                }
            };
            readAvatar.readAsDataURL(storeAvatar);
        }
    }

    // Tự động gọi show_avatar() khi chọn file
    document.getElementById('avatar-client').addEventListener('change', show_avatar);
</script>
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
