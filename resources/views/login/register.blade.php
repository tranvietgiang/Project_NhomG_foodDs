<!-- import library MDBootstrap_CSS -->
<link rel="stylesheet" href="{{ asset('component/css/mdb.min.css') }}">
{{-- <link rel="icon" href=""> --}}
<section class="text-center mt-5">
    <div>
        <h1 class="display-6">Register</h1>
    </div>
    <!-- email-existed -->
    @if (session('email-existed'))
        <div class="alert alert-warning">{{ session('email-existed') }}</div>
    @endif

    <!-- password do not match -->
    @if (session('pw-wrong'))
        <div class="alert alert-warning">{{ session('pw-wrong') }}</div>
    @endif
    <div>
        <form class="container w-25 mt-5" action="" method="post">
            @csrf
            <!-- username input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <input type="text" name="name" id="login-name" class="form-control" required />
                <label class="form-label" for="login-name">username</label>
            </div>

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

            <!-- Password Confirm input  -->
            <div data-mdb-input-init class="form-outline mb-4">
                <input type="password" name="password_c" id="login-pwc" class="form-control" required />
                <label class="form-label" for="login-pwc">Password_confirm</label>
            </div>

            <!-- Submit button -->
            <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">Sign
                up</button>

            <!-- Register buttons -->
            <div class="text-center ">
                <a class="btn btn-outline-primary" href="{{ route('wayLogin', ['page' => 'login']) }}">Sign in</a></p>
            </div>
        </form>
    </div>
</section>
<!-- import library  MDBootstrap_JS-->
<script src="{{ asset('component/js/mdb.umd.min.js') }}"></script>
