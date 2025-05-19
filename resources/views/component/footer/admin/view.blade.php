<title>Thêm Sản Phẩm</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

    /* Ảnh gốc nhỏ */
    .thumbnail {
        width: 200px;
        cursor: pointer;
        transition: 0.3s;
    }

    .thumbnail:hover {
        opacity: 0.8;
    }

    /* Overlay nền mờ */
    .lightbox {
        display: none;
        position: fixed;
        z-index: 1000;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.8);
        justify-content: center;
        align-items: center;
    }

    /* Ảnh phóng to */
    .lightbox img {
        max-width: 90%;
        max-height: 90%;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
    }

    /* Nút đóng */
    .lightbox::after {
        content: "✖";
        position: absolute;
        top: 20px;
        right: 30px;
        color: white;
        font-size: 32px;
        cursor: pointer;
    }
</style>
<section class="row">
    <!-- Sidebar -->
    <div style="height: 1050px" class="sidebar col-4">
        <ul class="nav-links">
            <li class="d-flex justify-content-center m-4">
                <h3>Dashboard</h3>
            </li>


            <!-- page product -->
            @if (Auth::check() && Auth::user()->role == 'admin')
                <li class="active"><a href=""><i class="fas fa-box"></i> Quản Lý Sản
                        Phẩm</a></li>
            @else
                <li class="active"><a href="{{ route('admin.view.product') }}"><i class="fas fa-box"></i> DS Sản
                        Phẩm</a></li>
            @endif


            <!-- nếu admin đổi thành quản lý -->
            @if (Auth::check() && Auth::user()->role == 'admin')
                <li class=""><a href="{{ route('employees') }}"><i class="fas fa-users"></i> Quản Lý Nhân Viên</a>
                </li>
            @else
                <li><a href="{{ route('employees') }}"><i class="fas fa-users"></i> DS Nhân Viên</a></li>
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
        <h3 class="mb-4">Quản lý sản phẩm</h3>

        @include('component.header.admin.keThua.aaa')

        <!-- search -->
        <div>
            <form action="{{ route('search.client.product') }}" method="get">
                <div class="input-group">
                    <input type="search" class="form-control rounded" value="{{ request('search') }}" name="search"
                        placeholder="Search" aria-label="Search" aria-describedby="search-addon" required />
                    <button type="submit" class="btn btn-primary" data-mdb-ripple-init> <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div><br>


        @if (Auth::check() && Auth::user()->role == 'admin')
            <div>
                <a class="btn btn-success" href="{{ route('admin.view.product-add') }}">thêm sản phẩm</a>
            </div><br>
        @endif

        @if (session('success'))
            <div class="alert alert-primary">{{ session('success') }}</div>
        @endif
        <!--Khi người dùng chọn một tùy chọn, trình duyệt chuyển đến URL được lưu trong value của option đó. -->
        <div>
            <select class="form-control" onchange="window.location.href=this.value">
                <option value="">-- Chọn chức năng --</option>
                <option value="{{ route('search.client.quantityStore') }}">Sản phẩm gần hết số lượng</option>
                <option value="{{ route('search.client.quantityStoreDesc') }}">Sản phẩm tồn kho</option>
                <option value="{{ route('admin.view.product.new') }}">Sản phẩm mới nhất</option>
            </select>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ảnh đại diện</th>
                    <th>Tên</th>
                    <th>Giá</th>
                    <th>Loại</th>
                    <th>SL trong kho</th>
                    <th>Mô tả</th>
                    @if (Auth::check() && Auth::user()->role == 'admin')
                        <th>Thao tác</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($show_product_admin as $product)
                    <tr>
                        <td class="text-center"><img width="100" height="100" class="object-fit-cover thumbnail"
                                onclick="showLightbox(this.src)"
                                src="{{ asset('component/image-product/' . $product->product_image) }}" alt="">
                        </td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ number_format($product->product_price) ?? 0 }}</td>
                        <td>{{ $product->categories->categories_name }}</td>
                        <td>{{ $product->quantity_store ?? 0 }}</td>
                        <td>{{ $product->description ?? 'no' }}</td>

                        @if (Auth::check() && Auth::user()->role == 'admin')
                            <td class="d-flex gap-2">
                                <a class="btn-sm btn-warning"
                                    href="{{ route('admin.edit.view.product') }}?product_id={{ $product->product_id }}">
                                    Edit
                                </a>
                                <a onclick="ConfirmDelete(event)" class="btn-sm btn-danger"
                                    href="{{ route('admin.remove.product') }}?product_id={{ $product->product_id }}">xóa
                                </a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- phần click vào to ảnh -->
        <div class="lightbox" id="lightbox" onclick="hideLightbox()">
            <img id="lightbox-img" />
        </div>
        <p>
            {{ $show_product_admin->links('pagination::bootstrap-4') }}
        </p>
    </div>

</section>
<script>
    //phần click vào to ảnh
    function showLightbox(src) {
        document.getElementById("lightbox-img").src = src;
        document.getElementById("lightbox").style.display = "flex";
    }

    function hideLightbox() {
        document.getElementById("lightbox").style.display = "none";
    }

    function ConfirmDelete(e) {
        var result = confirm('Bạn có muốn xóa nhân viên này không?');

        if (!result) {
            e.preventDefault();
        }
    }
</script>
