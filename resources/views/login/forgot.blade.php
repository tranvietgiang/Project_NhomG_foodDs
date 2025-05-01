<!-- import library MDBootstrap_CSS -->
<link rel="stylesheet" href="{{ asset('component/css/mdb.min.css') }}">
<section class="">

    <!-- check email have exists -->
    @if (session('email_not_exists_forgot'))
        <div class="alert alert-warning text-center">{{ session('email_not_exists_forgot') }}</div>
    @endif

    <form class="container w-25 mt-5" action="{{ route('forgot') }}" method="post">
        @csrf
        <!-- Email forgot input  -->
        <div data-mdb-input-init class="form-outline mb-4">
            <input type="email" id="form2Example2" name="email" class="form-control" required />
            <label class="form-label" for="form2Example2">Email address</label>
        </div>

        <!-- Submit Register -->
        <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">check
            email</button>

        <!-- Back Sign In -->
        <div class="text-center">
            <p class="btn btn-outline-primary"><a href="{{ route('wayLogin', ['page' => 'login']) }}">Sign in</a></p>
        </div>
    </form>
    <!-- import library  MDBootstrap_JS-->
</section>
<script src="{{ asset('component/js/mdb.umd.min.js') }}"></script>
