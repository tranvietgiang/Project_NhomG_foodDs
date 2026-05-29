<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - FoodDS</title>
    <link rel="Website icon" type="png" href="{{ asset('logo-website/login.png') }}">
    <link rel="stylesheet" href="{{ asset('component/css/foodds.css') }}">
</head>

<body>
    <main class="fd-auth-page">
        <section class="fd-auth-shell">
            <aside class="fd-auth-visual">
                <img src="{{ asset('component/header/img/img-animation-2.jpg') }}" alt="FoodDS">
                <div class="fd-auth-copy">
                    <div class="fd-eyebrow">Tạo tài khoản</div>
                    <h1>Lưu món yêu thích và đặt hàng tiện hơn</h1>
                    <p>Đăng ký FoodDS để theo dõi đơn hàng, nhận ưu đãi và mua lại món ngon nhanh chóng.</p>
                </div>
            </aside>

            <div class="fd-auth-card">
                <a href="{{ route('website-main') }}" class="fd-auth-logo">
                    <img src="{{ asset('logo-website/login.png') }}" alt="FoodDS">
                    <strong>FoodDS</strong>
                </a>

                <h2 class="fd-auth-title">Đăng ký</h2>
                <p class="fd-auth-subtitle">Tạo tài khoản mới bằng email của bạn.</p>

                <div class="fd-alerts">
                    @foreach (['email-name-space', 'regex-weak-password', 'username-space', 'email-space'] as $key)
                        @if (session($key))
                            <div class="fd-alert warning">{{ session($key) }}</div>
                        @endif
                    @endforeach

                    @if ($errors->any())
                        <div class="fd-alert warning">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <div class="fd-field">
                        <label for="login-name">Tên tài khoản</label>
                        <input type="text" name="username" id="login-name" value="{{ old('username') }}"
                            placeholder="Nhập tên tài khoản" required>
                    </div>

                    <div class="fd-field">
                        <label for="login-email">Email</label>
                        <input type="text" id="login-email" name="email" value="{{ old('email') }}"
                            placeholder="you@example.com" required>
                    </div>

                    <div class="fd-field">
                        <label for="login-pw">Mật khẩu</label>
                        <input type="password" name="password" id="login-pw" placeholder="Ít nhất 8 ký tự" required>
                    </div>

                    <div class="fd-field">
                        <label for="login-pwc">Nhập lại mật khẩu</label>
                        <input type="password" name="password_confirmation" id="login-pwc"
                            placeholder="Nhập lại mật khẩu" required>
                    </div>

                    <button type="submit" class="fd-auth-submit">Đăng ký</button>
                </form>

                <p class="fd-auth-bottom">
                    Đã có tài khoản?
                    <a href="{{ route('wayLogin', ['page' => 'login']) }}">Đăng nhập</a>
                </p>
            </div>
        </section>
    </main>
</body>

</html>
