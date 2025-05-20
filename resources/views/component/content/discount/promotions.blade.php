<link rel="stylesheet" href="{{ asset('component/css/mdb.min.css') }}">
<style>
    * {
        overflow-x: hidden;
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
</style>

<section class="row">
    <!-- Sidebar -->
    <div class="sidebar col-4">
        <ul class="nav-links">
            <li class="d-flex justify-content-center m-4">
                <h3>Dashboard</h3>
            </li>
            <!-- nếu admin đổi thành quản lý -->
            @if (Auth::check() && Auth::user()->role == 'admin')
                <li class="active"><a href="#"><i class="fas fa-users"></i> Quản Lý Mã giảm giá</a>
                </li>
            @else
                <li class="active"><a href=""><i class="fas fa-users"></i> DS Mã giảm giá</a>
                </li>
            @endif

            </li>
            <!-- nếu admin đổi thành quản lý -->
            @if (Auth::check() && Auth::user()->role == 'admin')
                <li class=""><a href="{{ route('employees') }}"><i class="fas fa-users"></i> Quản Lý Nhân Viên</a>
                </li>
            @else
                <li class=""><a href="{{ route('employees') }}"><i class="fas fa-users"></i> DS Nhân Viên</a></li>
            @endif


            <!-- page product -->
            @if (Auth::check() && Auth::user()->role == 'admin')
                <li class=""><a href="{{ route('admin.view.product') }}"><i class="fas fa-box"></i> Quản Lý Sản
                        Phẩm</a></li>
            @else
                <li><a href="{{ route('admin.view.product') }}"><i class="fas fa-box"></i> DS Sản Phẩm</a></li>
            @endif

            <!-- page categories -->
            @if (Auth::check() && Auth::user()->role == 'admin')
                <li class=""><a href="{{ url('categories') }}"><i class="fas fa-box"></i> Quản Lý Phân loại</a>
                </li>
            @else
                <li><a href="{{ url('categories') }}"><i class="fas fa-box"></i> DS Phân loại</a></li>
            @endif

            <!-- page client -->
            @if (Auth::check() && Auth::user()->role == 'admin')
                <li><a href="{{ route('manager') }}"><i class="fas fa-box"></i> Quản Lý khách hàng</a>
                </li>
            @else
                <li><a href="{{ route('manager') }}"><i class="fas fa-box"></i> DS khách hàng</a></li>
            @endif

            <!-- page client -->
            @if (Auth::check() && Auth::user()->role == 'admin')
                <li><a href="{{ route('manager') }}"><i class="fas fa-box"></i> Thống kê</a>
                </li>
            @endif

            <li><a href="#"><i class="fas fa-envelope"></i> Tin Nhắn</a></li>

            <!-- client need support -->
            <li><a href="#"><i class="fas fa-question-circle"></i> Hỗ Trợ</a></li>
            <li><a href="#"><i class="fas fa-cog"></i> Cài Đặt</a></li>
            <li><a href="#"><i class="fas fa-lock"></i> Mật Khẩu</a></li>
            <li>
                <a><i class="fas fa-sign-out-alt"></i>
                    @if (Auth::check())
                        <form style="z-index: 1" class="" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button style="border: none;  color: #d1d8e0; background:#274d8f;" type="submit"
                                class="text-white">Đăng
                                Xuất</button>
                        </form>
                    @endif
                </a>
            </li>
        </ul>
    </div>

    <div class="table-container mt-4 col-9">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Quản Lý Mã Giảm Giá</h3>
                <!-- search -->
                <div>
                    <form action="{{ route('promotions.search') }}" method="get">
                        <div class="input-group">
                            <input type="search" class="form-control rounded" name="search" placeholder="Search"
                                required />
                            <button type="submit" class="btn btn-primary"> tìm</button>
                        </div>
                    </form>
                </div>

                <!-- click thêm -->
                @if (Auth::check() && Auth::user()->role == 'admin')
                    <button class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#addModal">
                        <i class="fas fa-plus me-2"></i>Thêm Mã Giảm Giá
                    </button>
                @endif
            </div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Mã</th>
                                <th>Tên</th>
                                <th>Loại</th>
                                <th>Giá trị</th>
                                <th>Đã dùng/Giới hạn</th>
                                <th>Thời gian</th>
                                <th>Trạng thái</th>
                                @if (Auth::check() && Auth::user()->role == 'admin')
                                    <th>Thao Tác</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($promotions as $promotion)
                                <tr>
                                    <td>{{ $promotion->code }}</td>
                                    <td>{{ $promotion->name }}</td>
                                    <td>{{ $promotion->type == 'percentage' ? 'Phần trăm' : 'Số tiền' }}</td>
                                    <td>{{ $promotion->type == 'percentage' ? $promotion->value . '%' : number_format($promotion->value) . 'đ' }}
                                    </td>
                                    <td>{{ $promotion->used_count }}/{{ $promotion->usage_limit ?? 'Không giới hạn' }}
                                    </td>
                                    <td>
                                        {{ $promotion->start_date->format('d/m/Y') }} -
                                        {{ $promotion->end_date->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $promotion->is_active ? 'success' : 'danger' }}">
                                            {{ $promotion->is_active ? 'Hoạt động' : 'Hết hạn' }}
                                        </span>
                                    </td>
                                    @if (Auth::check() && Auth::user()->role == 'admin')
                                        <td>
                                            <button class="btn btn-sm btn-warning" data-mdb-toggle="modal"
                                                data-mdb-target="#editModal{{ $promotion->id }}">
                                                <i class="fas fa-edit"></i> Sửa
                                            </button>
                                            <form action="{{ route('promotions.destroy', $promotion->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Bạn có chắc muốn xóa?')">
                                                    <i class="fas fa-trash"></i> Xóa
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p>
                        {{ $promotions->links('pagination::bootstrap-4') }}
                    </p>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal Thêm -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('promotions.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm Mã Giảm Giá Mới</h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-outline mb-4">
                            <input type="text" id="code" name="code" class="form-control" required />
                            <label class="form-label" for="code">Mã giảm giá</label>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="text" id="name" name="name" class="form-control" required />
                            <label class="form-label" for="name">Tên chương trình</label>
                        </div>
                        <div class="mb-4">
                            <select class="form-select" name="type" required>
                                <option value="percentage">Giảm theo phần trăm</option>
                                <option value="fixed">Giảm số tiền cố định</option>
                            </select>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="number" id="value" name="value" class="form-control" required />
                            <label class="form-label" for="value">Giá trị</label>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="number" id="usage_limit" name="usage_limit" class="form-control" />
                            <label class="form-label" for="usage_limit">Giới hạn sử dụng</label>
                        </div>
                        <div class="mb-4">
                            <label>Thời gian bắt đầu</label>
                            <input type="datetime-local" name="start_date" class="form-control" required />
                        </div>
                        <div class="mb-4">
                            <label>Thời gian kết thúc</label>
                            <input type="datetime-local" name="end_date" class="form-control" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Sửa -->
    @foreach ($promotions as $promotion)
        <div class="modal fade" id="editModal{{ $promotion->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('promotions.update', $promotion->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Sửa Mã Giảm Giá</h5>
                            <button type="button" class="btn-close" data-mdb-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Các trường giống form thêm mới -->
                            <div class="form-outline mb-4">
                                <input type="text" id="code{{ $promotion->id }}" name="code"
                                    class="form-control" value="{{ $promotion->code }}" required />
                                <label class="form-label" for="code{{ $promotion->id }}">Mã giảm giá</label>
                            </div>
                            <!-- Thêm các trường khác tương tự -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</section>

<script src="{{ asset('component/js/mdb.umd.min.js') }}"></script>
