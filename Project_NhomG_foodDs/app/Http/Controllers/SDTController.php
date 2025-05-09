<?php

namespace App\Http\Controllers;

use App\TwilioService;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\hash;
use Illuminate\Support\Facades\Session;


class SDTController extends Controller
{

    public function sendSMSDemo(TwilioService $twilio)
    {
        $twilio->sendSMS('+849xxxxxxxx', 'Hello from Laravel + Twilio!');
        return 'SMS Sent!';
    }

    public function sendSMS()
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $from = env('TWILIO_PHONE_NUMBER');

        $client = new Client($sid, $token);

        $to = '+849xxxxxxxx'; // số điện thoại cần gửi
        $otp = rand(100000, 999999); // sinh OTP 6 chữ số

        $message = "Mã OTP của bạn là: $otp";

        $client->messages->create($to, [
            'from' => $from,
            'body' => $message
        ]);

        return view('otp', ['otp' => $otp, 'phone' => $to]);
    }



    public function sendOtp(Request $request)
    {
        $phone = $request->input('phone');

        $otp = rand(100000, 999999);

        // Gửi OTP bằng Twilio
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $from = env('TWILIO_PHONE_NUMBER');

        $twilio = new Client($sid, $token);
        $twilio->messages->create($phone, [
            'from' => $from,
            'body' => "Mã OTP của bạn là: $otp"
        ]);

        // Lưu OTP và SDT vào session để xác minh
        Session::put('otp', $otp);
        Session::put('phone', $phone);

        return view('component.sdt.otp', ['phone' => $phone]);
    }


    public function verifyOtp(Request $request)
    {
        $enteredOtp = $request->input('otp');
        $realOtp = Session::get('otp');
        $phone = Session::get('phone');

        if ($enteredOtp == $realOtp) {
            Session::forget(['otp', 'phone']);
            return back()->with('success', 'Xác minh thành công! SĐT: ' . $phone);
        } else {
            return back()->with('error', 'Mã OTP không đúng!');
        }
    }
}