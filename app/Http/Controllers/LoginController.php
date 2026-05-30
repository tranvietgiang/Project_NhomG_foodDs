<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Middleware\checkLogin;
use App\Http\Middleware\LastActivity;
use App\Mail\OTPMail;
use App\Models\bill_product;
use App\Models\Cart;
use App\Models\Client;
use App\Models\day;
use App\Models\district;
use App\Models\login;
use App\Models\month;
use App\Models\province;
use App\Models\Review;
use App\Models\User;
use App\Models\ward;
use App\Models\year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($page)
    {
        //
        if (Auth::check()) {
            return redirect()->route('website-main');
        }

        $checkWay = ['login', 'register', 'forgot'];

        if (!in_array($page, $checkWay)) {
            abort(404);
        }

        //Thêm một lớp bảo vệ nữa nếu file resources/views/login/{page}.blade.php không tồn tại thực sự.
        if (!view()->exists("login.$page")) {
            abort(404, "Page not found"); // Hoặc redirect, tùy ý
        }

        return view("login.$page");
    }


    /**
     * login : kiểm tra user có đăng nhập chưa
     * git
     */
    public function login(Request $req)
    {
        $req->validate([
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:72',
        ], [
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            'password.max' => 'Mật khẩu không được vượt quá 72 ký tự.',
        ]);

        $originalEmail = $_POST['email'] ?? '';
        $email = trim($originalEmail);
        $password = $req->input('password');
        // dd($password);



        $key = 'login|' . $req->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return redirect()->back()->with("login-seconds", "Quá nhiều lần thử đăng nhập. Vui lòng thử lại sau $seconds giây.");
        }

        /**check client entered? */
        if (empty($email) || empty($password)) {
            RateLimiter::hit($key, 60);
            return  redirect()->back()->with('email-password-empty', 'Vui lòng nhập đầy đủ email && password');
        }

        // Kiểm tra email hợp lệ trước khi truy vấn database
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            RateLimiter::hit($key, 60);
            return redirect()->back()->with('invalid-email', 'Email không hợp lệ, vui lòng nhập lại.');
        }

        // Chặn nếu người dùng nhập khoảng trắng ở đầu/cuối email
        if ($originalEmail != $email) {
            RateLimiter::hit($key, 60);
            return redirect()->back()->with("email-space", "Email không được chứa khoảng trắng!");
        }

        // Kiểm tra mật khẩu phải có ít nhất 5 ký tự
        $length_pass = strlen($password);
        if ($length_pass < 8 || $length_pass > 72) {
            RateLimiter::hit($key, 60);
            return redirect()->back()->with('short-password', 'Mật khẩu không được nhỏ hơn 8 và lớn hơn 72 ký tự!');
        }

        /** email not exists in database */
        if (!User::where('email', $req->email)->exists()) {
            return  redirect()->back()->with('email-not-exists', 'Email này chưa được đăng ký vào tài khoản');
        }

        if (!Auth::attempt($req->only('email', 'password'))) {
            // Nếu sai thì tăng số lần thử
            RateLimiter::hit($key, 60);
            return redirect()->back()->with('wrong-password', 'mật khẩu không đúng!');
        }






        /**
         * Auth::attempt(): Laravel sẽ kiểm tra xem email và mật khẩu có đúng không.
         * $req->only('email', 'password'): Chỉ lấy 2 giá trị từ request.
         */
        if (Auth::attempt($req->only('email', 'password'))) {
            $user = Auth::user();
            RateLimiter::clear($key);
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
            } else if ($user->role == 'user') {
                /** số lần đăng nhập */
                session()->put('role_client', $user->name);
                session()->put('role_client_email', $user->email);
                return redirect()->route('website-main');
            } else {
                // Trường hợp không hợp lệ
                Auth::logout(); // Đăng xuất để tránh đăng nhập bất thường
            }
        }
        return redirect()->back()->withErrors([
            'login-failed' =>
            'email hoặc mật khẩu sai',
        ])->withInput();
    }

    /**
     * laravel support
     * logout
     * git
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
        if (Auth::check()) {

            if (Auth::user()->role != 'user') {
                // Auth::logout(); // Đăng xuất user hiện tại
                return redirect()->route('wayLogin', ['page' => 'login']);
            }

            $login_count = Client::where('user_id', Auth::user()->id)->first();
            if ($login_count) {
                $login_count->increment('login_count', 1);
            }
        }


        $products = Product::latest()->take(8)->get();

        /** ít bửa sửa lại thành desc! */
        $content_data = Product::orderBy('created_at', 'ASC')->paginate(5);

        $content_data_hung = Product::orderBy('created_at', 'ASC')->paginate(8);

        /** get amount client buyed */
        $product_sold = DB::table('bill_products')
            ->select('product_id', DB::raw('COUNT(*) as sold_count'))
            ->groupBy('product_id')
            ->pluck('sold_count', 'product_id'); // trả về kiểu: [product_id => sold_count]

        $amount_star_5 = DB::table('reviews')
            ->select('product_id', 'review_rating', DB::raw('COUNT(review_rating) as star_count'))
            ->where('review_rating', 5)
            ->groupBy('product_id', 'review_rating')
            ->pluck('star_count', 'product_id');

        /** lấy ra số lượng sản phẩm trong cart my client */
        $amount_cart_header =  Cart::where('user_id', Auth::id())->count();

        return view('layout.index', compact(['content_data', 'products', 'content_data_hung', 'product_sold', 'amount_star_5', 'amount_cart_header']));
    }

    /** những sản phẩm bán chạy nhất */
    public function OrderBestSale()
    {
        $content_data = DB::table('products as item')
            ->join('bill_products as a', 'item.product_id', '=', 'a.product_id')
            ->select(
                'item.product_id',
                'item.product_name',
                'item.product_image',
                'item.product_price',
                DB::raw('SUM(a.quantity) as SOLUONG')
            )
            ->groupBy('item.product_id', 'item.product_name', 'item.product_image', 'item.product_price')
            ->orderByDesc('SOLUONG')
            ->limit(5)
            ->get();

        // dd($content_data);

        $amount_star_5 = DB::table('reviews')
            ->select('product_id', 'review_rating', DB::raw('COUNT(review_rating) as star_count'))
            ->where('review_rating', 5)
            ->groupBy('product_id', 'review_rating')
            ->pluck('star_count', 'product_id');
        /* pluck('value_column', 'key_column') */

        return response()->json(
            [
                "data" => $content_data,
                'amount_star_5' => $amount_star_5
            ]
        );
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




    /** register email otp git */
    public function Register(Request $req)
    {
        /*explain: alpha_num:
         * Chữ cái trong alpha_num:
         * Chỉ bao gồm các ký tự chữ cái từ a-z và A-Z (theo bảng chữ cái Latinh, tức là ký tự ASCII).
         * Không bao gồm các ký tự chữ cái từ các ngôn ngữ khác như tiếng Nhật (hiragana, katakana, kanji), tiếng Trung, tiếng Hàn, v.v.
         * Không bao gồm các ký tự đặc biệt (như @, #, $, v.v.) hoặc dấu cách (space).
         */
        /**
         * 📌 Giải thích từng phần:
         * 
         * required: Trường bắt buộc (không được bỏ trống).

         * max:50: Giới hạn tối đa 50 ký tự.

         * email: Phải là email hợp lệ.

         * unique:users,email	Kiểm tra email có tồn tại trong bảng users chưa. Nếu có rồi, nó báo lỗi. Dùng để kiểm tra trùng lặp khi đăng ký.
         
         * exists:users,email	Kiểm tra email có tồn tại trong bảng users không. Nếu không có, nó báo lỗi. Dùng để kiểm tra khi đăng nhập hoặc khôi phục mật khẩu.
         
         * min:4: Mật khẩu phải có ít nhất 4 ký tự.

         * confirmed: Laravel sẽ kiểm tra xem có password_confirmation không, nếu không có hoặc không khớp, sẽ báo lỗi.
         */
        $originalName = $_POST['username'] ?? '';
        $username = trim($originalName);

        $originalEmail = $_POST['email'] ?? '';
        $email = trim($originalEmail);

        $password = $_POST['password'] ?? '';

        $a = $originalName !== $username ? true : false;
        $b = $originalEmail !== $email ? true :  false;
        if ($a && $b) {
            return redirect()->back()->with("email-name-space", "Username && Email không được chứa khoảng trắng!");
        }

        if ($originalName !== $username) {
            return redirect()->back()->with("username-space", "username không được chứa khoảng trắng!");
        }
        // Kiểm tra username
        if ($originalEmail !== $email) {
            return redirect()->back()->with("email-space", "Email không được chứa khoảng trắng!");
        }


        /** check password */
        if (strlen($password) < 8) {
            return back()->with('regex-weak-password', 'Mật khẩu phải có ít nhất 8 ký tự.');
        }

        if (!preg_match('/[a-z]/', $password)) {
            return back()->with('regex-weak-password', 'Mật khẩu phải chứa ít nhất một chữ thường.');
        }

        if (!preg_match('/[A-Z]/', $password)) {
            return back()->with('regex-weak-password', 'Mật khẩu phải chứa ít nhất một chữ hoa.');
        }

        if (!preg_match('/\d/', $password)) {
            return back()->with('regex-weak-password', 'Mật khẩu phải chứa ít nhất một số.');
        }

        if (!preg_match('/[@$!%*?&]/', $password)) {
            return back()->with('regex-weak-password', 'Mật khẩu phải chứa ít nhất một ký tự đặc biệt.');
        }

        if (preg_match('/\s/', $password)) {
            return back()->with('regex-weak-password', 'Mật khẩu không được chứa khoảng trắng.');
        }


        $req->validate([
            'username' => 'required|min:6|max:50|alpha_num',
            'email' => 'required|email|max:255|unique:users,email',
            // 'password' => 'required|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', //regex: Yêu cầu ít nhất một chữ thường, một chữ hoa, một số, một ký tự đặc biệt.
            'password' => 'required|string|max:72|confirmed'
        ], [
            'username.max' => 'Username không được vượt quá 50 ký tự.',
            'username.min' => 'Username không được nhỏ hơn 6 ký tự.',
            'username.alpha_num' => 'Username chỉ được chứa chữ cái và số.',
            'email.unique' => 'Email đã tồn tại, vui lòng sử dụng email khác!',
            'email.email' => 'Email phải đúng định dạng',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            'password.max' => 'Mật khẩu không được vượt quá 72 ký tự.',
            'password.min' => 'Trường mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Mật khẩu không trùng nhau', //dùng confirmed khi có một field xác nhận tương ứng, ví dụ
            // 'password.regex' => 'Mật khẩu phải chứa ít nhất một chữ hoa, một chữ thường, một số và một ký tự đặc biệt.',
        ]);



        Session::put('otp_page', 'register'); // Lưu trạng thái là 'register'

        /** tạo session để lư data check user entry otp rồi mới add account */
        Session::put('user_account_otp', [
            'name' => $username,
            'email' => $email,
            'password' => Hash::make($password)
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

        return redirect()->route('otp.form');
    }



    // git forget Gửi lại OTP tới email , hàm này sẽ check xem user đang ở form nào mà di chuyển đúng đến form đó và gửi email
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


    /** check email have exists qua page update password git */
    public function forgot(Request $req)
    {
        $req->validate([
            'email' => 'required|string|max:255',
        ], [
            'email.max' => 'Email không được vượt quá 255 ký tự.',
        ]);

        $originalEmail = $_POST['email'] ?? '';
        $email = trim($originalEmail);


        // dd([$originalEmail, $email]);

        if ($originalEmail != $email) {
            return redirect()->back()->with('email-space', 'email không được chứa khoảng trắng');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('invalid-email', 'Email không hợp lệ, vui lòng nhập lại.');
        }

        // dd($_POST['email']);

        if (!User::where('email', $email)->first()) {
            return redirect()->back()->with('email_not_exists_forgot', 'Email này chưa được đăng ký');
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


        return redirect()->route('form.otp')->with('email_exists_otp', 'Vui lòng nhập otp');
    }


    /** confirm otp send qua email forget */
    public function verifyOtpForgot(Request $request)
    {

        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        if ($request->otp == session('otp')) {
            // qua login
            return redirect()->route('forgot_form')->with('success-otp-email-forgot', 'Vui lòng nhập password mới!');
        }

        return back()->with('failed', 'Mã OTP không chính xác, vui lòng thử lại.');
    }

    /**update password for client forget */
    public function update_pw(Request $req)
    {
        $req->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:72',
            'password_confirmed' => 'required|string|max:72',
        ], [
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            'password.max' => 'Mật khẩu không được vượt quá 72 ký tự.',
            'password_confirmed.max' => 'Mật khẩu xác nhận không được vượt quá 72 ký tự.',
        ]);

        $email = $req->input('email');
        $pw = $req->input('password');
        $pw_c = $req->input('password_confirmed');


        // 3. Kiểm tra regex
        /**
         * Biểu thức trên có nghĩa:

         *(?=.*[a-z]): có ít nhất 1 chữ thường

         *(?=.*[A-Z]): có ít nhất 1 chữ hoa

         *(?=.*\d): có ít nhất 1 số

         *(?=.*[@$!%*?&]): có ít nhất 1 ký tự đặc biệt

         *[A-Za-z\d@$!%*?&]{8,}: tổng cộng ít nhất 8 ký tự, chỉ gồm những ký tự này
         */
        // if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[^\s]{8,}$/', $pw)) {
        // Mật khẩu không hợp lệ
        //     return redirect()->back()->with('regex-weak-password', 'Mật khẩu phải chứa ít nhất một chữ hoa, một chữ thường, một số và một ký tự đặc biệt, không có khoảng trắng.');
        // }


        if (strlen($pw) < 8) {
            return back()->with('regex-weak-password', 'Mật khẩu phải có ít nhất 8 ký tự.');
        }

        if (!preg_match('/[a-z]/', $pw)) {
            return back()->with('regex-weak-password', 'Mật khẩu phải chứa ít nhất một chữ thường.');
        }

        if (!preg_match('/[A-Z]/', $pw)) {
            return back()->with('regex-weak-password', 'Mật khẩu phải chứa ít nhất một chữ hoa.');
        }

        if (!preg_match('/\d/', $pw)) {
            return back()->with('regex-weak-password', 'Mật khẩu phải chứa ít nhất một số.');
        }

        if (!preg_match('/[@$!%*?&]/', $pw)) {
            return back()->with('regex-weak-password', 'Mật khẩu phải chứa ít nhất một ký tự đặc biệt.');
        }

        if (preg_match('/\s/', $pw)) {
            return back()->with('regex-weak-password', 'Mật khẩu không được chứa khoảng trắng.');
        }


        //  Kiểm tra password khớp với password_confirmed
        if ($pw !== $pw_c) {
            return redirect()->back()->with('password-do-not-match', 'password không trùng nhau!');
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


    //git register Xác minh OTP yêu cầu từ hàm(Register) rồi xuống đây mới create account
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'otp' => 'required|digits:6',
        ]);


        /** nếu người dùng để chờ nhập otp quá
         * Nếu người dùng rời khỏi trang hoặc đóng trình duyệt, session có thể hết hạn, lúc này Laravel báo lỗi "Phiên làm việc đã hết hạn".
         * bạn có thể thiết lập session timeout trong config/session.php:
         * 'lifetime' => 120, // Số phút trước khi session hết hạn
         */
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
                'email_verified_at' => now(),
                'provider' => '',
                'provider_id' => ''
            ]);

            // /** khi mà đăng ký thì client sẽ được information client */
            // Client::create([
            //     'user_id' => $user->id,
            //     'client_name' => $userData['name']
            // ]);

            Auth::login($user);
            Session::forget(['otp', 'email', 'user_account_otp']); // Xóa session sau khi thành công
            return redirect()->route('wayLogin', ['page' => 'login'])->with('success_register', 'Đăng ký tài khoản thành công, vui lòng đăng nhập');
        }


        return back()->with('email_verifyOtp_failed', 'Mã OTP không chính xác, vui lòng thử lại.');
    }

    /** hiện thị tên huyện/quận */
    public function getDistricts(Request $request)
    {
        $request->validate([
            'province_id' => 'required|integer|exists:tb_provinces,province_id',
        ]);

        $districts = district::where('province_id', $request->province_id)->get();
        return response()->json($districts);
    }

    /** hiện thị tên xã/phường */
    public function getWards(Request $request)
    {
        $request->validate([
            'district_id' => 'required|integer|exists:tb_districts,district_id',
        ]);

        $wards = ward::where('district_id', $request->district_id)->get();
        return response()->json($wards);
    }

    /** show form information client git */
    public function show_information(Request $req)
    {

        $day = Day::orderBy('day', 'ASC')->get();
        $year = Year::orderBy('year', 'ASC')->get();

        $provinces = province::orderBy('province_id', 'ASC')->get();


        $client_image = Client::where('user_id', Auth::user()->id)->first(['client_avatar']);

        $amount_cart_header =  Cart::where('user_id', Auth::id())->count();
        return view('component.header.admin.client.information', compact('day', 'year', 'provinces', 'client_image', 'amount_cart_header'));
    }
}
