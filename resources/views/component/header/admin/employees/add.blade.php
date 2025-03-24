<link rel="stylesheet" href="{{ asset('component/header/product-employees.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<div class="container">
    <!-- Main Content -->
    <div class="main-content">
        <!-- Sidebar -->
        <div class="sidebar col-3">
            <div class="logo">
                <span>Admin</span>
            </div>
            <ul class="nav-links">
                <li class="active"><a href="employee.html"><i class="fas fa-users"></i> Quản Lý Nhân Viên</a></li>
                <li><a href="product.html"><i class="fas fa-box"></i> Quản Lý Sản Phẩm</a></li>
                <li><a href="#"><i class="fas fa-envelope"></i> Tin Nhắn</a></li>
                <li><a href="#"><i class="fas fa-question-circle"></i> Hỗ Trợ</a></li>
                <li><a href="#"><i class="fas fa-sign-out-alt"></i> Đăng Xuất</a></li>
            </ul>
        </div>
        <!-- Header -->
        <div class="header">
            <h1>Quản Lý Nhân Viên</h1>
            <div class="user-info">
                <span>Nhân Thoạt</span>
                <i class="fas fa-user-circle"></i>
            </div>
        </div>

        <!-- Form Quản Lý Nhân Viên -->
        <div class="form-container">
            <form>
                <div class="form-group">
                    <label for="employee-name">Tên Nhân Viên</label>
                    <input type="text" id="employee-name" name="employee-name" placeholder="Nhập tên nhân viên"
                        required>
                </div>
                <div class="form-group">
                    <label for="employee-position">Chức Vụ</label>
                    <input type="text" id="employee-position" name="employee-position" placeholder="Nhập chức vụ"
                        required>
                </div>
                <div class="form-group">
                    <label for="employee-salary">Lương (VNĐ)</label>
                    <input type="number" id="employee-salary" name="employee-salary" placeholder="Nhập lương" required>
                </div>
                <div class="form-group">
                    <label for="employee-status">Trạng Thái</label>
                    <select id="employee-status" name="employee-status" required>
                        <option value="active">Đang làm việc</option>
                        <option value="inactive">Nghỉ việc</option>
                    </select>
                </div>
                <button type="submit">Thêm Nhân Viên</button>
            </form>
        </div>
    </div>
</div>
