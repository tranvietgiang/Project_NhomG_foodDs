<!-- import library MDBootstrap_CSS -->
<link rel="stylesheet" href="{{ asset('component/css/mdb.min.css') }}">
{{-- <link rel="icon" href=""> --}}
<section class="mt-5">
    <div>
        <h1 class="display-6 text-center">Update Password</h1>
    </div>

    @if (session('success-otp-email-forgo'))
        <div class="alert alert-success">{{ session('success-otp-email-forgot') }}</div>
    @endif
    <!-- check password do not match -->
    <div>
        <form class="container w-25 mt-5" action="{{ route('update_pw') }}" method="post">
            @csrf
            <!-- show email -->
            <div class="form-group mb-4 ">
                <label class="form-label" for="login-email">Email address</label>
                <input type="text" id="login-email" value="{{ session('email_user') }}" name="email" readonly
                    class="form-control bg-primary text-white" />
            </div>

            <!-- Password input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <input type="password" name="password" id="login-pw" class="form-control" />
                <label class="form-label" for="login-pw">Password</label>
            </div>

            <!-- Password Confirm input  -->
            <div data-mdb-input-init class="form-outline mb-4">
                <input type="password" name="password_confirmed" id="login-pwc" class="form-control" />
                <label class="form-label" for="login-pwc">Password</label>
            </div>

            <!-- Submit button -->
            <button type="submit" data-mdb-button-init data-mdb-ripple-init
                class="btn btn-primary btn-block mb-4">Update</button>

            <!-- Register buttons -->
            <div class="text-center ">
                <a class="btn btn-outline-primary" href="{{ route('wayLogin', ['page' => 'login']) }}">Sign in</a></p>
            </div>
        </form>
    </div>
</section>
<!-- import library  MDBootstrap_JS-->
<script src="{{ asset('component/js/mdb.umd.min.js') }}"></script>
