<link rel="stylesheet" href="{{ asset('component/css/mdb.min.css') }}">
<section class="container ">
    <style>
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
    </head>

    <body>
        <div class="container mt-5">
            <div class="row">
                <!-- Barre latérale -->
                <div class="col-md-3">
                    <div class="sidebar">
                        <h5>Tài khoản</h5>
                        <p><strong>WED GIANG</strong><br>wedgiang@gmail.com</p>
                        <a href="#" class="active">Thông tin cá tui</a>
                        <a href="#">Số dư của tui</a>
                        <a href="#">Đơn hàng của tui</a>
                        <a href="#">My Farm</a>
                        <a href="#">Voucher của tui</a>
                        <a href="#">Sản phẩm yêu thích</a>
                        <a href="#">Nhật xét của tui</a>
                        <a href="#">Thông báo của tui</a>
                        <a href="#">X Đăng xuất</a>
                        <a href="#" class="text-success mt-3">Bán hàng cùng foodmap</a>
                    </div>
                </div>

                <!-- Formulaire -->
                <div class="col-md-9">
                    <form>
                        <!-- 2 column grid layout with text inputs for the first and last names -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <input type="text" id="form6Example2" class="form-control" />
                            <label class="form-label" for="form6Example2"> name</label>
                        </div>


                        <!-- Text input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <input type="text" id="form6Example4" class="form-control" />
                            <label class="form-label" for="form6Example4">SDT</label>
                        </div>

                        <!-- Thành phố (City) -->
                        <div class="form-group mb-4">
                            <select id="city" class="form-control">
                                <option value="" disabled selected>Thành phố</option>
                                <option value=""></option>
                            </select>
                        </div>

                        <!-- Quận huyện (District) -->
                        <div class="form-group mb-4">
                            <select id="district" class="form-control">
                                <option value="" disabled selected>Quận/Huyện</option>
                                <option value=""></option>
                            </select>
                        </div>

                        <!-- Phường/Xã (Ward) -->
                        <div class="form-group mb-4">
                            <select id="ward" class="form-control">
                                <option value="" disabled selected>Phường/Xã</option>
                                <option value=""></option>
                            </select>
                        </div>

                        <!-- Email input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <input type="email" id="form6Example5" class="form-control" />
                            <label class="form-label" for="form6Example5">Email</label>
                        </div>

                        <!-- Number input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <input type="text" id="form6Example6" class="form-control" pattern="[0-9]{10}"
                                inputmode="numeric" maxlength="10" />
                            <label class="form-label" for="form6Example6">Số điện thoại *</label>
                        </div>

                        <!-- Giới tính (Gender) -->
                        <div class="mb-4">
                            <label class="form-label">Giới tính</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="male"
                                    value="Nam" />
                                <label class="form-check-label" for="male">Nam</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="female"
                                    value="Nữ" />
                                <label class="form-check-label" for="female">Nữ</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="other"
                                    value="Khác" checked />
                                <label class="form-check-label" for="other">Khác</label>
                            </div>
                        </div>

                        <!-- Sinh nhật (Birthday) -->
                        <div class="row mb-4">
                            <div class="col">
                                <select id="day" class="form-control">
                                    <option value="" disabled selected>Ngày</option>
                                    <option value="1">1</option>
                                    <!-- Ajouter plus de jours si nécessaire -->
                                </select>
                            </div>

                            <div class="col">
                                <select id="month" class="form-control">
                                    <option value="" disabled selected>Tháng</option>
                                    <option value="1">1</option>
                                    <!-- Ajouter plus de mois si nécessaire -->
                                </select>
                            </div>

                            <div class="col">
                                <select id="year" class="form-control">
                                    <option value="" disabled selected>Năm</option>
                                    <option value="2000">2000</option>
                                    <!-- Ajouter plus d'années si nécessaire -->
                                </select>
                            </div>
                        </div>

                    </form>
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
        </div>
</section>

<script src="{{ asset('component/js/mdb.umd.min.js') }}"></script>

<!-- JavaScript để chỉ cho phép nhập số -->
<script>
    document.getElementById('form6Example6').addEventListener('input', function(e) {
        // Chỉ giữ lại các ký tự số
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>
