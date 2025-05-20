<link rel="stylesheet" href="{{ asset('component/css/mdb.min.css') }}">
<form action="" method="POST">
    @csrf
    <!-- Đảm bảo sử dụng PUT cho update -->
    <h1>Thêm nhân viên nhân viên</h1>
    <div class="form-group mb-3">
        <label for="name">Tên Nhân Viên</label>
        <input type="text" name="staff_name" id="name" class="form-control" required>
    </div>

    <div class="form-group mb-3">
        <label for="email">Email</label>
        <input type="text" name="staff_email" id="email" class="form-control" required>
    </div>

    <div class="form-group mb-3">
        <label for="phone">Số Điện Thoại</label>
        <input type="phone" name="staff_phone" id="phone" class="form-control" required>
    </div>

    <div class="form-group mb-3">
        <label for="role">Vai Trò</label>
        <select name="staff_role" id="role" class="form-control" required>
            <option value="admin">Admin</option>
            <option value="staff">Nhân viên</option>
            <option value="manager">Quản lý</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Thêm nhân viên</button>
</form>
