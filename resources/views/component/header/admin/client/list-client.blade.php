    <link rel="stylesheet" href="{{ asset('component/css/mdb.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        * {
            overflow: hidden;
            margin: 0;
            padding: 0;
        }

        /* Sidebar */
        .sidebar {
            background: linear-gradient(180deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            min-height: 100vh;
            width: 220px;
            position: relative;
            top: 0;
            left: 0;
            z-index: 1000;
            padding: 0;
        }

        .nav-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-links li {
            margin: 0;
        }

        .nav-links a {
            color: #d1d8e0;
            display: flex;
            align-items: center;
            padding: 12px 20px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .nav-links a i {
            margin-right: 10px;
        }

        .nav-links a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .nav-links li.active a {
            background-color: #3498db;
            color: white;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: white;
            padding: 10px 20px;
            border-radius: 50px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .user-info span {
            font-size: 14px;
            color: #2c3e50;
        }

        .user-info i {
            font-size: 20px;
            color: #3498db;
        }

        nav {
            background: ##3498db;
        }
    </style>
    <section class="row">
        <!-- Sidebar -->
        <div class="sidebar col-4">
            <ul class="nav-links">
                <li class="d-flex justify-content-center m-4">
                    <h3>Dashboard</h3>
                </li>
                <li><a href=""><i class="fas fa-users"></i> Quản Lý Nhân Viên</a></li>
                <li class="active"><a href="product.html"><i class="fas fa-box"></i> Quản Lý Sản Phẩm</a></li>
                <li><a href="#"><i class="fas fa-envelope"></i> Tin Nhắn</a></li>
                <li><a href="#"><i class="fas fa-question-circle"></i> Hỗ Trợ</a></li>
                <li><a href="#"><i class="fas fa-cog"></i> Cài Đặt</a></li>
                <li><a href="#"><i class="fas fa-lock"></i> Mật Khẩu</a></li>
                <li><a href="#"><i class="fas fa-sign-out-alt"></i> Đăng Xuất</a></li>
            </ul>
        </div>


        <div class="table-container mt-4 col-9">

            @include('component.header.admin.keThua.navbar-logout')
            <!-- show list client -->
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên Người Tiêu Dùng</th>
                        <th>Email</th>
                        <th>Số Điện Thoại</th>
                        <th>Trạng Thái</th>
                        <th>Ngày tạo</th>
                    </tr>
                </thead>
                <tbody id="customer-table-body">
                    <!-- Dữ liệu mẫu -->
                    <tr>
                        <td>1</td>
                        <td>Nguyễn Văn A</td>
                        <td>nguyenvana@gmail.com</td>
                        <td>0901234567</td>
                        <td><span class="badge bg-success">Hoạt động</span></td>
                        <td>20-02-2005</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Trần Thị B</td>
                        <td>tranb@gmail.com</td>
                        <td>0912345678</td>
                        <td><span class="badge bg-danger">Không hoạt động</span></td>
                        <td>20-02-2005</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <script src="{{ asset('component/js/mdb.umd.min.js') }}"></script>
