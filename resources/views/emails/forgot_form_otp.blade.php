<!-- Import MDBootstrap CSS -->
<link rel="stylesheet" href="{{ asset('component/css/mdb.min.css') }}">
<!-- git forget -->
<section class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-2-strong" style="width: 25rem;">
        <div class="card-body">
            <h2 class="text-center mb-4">Xác Nhận OTP</h2>

            <!-- Kiểm tra otp -->
            @if (session('email_exists_otp'))
                <div class="alert alert-success text-center">{{ session('email_exists_otp') }}</div>
            @endif

            <!-- re-send code otp -->
            @if (session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif

            <!-- otp wrong -->
            @if (session('failed'))
                <div class="alert alert-danger text-center">{{ session('failed') }}</div>
            @endif

            <form action="{{ route('verifyOTP.otpForgot') }}" method="post">
                @csrf
                <!-- Input OTP -->
                <div class="form-outline mb-4">
                    <input type="text" id="form2Example2" name="otp" pattern="[0-9]{6}" maxlength="6"
                        class="form-control" required />
                    <label class="form-label" for="form2Example2">Mã OTP</label>
                </div>

                <!-- Nút gửi -->
                <button type="submit" class="btn btn-primary btn-block mb-4">Confirm OTP</button>

            </form>
            <!-- Quay lại Đăng Nhập -->
            <div class="text-center">
                <p class="mb-0"><a href="{{ route('wayLogin', ['page' => 'login']) }}"
                        class="btn btn-outline-primary">Sign IN</a></p>
            </div>

            <!-- Gửi lại OTP -->
            <form action="{{ route('send.otp') }}" method="POST">
                @csrf
                <button type="submit" class="btn-sm btn btn-outline-primary">
                    Gửi lại OTP
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Import MDBootstrap JS -->
<script src="{{ asset('component/js/mdb.umd.min.js') }}"></script>
<!-- only allowed enter number -->
<script>
    document.getElementById('form2Example2').addEventListener('input', function(e) {
        // Chỉ giữ lại các ký tự số
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>
