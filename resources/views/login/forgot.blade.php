<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu - FoodDS</title>
    <link rel="Website icon" type="png" href="{{ asset('logo-website/login.png') }}">
    <link rel="stylesheet" href="{{ asset('component/css/foodds.css') }}">
</head>

<body>
    <main class="fd-auth-page">
        <section class="fd-auth-shell">
            <aside class="fd-auth-visual">
                <img src="{{ asset('component/header/img/img-animation-6.jpg') }}" alt="FoodDS">
                <div class="fd-auth-copy">
                    <div class="fd-eyebrow">Khôi phục tài khoản</div>
                    <h1>Đặt lại mật khẩu nhanh chóng</h1>
                    <p>Nhập email đã đăng ký. Hệ thống sẽ kiểm tra tài khoản và chuyển bạn sang bước tạo mật khẩu mới, không cần gửi OTP qua Gmail.</p>
                </div>
            </aside>

            <div class="fd-auth-card">
                <a href="{{ route('website-main') }}" class="fd-auth-logo">
                    <img src="{{ asset('logo-website/login.png') }}" alt="FoodDS">
                    <strong>FoodDS</strong>
                </a>

                <h2 class="fd-auth-title">Quên mật khẩu</h2>
                <p class="fd-auth-subtitle">Nhập email để kiểm tra tài khoản.</p>

                <div class="fd-alerts">
                    @foreach (['email_not_exists_forgot', 'email-space', 'invalid-email'] as $key)
                        @if (session($key))
                            <div class="fd-alert warning">{{ session($key) }}</div>
                        @endif
                    @endforeach
                </div>

                <form action="{{ route('forgot') }}" method="post">
                    @csrf
                    <div class="fd-field">
                        <label for="forgot-email">Email</label>
                        <input type="text" id="forgot-email" name="email" value="{{ old('email') }}"
                            placeholder="you@example.com" required>
                    </div>

                    <button type="submit" class="fd-auth-submit">Kiểm tra email</button>
                </form>

                <p class="fd-auth-bottom">
                    Nhớ mật khẩu rồi?
                    <a href="{{ route('wayLogin', ['page' => 'login']) }}">Đăng nhập</a>
                </p>
            </div>
        </section>
    </main>
</body>

</html>