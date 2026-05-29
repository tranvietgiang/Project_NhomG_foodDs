<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật mật khẩu - FoodDS</title>
    <link rel="Website icon" type="png" href="{{ asset('logo-website/login.png') }}">
    <link rel="stylesheet" href="{{ asset('component/css/foodds.css') }}">
</head>

<body>
    <main class="fd-auth-page">
        <section class="fd-auth-shell">
            <aside class="fd-auth-visual">
                <img src="{{ asset('component/header/img/img-animation-5.jpg') }}" alt="FoodDS">
                <div class="fd-auth-copy">
                    <div class="fd-eyebrow">Bảo mật tài khoản</div>
                    <h1>Đặt mật khẩu mới cho tài khoản</h1>
                    <p>Chọn mật khẩu đủ mạnh để bảo vệ thông tin mua hàng và đơn hàng của bạn.</p>
                </div>
            </aside>

            <div class="fd-auth-card">
                <a href="{{ route('website-main') }}" class="fd-auth-logo">
                    <img src="{{ asset('logo-website/login.png') }}" alt="FoodDS">
                    <strong>FoodDS</strong>
                </a>

                <h2 class="fd-auth-title">Cập nhật mật khẩu</h2>
                <p class="fd-auth-subtitle">Nhập mật khẩu mới sau khi xác minh OTP.</p>

                <div class="fd-alerts">
                    @if (session('success-otp-email-forgot'))
                        <div class="fd-alert success">{{ session('success-otp-email-forgot') }}</div>
                    @endif

                    @foreach (['password-do-not-match', 'pw-pw_old-match', 'regex-weak-password'] as $key)
                        @if (session($key))
                            <div class="fd-alert warning">{{ session($key) }}</div>
                        @endif
                    @endforeach
                </div>

                <form action="{{ route('update_pw') }}" method="post">
                    @csrf
                    <div class="fd-field">
                        <label for="login-email">Email</label>
                        <input type="text" id="login-email" value="{{ session('email_user') }}" name="email"
                            readonly>
                    </div>

                    <div class="fd-field">
                        <label for="login-pw">Mật khẩu mới</label>
                        <input type="password" name="password" id="login-pw" placeholder="Nhập mật khẩu mới" required>
                    </div>

                    <div class="fd-field">
                        <label for="login-pwc">Nhập lại mật khẩu</label>
                        <input type="password" name="password_confirmed" id="login-pwc"
                            placeholder="Nhập lại mật khẩu" required>
                    </div>

                    <button type="submit" class="fd-auth-submit">Cập nhật</button>
                </form>

                <p class="fd-auth-bottom">
                    Quay lại
                    <a href="{{ route('wayLogin', ['page' => 'login']) }}">đăng nhập</a>
                </p>
            </div>
        </section>
    </main>
</body>

</html>
