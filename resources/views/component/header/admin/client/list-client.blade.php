<link rel="stylesheet" href="{{ asset('component/css/mdb.min.css') }}">
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

            <!-- nếu admin đổi thành quản lý -->
            @if (Auth::check() && Auth::user()->role == 'admin')
                <li class="active"><a href="#"><i class="fas fa-box"></i> Quản Lý Khách hàng</a></li>
            @else
                <li class="active"><a href="#"><i class="fas fa-box"></i> DS Khách hàng</a></li>
            @endif

            @if (Auth::check() && Auth::user()->role == 'admin')
                <li><a href="{{ route('employees') }}"><i class="fas fa-users"></i> Quản Lý Nhân Viên</a></li>
            @else
                <li><a href="{{ route('employees') }}"><i class="fas fa-users"></i> DS Nhân Viên</a></li>
            @endif

            <!-- page product -->
            @if (Auth::check() && Auth::user()->role == 'admin')
                <li class=""><a href="#"><i class="fas fa-box"></i> Quản Lý Sản Phẩm</a></li>
            @else
                <li><a href="#"><i class="fas fa-box"></i> DS Sản Phẩm</a></li>
            @endif

            <!-- page categories -->
            @if (Auth::check() && Auth::user()->role == 'admin')
                <li class=""><a href="{{ url('categories') }}"><i class="fas fa-box"></i> Quản Lý Phân
                        loại</a></li>
            @else
                <li><a href="#"><i class="fas fa-box"></i> Quản Lý Phân loại</a></li>
            @endif

            <!-- page -->
            @if (Auth::check() && Auth::user()->role == 'admin')
                <li><a href="#"><i class="fas fa-envelope"></i>Mã giảm giá</a></li>
            @endif

            <li><a href="#"><i class="fas fa-envelope"></i> Tin Nhắn</a></li>
            <li><a href="#"><i class="fas fa-cog"></i> Cài Đặt</a></li>
            <li><a href="#"><i class="fas fa-lock"></i> Mật Khẩu</a></li>
            <li> <a><i class="fas fa-sign-out-alt"></i>
                    @if (Auth::check())
                        <form style="z-index: 1" class="" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button style="border: none; background:#274d8f; color: #d1d8e0;" type="submit">Đăng
                                Xuất</button>
                        </form>
                    @endif
                </a></li>
        </ul>
    </div>


    <div class="table-container mt-4 col-9">

        @include('component.header.admin.keThua.navbar-logout')
        <!-- show list client -->
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>ID</th>
                    <th>Tên Khách Hàng</th>
                    <th>Email</th>
                    <th>Số Điện Thoại</th>
                    <th>Số Lần đăng nhập</th>
                    <th>Trạng Thái</th>
                    <th>Created_at</th>
                    <th>info-detail</th>
                </tr>
            </thead>
            <tbody id="customer-table-body">

                @foreach ($list_client as $item)
                    <tr>
                        <td>{{ $loop->iteration + $list_client->firstItem() - 1 }}</td>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>

                        <td>{{ $item->client->client_phone ?? '' }}
                        </td>

                        <td>{{ $item->client->login_count ?? '' }}</td>

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

                        <td>
                            <a href="{{ url('/client/info', ['user_id' => $item->id]) }}">
                                <img width="30" height="30" class="object-fit-cover"
                                    src="{{ asset('image-store/eye.png') }}" alt="">
                            </a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        <p>
            {{ $list_client->links('pagination::bootstrap-4') }}
        </p>
    </div>
</section>


<!-- Bootstrap Bundle JS (bao gồm cả Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Scripts -->
<script src="{{ asset('component/day/js/mdb.umd.min.js') }}"></script>
