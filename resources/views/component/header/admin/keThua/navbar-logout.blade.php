<!-- Navbar -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- link dm bootstrap -->
{{-- <link rel="stylesheet" href="{{ asset('component/css/mdb.min.css') }}"> --}}

<nav style="" class="navbar navbar-expand-lg navbar-light bg-primary bg-body-tertiary mb-4 mt-3">
    <!-- Container wrapper -->
    <div style="background: #1e3c72 " class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Navbar shop -->
            {{-- <a class="navbar-brand mt-2 mt-lg-0"
                @if (Auth::check() && Auth::user()->role == 'admin') href="{{ route('manager') }}"
                 @else 
                href="{{ route('employees') }}" @endif>
                <img src="{{ asset('logo-website/login.png') }}" height="15" alt="MDB Logo" loading="lazy" />
            </a> --}}
            <a class="navbar-brand mt-2 mt-lg-0" href="{{ route('manager') }}">
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
                        <a class="nav-link text-white" href="#">{{ session('role_admin') }} </a>
                    </li>
                @elseif (session('role_employees'))
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">{{ session('role_employees') }} </a>
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
    <form action="{{ route('search_client') }}" method="get">
        <div class="input-group">
            <input type="search" class="form-control rounded" value="{{ request('search') }}" name="search"
                placeholder="Search" aria-label="Search" aria-describedby="search-addon" required />
            <button type="submit" class="btn btn-primary" data-mdb-ripple-init> <i class="fas fa-search"></i></button>
        </div>
    </form>
</div>
