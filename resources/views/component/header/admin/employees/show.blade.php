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


        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên NHân Viên</th>
                    <th>Email</th>
                    <th>Số Điện Thoại</th>
                    <th>Trạng Thái</th>

                    <th>Created_at</th>
                    <!-- check role crud không -->
                    @if (Auth::check() && Auth::user()->role == 'admin')
                        <th>Hành Động</th>
                    @endif
                </tr>
            </thead>
            <tbody id="customer-table-body">

                @foreach ($list_employees as $item)
                    <tr>
                        <td>{{ ($list_employees->currentPage() - 1) * $list_employees->perPage() + $loop->iteration }}
                        </td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->phone }}</td>

                        <!-- check có đang online -->
                        <td>
                            @if ($item->last_activity == 'online')
                                <span class="badge bg-success">Online</span>
                            @else
                                <span class="badge bg-danger">Off</span>
                            @endif
                        </td>

                        <!-- show date -->
                        <td>{{ $item->format_date() }}</td>

                        <!-- check có role crud ko -->
                        @if (Auth::check() && Auth::user()->role == 'admin')
                            <td>
                                <button class="btn btn-sm btn-warning edit-btn">Sửa</button>
                                <button class="btn btn-sm btn-danger delete-btn">Xóa</button>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p>
            {{ $list_employees->links('pagination::bootstrap-4') }}
        </p>

        <!-- cách 2 hơi xấu -->
        {{-- <div>
            @if ($list_employees->onFirstPage())
                <span>Previous</span>
            @else
                <a href="{{ $list_employees->previousPageUrl() }}">Previous</a>
            @endif

            @if ($list_employees->hasMorePages())
                <a href="{{ $list_employees->nextPageUrl() }}">Next</a>
            @else
                <span>Next</span>
            @endif
        </div> --}}
</section>
