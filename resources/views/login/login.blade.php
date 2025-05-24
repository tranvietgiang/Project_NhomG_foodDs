<!-- import library MDBootstrap_CSS -->
<link rel="stylesheet" href="{{ asset('component/css/mdb.min.css') }}">
<!-- Link icon  -->
<link rel="Website icon" type="png" href="{{ asset('logo-website/login.png') }}">
<section class="text-center mt-5">
    <div>
        <h1 class="display-6">Welcome Login</h1>
    </div>


    <!-- password enter wrong-->
    @if (session('login-seconds'))
        <div class="alert alert-danger">
            <span id="countdown">{{ session('login-seconds') }}</span>
        </div>
    @endif


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

    <!-- password enter wrong-->
    @if (session('wrong-password'))
        <div class="alert alert-warning">{{ session('wrong-password') }}</div>
    @endif



    <!-- password enter wrong-->
    @if (session('email-space'))
        <div class="alert alert-warning">{{ session('email-space') }}</div>
    @endif



    <div>
        <form class="container w-25 mt-5" action="{{ route('check') }}" method="post">
            @csrf
            <!-- Email input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <!-- có thể thay text thành email để không cần phải check email đúng định dạng -->
                <input type="text" id="login-email" value="{{ old('email') }}" name="email"
                    class="form-control" />
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
            <a href="{{ route('auth.google') }}" class="google-btn">Login with Google</a> |

            <!-- Nút đăng nhập bằng Google -->
            <a href="{{ url('login/sdt') }}" data-mdb-toggle="modal" data-mdb-target="#addModal"
                class="google-btn">Login with sdt</a> |

            <!-- Nút đăng nhập bằng Google -->
            <a href="{{ url('login/github') }}" class="github-btn">Login with Github <img class="object-fit-cover"
                    width="20" height="20" src="{{ asset('image-store/github.png') }}" alt=""></a> |
            <!-- quay ve trang chinh -->
            <a href="{{ route('website-main') }}" class="">Home</a>

            <!-- Register buttons -->
            <div class="text-center">
                <p>Not a member? <a href="{{ route('wayLogin', ['page' => 'register']) }}">Register</a></p>
            </div>
        </form>
    </div>
</section>

<!-- Modal nhập SDT -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('send.otp') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Xác minh số điện thoại</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="form-outline">
                        <input type="text" name="phone" class="form-control" required />
                        <label class="form-label">Số điện thoại</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Gửi mã OTP</button>
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Đóng</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- import library  MDBootstrap_JS-->
<script src="{{ asset('component/js/mdb.umd.min.js') }}"></script>
<script>
    const countdownText = document.getElementById('countdown');
    const match = countdownText?.innerText.match(/(\d+)/);
    let seconds = match ? parseInt(match[1]) : 0;

    const interval = setInterval(() => {
        seconds--;
        if (seconds <= 0) {
            clearInterval(interval);
            countdownText.innerText = "Bạn có thể thử lại đăng nhập ngay bây giờ.";
        } else {
            countdownText.innerText = `Vui lòng thử lại sau ${seconds} giây.`;
        }
    }, 1000);
</script>
