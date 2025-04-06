<!-- import library MDBootstrap_CSS -->
<link rel="stylesheet" href="{{ asset('component/css/mdb.min.css') }}">
<!-- Link icon  -->
<link rel="Website icon" type="png" href="{{ asset('logo-website/login.png') }}">
<section class="text-center mt-5">
    <div>
        <h1 class="display-6">Welcome Login</h1>
    </div>

    @if (session('login-failed'))
        <div class="alert alert-warning text-center">{{ session('login-failed') }}</div>
    @endif

    <!-- wrong pw-or-email -->
    @if (session('email-not-exists'))
        <div class="alert alert-warning">
            {{ session('email-not-exists') }}
        </div>
    @endif



    <!-- password or email  empty -->
    @if (session('email-password-empty'))
        <div class="alert alert-warning">
            {{ session('email-password-empty') }}
        </div>
    @endif

    <!-- user có đăng nhập đúng định dạng email không -->
    @if (session('invalid-email'))
        <div class="alert alert-warning">
            {{ session('invalid-email') }}
        </div>
    @endif

    <!-- password phải dài hơn 5 kí tự -->
    @if (session('short-password'))
        <div class="alert alert-warning">
            {{ session('short-password') }}
        </div>
    @endif

    <!-- google-error-->
    @if (session('google-error'))
        <div class="alert alert-warning">
            {{ session('google-error') }}
        </div>
    @endif

    <!-- register success -->
    @if (session('success_register'))
        <div class="alert alert-success">
            {{ session('success_register') }}
        </div>
    @endif

    <!-- register success -->
    @if (session('update_pw_success'))
        <div class="alert alert-success">
            {{ session('update_pw_success') }}
        </div>
    @endif

    <!-- User phải login trước khi vào trang index chưa làm -->
    @if (session('Right-login'))
        <div class="alert alert-warning">{{ session('Right-login') }}</div>
    @endif

    {{--
    <!-- wrong pw-or-email -->


    <!-- logout alert -->
    @if (session('logout-success'))
        <div class="alert alert-success text-center">{{ session('logout-success') }}</div>
    @endif


    <!-- update password success -->
    @if (session('update-success'))
        <div class="alert alert-success">{{ session('update-success') }}</div>
    @endif --}}
    <div>
        <form class="container w-25 mt-5" action="{{ route('check') }}" method="post">
            @csrf
            <!-- Email input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <!-- có thể thay text thành email để không cần phải check email đúng định dạng -->
                <input type="text" id="login-email" name="email" class="form-control" />
                <label class="form-label" for="login-email">Email address</label>
            </div>

            <!-- Password input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <input type="password" name="password" id="login-pw" class="form-control" />
                <label class="form-label" for="login-pw">Password</label>
            </div>

            <!-- 2 column grid layout for inline styling -->
            <div class="row mb-4">
                <div class="col d-flex justify-content-center">
                    <!-- Checkbox -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                        <label class="form-check-label" for="form2Example31"> Remember me </label>
                    </div>
                </div>

                <div class="col">
                    <!-- forgot -->
                    <a href="{{ route('wayLogin', ['page' => 'forgot']) }}" class="">Forgot password?</a>
                </div>
            </div>

            <!-- Submit button -->
            <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">Sign
                in</button>

            <!-- Nút đăng nhập bằng Google -->
            <a href="{{ route('auth.google') }}" class="google-btn">Login with Google</a>

            <!-- Register buttons -->
            <div class="text-center">
                <p>Not a member? <a href="{{ route('wayLogin', ['page' => 'register']) }}">Register</a></p>
            </div>
        </form>
    </div>
</section>
<!-- import library  MDBootstrap_JS-->
<script src="{{ asset('component/js/mdb.umd.min.js') }}"></script>
