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
                    <a class="d-flex justify-content-center align-items-center" href="{{ url('/information-client') }}">
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


<section class="container">

    <body>
        <div class="container mt-5">
            <div class="row">
                <!-- Barre latérale -->
                <div class="col-md-3">
                    <div class="sidebar">
                        <h5>Tài khoản</h5>
                        <p><strong>{{ session('role_client') }}</strong><br>{{ session('role_client_email') }}</p>
                        <a href="#">Số dư </a>
                        <a href="#">Đơn hàng </a>
                        <a href="#">My Farm</a>
                        <a href="#">Voucher </a>
                        <a href="#">Sản phẩm yêu thích</a>
                        <a href="#">Nhật xét </a>
                        <a href="#">Thông báo </a>
                        <!-- logout  -->
                        <div class="">
                            <!-- check user login yet? -->
                            @if (Auth::check())
                                <form style="z-index: 1" class="" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-link text-black">Đăng xuất</button>
                                </form>
                            @endif
                        </div>
                        <a href="#" class="text-success mt-3">Bán hàng cùng foodmap</a>
                    </div>
                </div>
                <!-- Formulaire -->
                <div class="col-md-9">

                    <!-- show error phải dùng validate -->
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
                    @endif

                    <!-- check update có success -->
                    @if (session('update_client_success'))
                        <div class="alert alert-success">{{ session('update_client_success') }}</div>
                    @endif
                    <h5 class="fw-bold">Thông tin tài khoản</h5>
                    <form action="{{ route('update_client') }}" method="POST">
                        @csrf
                        <!-- 2 column grid layout with text inputs for the first and last names -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <input type="text" id="form6Example2" name="client_name"
                                value="{{ session('role_client') }}" class="form-control" required />
                            <label class="form-label" for="form6Example2"> name</label>
                        </div>

                        <!-- Thành phố (City) -->
                        <div class="form-group mb-4">
                            <select id="province" name="client_province" class="form-control" required>
                                <option value="" disabled selected>
                                    @if (session('client_province'))
                                        {{ session('client_province') }}
                                    @else
                                        Thành phố
                                    @endif
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
                            <select id="district" name="client_district" class="form-control" required>
                                <option value="" disabled selected>
                                    @if (session('client_district'))
                                        {{ session('client_district') }}
                                    @else
                                        Quận/Huyện
                                    @endif
                                </option>
                            </select>
                        </div>

                        <!-- Phường/Xã (Ward) -->
                        <div class="form-group mb-4">
                            <select id="wards" name="client_wards" class="form-control">
                                <option value="" disabled selected>
                                    @if (session('client_wards'))
                                        {{ session('client_wards') }}
                                    @else
                                        Phường/Xã
                                    @endif
                                </option>
                            </select>
                        </div>

                        <!-- Email input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <input type="email" value="{{ session('role_client_email') }}" id="form6Example5"
                                class="form-control" required />
                            <label class="form-label" for="form6Example5">Email</label>
                        </div>

                        <!-- Number input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <input type="text" id="form6Example6" name="client_phone" class="form-control"
                                pattern="[0-9]{10}" inputmode="numeric" maxlength="10" required
                                @if (session('client_phone')) value="  {{ session('client_phone') }}" @endif />
                            <label class="form-label" for="form6Example6">Số điện thoại *</label>
                        </div>

                        <!-- address detail -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <input style="height: 100px" name="client_address_detail" type="text"
                                id="form6Example6" value="" class="form-control" />
                            <label class="form-label" for="form6Example6">Address detail(không bắt buộc) *</label>
                        </div>


                        <!-- Giới tính (Gender) -->
                        <div class="mb-4">
                            <label class="form-label">Giới tính</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="client_gender" id="male"
                                    value="Nam" />
                                <label class="form-check-label" for="male">Nam</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="client_gender" id="female"
                                    value="Nữ" />
                                <label class="form-check-label" for="female">Nữ</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="client_gender" id="other"
                                    value="Khác" checked />
                                <label class="form-check-label" for="other">Khác</label>
                            </div>
                        </div>

                        <!-- Sinh nhật (Birthday) -->
                        <div class="row mb-4">
                            <div class="col">
                                <select name="client_day" id="daySelect" class="form-control" required>
                                    <option value="" disabled selected>
                                        @if (session('client_day'))
                                            {{ session('client_day') }}
                                        @else
                                            Ngày
                                        @endif
                                    </option>
                                    @foreach ($day as $item)
                                        <option value="{{ $item->day }}">{{ $item->day }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <select id="monthSelect" name="client_month" class="form-control" required>
                                    <option value="" disabled selected>
                                        @if (session('client_month'))
                                            {{ session('client_month') }}
                                        @else
                                            Tháng
                                        @endif
                                    </option>
                                </select>
                            </div>

                            <div class="col">
                                <select id="year" name="client_year" class="form-control" required>
                                    <option value="" disabled selected>
                                        @if (session('client_year'))
                                            {{ session('client_year') }}
                                        @else
                                            Năm
                                        @endif
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
            url: "/get-districts", // Gửi yêu cầu đến đường dẫn "/get-districts" (server-side)
            type: "POST", // Gửi yêu cầu POST
            data: {
                province_id: province_id, // Truyền province_id qua dữ liệu yêu cầu
                _token: "{{ csrf_token() }}" // CSRF token để bảo vệ yêu cầu khỏi tấn công CSRF
            },
            success: function(data) { // Khi server trả về dữ liệu
                // Cập nhật dropdown quận huyện, xóa tất cả các option cũ
                $("#district").html('<option value="">Chọn quận/huyện</option>');
                $.each(data, function(key, value) { // Duyệt qua danh sách quận huyện trả về
                    // Thêm các option mới vào dropdown quận huyện
                    $("#district").append('<option value="' + value.district_id + '">' +
                        value.name + '</option>');
                });
            }
        });
    });



    // Khi chọn quận/huyện
    $("#district").change(function() {
        let district_id = $(this).val(); // Lấy giá trị district_id từ dropdown quận/huyện
        $.ajax({
            url: "/get-wards", // Gửi yêu cầu đến đường dẫn route "/get-wards" (server-side)
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
                    $("#wards").append('<option value="' + value.wards_id + '">' +
                        value.name + '</option>');
                });
            }
        });
    });
</script>
