<link rel="stylesheet" href="{{ asset('component/header/product-employees.css') }}">
<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <i class="fas fa-home"></i>
        </div>
        <ul class="nav-links">
            <li><a href="employee.html"><i class="fas fa-users"></i> Quản Lý Nhân Viên</a></li>
            <li class="active"><a href="product.html"><i class="fas fa-box"></i> Quản Lý Sản Phẩm</a></li>
            <li><a href="#"><i class="fas fa-envelope"></i> Tin Nhắn</a></li>
            <li><a href="#"><i class="fas fa-question-circle"></i> Hỗ Trợ</a></li>
            <li><a href="#"><i class="fas fa-cog"></i> Cài Đặt</a></li>
            <li><a href="#"><i class="fas fa-lock"></i> Mật Khẩu</a></li>
            <li><a href="#"><i class="fas fa-sign-out-alt"></i> Đăng Xuất</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <input type="text" placeholder="Tìm kiếm...">
            <div class="user-info">
                <span>Nhân Thoạt</span>
                <i class="fas fa-user-circle"></i>
            </div>
        </div>

        <!-- Form Quản Lý Sản Phẩm -->
        <div class="form-container">
            <h2>Quản Lý Sản Phẩm</h2>
            <form>
                <div class="form-group">
                    <label for="product-name">Tên Sản Phẩm</label>
                    <input type="text" id="product-name" name="product-name" placeholder="Nhập tên sản phẩm"
                        required>
                </div>
                <div class="form-group">
                    <label for="product-price">Giá (VNĐ)</label>
                    <input type="number" id="product-price" name="product-price" placeholder="Nhập giá sản phẩm"
                        required>
                </div>
                <div class="form-group">
                    <label for="product-quantity">Số Lượng</label>
                    <input type="number" id="product-quantity" name="product-quantity" placeholder="Nhập số lượng"
                        required>
                </div>
                <div class="form-group">
                    <label for="product-status">Trạng Thái</label>
                    <select id="product-status" name="product-status" required>
                        <option value="in-stock">Còn hàng</option>
                        <option value="low-stock">Sắp hết hàng</option>
                        <option value="out-of-stock">Hết hàng</option>
                    </select>
                </div>
                <button type="submit">Thêm Sản Phẩm</button>
            </form>
        </div>
    </div>
</div>
