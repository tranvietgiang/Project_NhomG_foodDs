<!-- Navbar -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<nav style="" class="navbar navbar-expand-lg navbar-light bg-primary bg-body-tertiary mb-4 mt-3">
    <!-- Container wrapper -->
    <div style="background: #1e3c72 " class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <a class="navbar-brand mt-2 mt-lg-0" href="{{ route('employees') }}">
                <img src="{{ asset('logo-website/login.png') }}" height="15" alt="MDB Logo" loading="lazy" />
            </a>

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Danh Sách </a>
                </li>
            </ul>
        </div>

        <div class="d-flex align-items-center">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- name người đang sử dụng page chưa xong -->
                @if (session('role_admin'))
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">(QL) {{ session('role_admin') }} </a>
                    </li>
                @elseif (session('role_employees'))
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">(NV) {{ session('role_employees') }} </a>
                    </li>
                @endif
            </ul>

            <!-- Avatar -->
            <div class="dropdown">
                <img src="https://mdbcdn.b-cdn.net/img/new/avatars/2.webp" class="rounded-circle" height="25"
                    alt="Black and White Portrait of a Man" loading="lazy" />
            </div>
        </div>

        <!-- logout  -->
        <div class="d-flex justify-content-center align-items-center position-relative">
            <!-- check user login yet? -->
            @if (Auth::check())
                <form style="z-index: 1" class="" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-sm btn btn-link text-black">Logout</button>
                </form>
            @endif
        </div>
    </div>
</nav>

<!-- search -->
<div>
    <form action="{{ route('staff.search_employees') }}" method="get">
        <div class="input-group">
            <input type="search" class="form-control rounded" value="{{ request('search_staff') }}" name="search_staff"
                id="search_staff" placeholder="Search" aria-label="Search" aria-describedby="search-addon" required />
            <button type="submit" class="btn btn-primary" data-mdb-ripple-init> <i class="fas fa-search"></i></button>
        </div>
    </form>
</div>

{{-- <!-- link ajax không thể tối ưu việc tìm và crud employees -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#ajax_submit').submit(function(e) {
        e.preventDefault();
        let name_search_staff = $('#search_staff').val();

        $.ajax({
            url: "/role/admin/search_employees",
            type: "GET",
            data: {
                name_search_staff_backend: name_search_staff,
            },
            success: function(data) {
                $('#customer-table-staff').empty();

                if (data.data.length > 0) {
                    $.each(data.data, function(key, value) {
                        $('#customer-table-staff').append(`
                            <tr>
                                <td>${key + 1}</td>
                                <td>${value.name}</td>       
                                <td>${value.email}</td>       
                                <td>${value.phone}</td>       
                              <td>
                    ${value.last_activity == "online" 
                        ? '<span class="badge bg-success">Online</span>' 
                        : '<span class="badge bg-danger">Offline</span>'}
                </td>      
                                <td>${formatDate(value.created_at)}</td>



                                
                            </tr>
                        `);
                    });
                } else {
                    $('#customer-table-staff').append(
                        '<tr><td colspan="7">Không tìm thấy kết quả.</td></tr>'
                    );
                }
            },
        })
    });


    function formatDate(dateString) {
        let date = new Date(dateString);
        return date.toLocaleDateString('vi-VN');
    }
</script> --}}
