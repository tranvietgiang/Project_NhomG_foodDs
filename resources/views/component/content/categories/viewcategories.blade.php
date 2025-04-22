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
                <li class="active"><a href="{{ route('employees') }}"><i class="fas fa-users"></i> Quản Lý Nhân Viên</a>
                </li>
            @else
                <li class="active"><a href="{{ route('employees') }}"><i class="fas fa-users"></i> DS Nhân Viên</a></li>
            @endif


            <!-- page product -->
            @if (Auth::check() && Auth::user()->role == 'admin')
                <li class=""><a href="#"><i class="fas fa-box"></i> Quản Lý Sản Phẩm</a></li>
            @else
                <li><a href="#"><i class="fas fa-box"></i> DS Sản Phẩm</a></li>
            @endif

            <!-- page categories -->
            @if (Auth::check() && Auth::user()->role == 'admin')
                <li class=""><a href="{{ url('categories') }}"><i class="fas fa-box"></i> Quản Lý Phân loại</a>
                </li>
            @else
                <li><a href="#"><i class="fas fa-box"></i> Quản Lý Phân loại</a></li>
            @endif

            <!-- page client -->
            @if (Auth::check() && Auth::user()->role == 'admin')
                <li><a href="{{ route('manager') }}"><i class="fas fa-box"></i> Quản Lý khách hàng</a>
                </li>
            @else
                <li><a href="{{ route('manager') }}"><i class="fas fa-box"></i> DS khách hàng</a></li>
            @endif

            <li><a href="#"><i class="fas fa-envelope"></i> Tin Nhắn</a></li>

            <!-- client need support -->
            <li><a href="#"><i class="fas fa-question-circle"></i> Hỗ Trợ</a></li>
            <li><a href="#"><i class="fas fa-cog"></i> Cài Đặt</a></li>
            <li><a href="#"><i class="fas fa-lock"></i> Mật Khẩu</a></li>
            <li><a href="#"><i class="fas fa-sign-out-alt"></i> Đăng Xuất</a></li>
        </ul>
    </div>
    <!--  -->
    <div class="table-container mt-4 col-9">

        @include('component.header.admin.keThua.navbar-logout')

        <!-- nút thêm -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Quản Lý Loại Sản Phẩm</h3>
                <button class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#addModal">
                    <i class="fas fa-plus me-2"></i>Thêm Loại Sản Phẩm
                </button>
            </div>

            <div class="card-body">
                @if (session('destroy-categories-failed'))
                    <div class="alert alert-warning">{{ session('destroy-categories-failed') }}</div>
                @endif

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
                                <th>ID</th>
                                <th>Tên Loại</th>
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->categories_id }}</td>
                                    <td>{{ $category->categories_name }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-mdb-toggle="modal"
                                            data-mdb-target="#editModal{{ $category->categories_id }}">
                                            <i class="fas fa-edit"></i> Sửa
                                        </button>
                                        <form action="{{ route('categories.destroy', $category->categories_id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Bạn có chắc muốn xóa?')">
                                                <i class="fas fa-trash"></i> Xóa
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Thêm -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm Loại Sản Phẩm Mới</h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-outline mb-4">
                            <input type="text" id="categories_name" name="categories_name" class="form-control"
                                required />
                            <label class="form-label" for="categories_name">Tên Loại</label>
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
    @foreach ($categories as $category)
        <div class="modal fade" id="editModal{{ $category->categories_id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('categories.update', $category->categories_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Sửa Loại Sản Phẩm</h5>
                            <button type="button" class="btn-close" data-mdb-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-outline mb-4">
                                <input type="text" id="categories_name{{ $category->categories_id }}"
                                    name="categories_name" class="form-control"
                                    value="{{ $category->categories_name }}" required />
                                <label class="form-label" for="categories_name{{ $category->categories_id }}">Tên
                                    Loại</label>
                            </div>
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
    </div>
</section>
<!-- Scripts -->
<script src="{{ asset('component/js/mdb.umd.min.js') }}"></script>


{{-- 
<!-- jQuery (cần cho modal) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
