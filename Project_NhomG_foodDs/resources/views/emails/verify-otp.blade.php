<!DOCTYPE html>
<html>

<head>
    <title>Xác thực OTP</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-center mb-6">Xác thực OTP</h2>

        {{-- @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        --}}

        @if (session('email_verifyOtp_failed'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('email_verifyOtp_failed') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verify.otp') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                <input type="email" name="email" id="email" readonly value="{{ session('email') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-6">
                <label for="otp" class="block text-gray-700 text-sm font-bold mb-2">Mã OTP:</label>
                <input type="text" name="otp" id="otp"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="Nhập mã OTP gồm 6 chữ số">
            </div>

            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Xác nhận
                </button>
            </div>
        </form>
        <!-- Gửi lại OTP -->
        <form action="{{ route('send.otp') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-primary">
                Gửi lại OTP
            </button>
        </form>
    </div>
</body>

</html>
