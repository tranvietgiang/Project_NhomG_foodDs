<link rel="stylesheet" href="{{ asset('component/css/mdb.min.css') }}">
<form action="{{ route('staff.edit', ['staff' => $employee->id]) }}" method="POST">
    @csrf
    @method('PUT')
    <!-- Đảm bảo sử dụng PUT cho update -->
    <h1>Chỉnh sửa nhân viên</h1>
    <div class="form-group mb-3">
        <label for="name">Tên Nhân Viên</label>
        <input type="text" name="staff_name" id="name" value="{{ $employee->name }}" class="form-control" required>
    </div>

    <div class="form-group mb-3">
        <label for="email">Email</label>
        <input type="text" name="staff_email" id="email" value="{{ $employee->email }}" class="form-control"
            required>
    </div>

    <div class="form-group mb-3">
        <label for="phone">Số Điện Thoại</label>
        <input type="phone" name="staff_phone" id="phone" value="{{ $employee->phone }}" class="form-control"
            required>
    </div>

    <div class="form-group mb-3">
        <label for="role">Vai Trò</label>
        <select name="staff_role" id="role" class="form-control" required>
            <option value="{{ $employee->role }}">{{ $employee->role }}</option>
            <option value="admin" {{ $employee->role == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="staff" {{ $employee->role == 'staff' ? 'selected' : '' }}>Nhân viên</option>
            <option value="manager" {{ $employee->role == 'manager' ? 'selected' : '' }}>Quản lý</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Cập Nhật</button>
</form>
