<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Middleware\checkLogin;
use App\Http\Middleware\LastActivity;
use App\Mail\OTPMail;
use App\Models\login;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($page)
    {
        //
        $checkWay = ['login', 'register', 'forgot'];

        if (!in_array($page, $checkWay)) {
            abort(404);
        }

        if (!view()->exists("login.$page")) {
            abort(404, "Page not found"); // Hoặc redirect, tùy ý
        }

        return view("login.$page");
    }


    /**
     * login : kiểm tra user có đăng nhập chưa
     */
    public function login(Request $req)
    {

        if (empty($req->email) || empty($req->password)) {
            return  redirect()->back()->with('email-password-empty', 'Vui lòng nhập đầy đủ email or password');
        }

        // Kiểm tra email hợp lệ trước khi truy vấn database
        if (!filter_var($req->email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('invalid-email', 'Email không hợp lệ, vui lòng nhập lại.');
        }

        // Kiểm tra mật khẩu phải có ít nhất 5 ký tự
        if (strlen($req->password) < 4) {
            return redirect()->back()->with('short-password', 'Mật khẩu phải có ít nhất 4 ký tự.');
        }

        $req->validate([
            'email' => 'required|email', // yêu cầu phải là email
            'password' => 'required|min:4', // yêu cầu password tối hiểu 4 ký tự
        ]);

        /** email have exists in database */
        if (!User::where('email', $req->email)->exists()) {
            return  redirect()->back()->with('email-not-exists', 'Email này chưa được đăng ký vào tài khoản');
        }


        if (Auth::attempt($req->only('email', 'password'))) {
            $user = Auth::user();

            if ($user->role == 'admin') {
                /** lấy name */
                session()->put('role_admin', $user->name);
                return redirect()->route('manager')->with('manage-success', 'Welcome admin to website');
            } else if ($user->role == 'employees') {
                $id_status = $user->id;
                /** check co dang online */
                User::where('id', $id_status)->update(['last_activity' => "online"]);

                session()->put('role_employees', $user->name);
                return redirect()->route('employees');
            } else {

                session()->put('role_client', $user->name);
                return redirect()->route('website-main');
            }
        }

        return redirect()->back()->with('login-failed', 'email hoặc mật khẩu sai');
    }

    /**
     * laravel support
     * logout
     */
    public function logout(Request $req)
    {

        User::where('id', Auth::user()->id)->update(['last_activity' => "off"]);
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();

        return redirect()->route('wayLogin', ['page' => 'login'])->with('logout-success', "logout successfully!");
    }

    /** client right login before usd website */
    public function checkLogin()
    {
        if (!Auth::check()) {
            abort(redirect()->route('wayLogin', ['page' => 'login']));
        }
    }


    /**
     * show the form
     */
    public function showIndex()
    {
        // Gọi hàm checkLogin() với `return` để xử lý redirect
        if ($redirect = $this->checkLogin()) {
            return $redirect; // chạy không đúng sửa sau
        }

        $content_data = Product::orderByDesc('created_at')->paginate(5);
        return view('layout.index', compact('content_data'));
    }


    // Hiển thị form nhập email để gửi OTP
    public function showOtpForm()
    {
        return view('emails.verify-otp');
    }


    /** form confirm otp email */
    public function formOtpForgot()
    {
        return view('emails.forgot_form_otp');
    }

    /** form update_pw otp email */
    public function forgot_form()
    {
        return view('login.form-forgot');
    }


    /** register email otp */
    public function Register(Request $req)
    {
        // laravel sẽ tự động kiểm tra xem có trường nào ko đúng request sẽ gửi thông báo error
        $req->validate([
            'username' => 'required|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4|confirmed'
        ], [
            'username.max' => 'Username không được vượt quá 50 ký tự.',
            'email.unique' => 'Email đã tồn tại, vui lòng sử dụng email khác!',
            'password.min' => 'Trường mật khẩu phải có ít nhất 4 ký tự.',
            'password.confirmed' => 'Mật khẩu không trùng nhau' //dùng confirmed khi có một field xác nhận tương ứng, ví dụ
        ]);


        $email = $req->input('email');
        Session::put('otp_page', 'register'); // Lưu trạng thái là 'register'

        /** tạo session để lư data check user entry otp rồi mới add account */
        Session::put('user_account_otp', [
            'name' => $req->input('username'),
            'email' => $email,
            'password' => Hash::make($req->input('password'))
        ]);

        // Tạo OTP
        $otp = rand(100000, 999999);
        Session::put('otp', $otp);
        Session::put('email', $email);

        try {
            // Gửi OTP qua email
            Mail::to($email)->send(new OTPMail($otp, $email));
        } catch (\Exception $e) {
            return back()->with('email_send_error', 'Gửi OTP thất bại. Vui lòng thử lại sau.');
        }

        return redirect()->route('otp.form')->with('success_register', 'Đăng ký tài khoản thành công, vui lòng đăng nhập');
    }



    // Gửi lại OTP tới email , hàm này sẽ check xem user đang ở form nào mà di chuyển đúng đến form đó và gửi email
    public function sendOtp()
    {
        $email = session('email'); // Lấy từ session thay vì request



        // Xác định trang trước đó (trang đăng ký hay quên mật khẩu)
        // kiểm tra tra trước đó có chứa form-otp không nếu có thì qua form-otp
        // $previousUrl = url()->previous();
        // $page = str_contains($previousUrl, 'form-otp') ? 'form-otp' : 'otpForgot';



        if (!$email) {
            return redirect()->route('wayLogin', ['page' => 'login'])
                ->with('error', 'Không tìm thấy email trong session, vui lòng đăng ký lại.');
        }

        // Tạo OTP
        $otp = rand(100000, 999999);
        Session::put('otp', $otp);
        Session::put('email', $email);

        // Gửi OTP qua email
        Mail::to($email)->send(new OTPMail($otp, $email));

        return redirect()->back()->with('success', 'Mã OTP mới đã được gửi tới email của bạn.');
    }


    /** check email have exists qua page update password */
    public function forgot(Request $req)
    {

        $email = $req->input('email');


        if (!User::where('email', $email)->first()) {
            return redirect()->back()->with('email_not_exists_forgot', 'This email not exists');
        }

        session()->put('email_user', $email);

        // Tạo OTP
        $otp = rand(100000, 999999);
        Session::put('otp', $otp);
        Session::put('email', $email);

        try {
            // Gửi OTP qua email
            Mail::to($email)->send(new OTPMail($otp, $email));
        } catch (\Exception $e) {
            return back()->with('email_send_error', 'Gửi OTP thất bại. Vui lòng thử lại sau.');
        }


        return redirect()->route('form.otp')->with('email_exists_otp', 'Please entry otp email');
    }


    /** confirm otp send qua email forgot */
    public function verifyOtpForgot(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        if (
            $request->otp == session('otp')
        ) {
            // qua login
            return redirect()->route('forgot_form')->with('success-otp-email-forgot', 'Please enter password new');
        }

        return back()->with('error-forgot-otp', 'Mã OTP không chính xác, vui lòng thử lại.');
    }

    /**update password for client */
    public function update_pw(Request $req)
    {
        $email = $req->input('email');
        $pw = $req->input('password');
        $pw_c = $req->input('password_confirmed');

        if ($pw !== $pw_c) {
            return redirect()->back()->with('password-do-not-match', 'password không trùng nhau!');
        }

        if (strlen($pw) < 4) {
            return redirect()->back()->with('weak-password', 'ký tự password lớn hơn 4!');
        }

        /** lấy password cũ so sách với password new bằng hàm hash::check */
        $pw_old = User::where('email', $email)->first();
        if (Hash::check($pw, $pw_old->password)) {
            return redirect()->back()->with('pw-pw_old-match', 'Mật khẩu mới không được trùng với mật khẩu cũ!');
        }

        $login = User::where('email', $email)->first();
        if ($login) {
            $login->password = hash::make($pw);
            $login->save();
        }

        return redirect()->route('wayLogin', ['page' => 'login'])->with('update_pw_success', 'Update password success');
    }


    // Xác minh OTP rồi create account
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
        ]);


        if (!Session::has('user_account_otp')) {
            return redirect()->route('wayLogin', ['page' => 'login'])
                ->with('error', 'Phiên làm việc đã hết hạn, vui lòng đăng ký lại.');
        }


        if (
            $request->email === session('email') &&
            $request->otp == session('otp')
        ) {
            $userData = Session::get('user_account_otp');
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
                'email_verified_at' => now()
            ]);
            Auth::login($user);
            Session::forget(['otp', 'email', 'user_account_otp']); // Xóa session sau khi thành công
            return redirect()->route('wayLogin', ['page' => 'login'])->with('success', 'Đăng ký và xác thực thành công!');
        }


        return back()->with('email_verifyOtp_failed', 'Mã OTP không chính xác, vui lòng thử lại.');
    }
}