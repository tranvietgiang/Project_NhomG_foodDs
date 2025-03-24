<!-- import library MDBootstrap_CSS -->
<link rel="stylesheet" href="{{ asset('component/css/mdb.min.css') }}">

<section class="text-center mt-5">
    <div>
        <h1 class="display-6">Welcome Login</h1>
    </div>

    <!-- wrong pw-or-email -->
    {{-- @if (session('L-failed'))
        <div class="alert alert-warning text-center">{{ session('L-failed') }}</div>
    @endif

    <!-- wrong pw-or-email -->
    @if (session('waring-email'))
        <div class="alert alert-warning text-center">{{ session('waring-email') }}</div>
    @endif

    <!-- logout alert -->
    @if (session('logout-success'))
        <div class="alert alert-success text-center">{{ session('logout-success') }}</div>
    @endif

    <!-- User right login -->
    @if (session('Right-login'))
        <div class="alert alert-warning">{{ session('Right-login') }}</div>
    @endif

    <!-- register-success -->
    @if (session('register-success'))
        <div class="alert alert-success">{{ session('register-success') }}</div>
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
                <input type="email" id="login-email" name="email" class="form-control" required />
                <label class="form-label" for="login-email">Email address</label>
            </div>

            <!-- Password input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <input type="password" name="password" id="login-pw" class="form-control" required />
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
            <!-- Register buttons -->
            <div class="text-center">
                <p>Not a member? <a href="{{ route('wayLogin', ['page' => 'register']) }}">Register</a></p>
            </div>
        </form>
    </div>
</section>
<!-- import library  MDBootstrap_JS-->
<script src="{{ asset('component/js/mdb.umd.min.js') }}"></script>
