<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - FoodDS</title>
    <link rel="Website icon" type="png" href="{{ asset('logo-website/login.png') }}">
    <link rel="stylesheet" href="{{ asset('component/css/foodds.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>

<body>
    <main class="fd-auth-page">
        <section class="fd-auth-shell">
            <aside class="fd-auth-visual">
                <img src="{{ asset('component/header/img/img-animation-1.jpg') }}" alt="FoodDS">
                <div class="fd-auth-copy">
                    <div class="fd-eyebrow">FoodDS xin chào</div>
                    <h1>Đăng nhập để mua món ngon nhanh hơn</h1>
                    <p>Theo dõi giỏ hàng, đơn hàng và các ưu đãi đồ ăn, thức uống mới nhất trong một nơi.</p>
                </div>
            </aside>

            <div class="fd-auth-card">
                <a href="{{ route('website-main') }}" class="fd-auth-logo">
                    <img src="{{ asset('logo-website/login.png') }}" alt="FoodDS">
                    <strong>FoodDS</strong>
                </a>

                <h2 class="fd-auth-title">Đăng nhập</h2>
                <p class="fd-auth-subtitle">Nhập email và mật khẩu để tiếp tục.</p>

                <div class="fd-alerts">
                    @foreach ([
                        'login-seconds',
                        'login-failed',
                        'email-not-exists',
                        'email-password-empty',
                        'invalid-email',
                        'short-password',
                        'google-error',
                        'Right-login',
                        'wrong-password',
                        'email-space',
                    ] as $key)
                        @if (session($key))
                            <div class="fd-alert warning">
                                <span id="{{ $key === 'login-seconds' ? 'countdown' : '' }}">{{ session($key) }}</span>
                            </div>
                        @endif
                    @endforeach

                    @foreach (['success_register', 'update_pw_success'] as $key)
                        @if (session($key))
                            <div class="fd-alert success">{{ session($key) }}</div>
                        @endif
                    @endforeach
                </div>

                <form action="{{ route('check') }}" method="post">
                    @csrf
                    <div class="fd-field">
                        <label for="login-email">Email</label>
                        <input type="text" id="login-email" value="{{ old('email') }}" name="email"
                            placeholder="you@example.com">
                    </div>

                    <div class="fd-field">
                        <label for="login-pw">Mật khẩu</label>
                        <input type="password" name="password" id="login-pw" placeholder="Nhập mật khẩu">
                    </div>

                    <div class="fd-auth-links">
                        <a href="{{ route('website-main') }}">Về trang chủ</a>
                        <a href="{{ route('wayLogin', ['page' => 'forgot']) }}">Quên mật khẩu?</a>
                    </div>

                    <button type="submit" class="fd-auth-submit">Đăng nhập</button>
                </form>

                <div class="fd-auth-divider">hoặc đăng nhập với</div>

                <div class="fd-social-grid">
                    <a href="{{ route('auth.google') }}" class="fd-social">
                        <i class="bi bi-google"></i>
                        Google
                    </a>
                    <a href="{{ url('login/github') }}" class="fd-social">
                        <img width="20" height="20" src="{{ asset('image-store/github.png') }}" alt="">
                        Github
                    </a>
                    <a href="{{ url('/auth/facebook') }}" class="fd-social">
                        <i class="bi bi-facebook"></i>
                        Facebook
                    </a>
                </div>

                <p class="fd-auth-bottom">
                    Chưa có tài khoản?
                    <a href="{{ route('wayLogin', ['page' => 'register']) }}">Đăng ký ngay</a>
                </p>
            </div>
        </section>
    </main>

    <script>
        const countdownText = document.getElementById('countdown');
        const match = countdownText?.innerText.match(/(\d+)/);
        let seconds = match ? parseInt(match[1]) : 0;

        if (countdownText && seconds > 0) {
            const interval = setInterval(() => {
                seconds--;
                if (seconds <= 0) {
                    clearInterval(interval);
                    countdownText.innerText = "Bạn có thể thử lại đăng nhập ngay bây giờ.";
                } else {
                    countdownText.innerText = `Vui lòng thử lại sau ${seconds} giây.`;
                }
            }, 1000);
        }
    </script>
</body>

</html>
