<?php

namespace App\Http\Controllers;
use App\Models\Cart; // Hoặc đường dẫn đúng tới model Cart của bạn

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    public function momo_payment(Request $request)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = $request->input('totalAmount'); // Sửa ở đây
        $orderId = time() . "";
        $redirectUrl = "http://localhost:8000/food_ds.com";
        $ipnUrl = "http://localhost:8000/food_ds.com";
        $extraData = "";

        $requestId = time() . "";
        $requestType = "payWithATM";
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey); // Sửa ở đây
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );

        $result = $this->execPostRequest($endpoint, json_encode($data)); // Gọi hàm với $this
        var_dump($result); // Kiểm tra giá trị của $result
        
        $jsonResult = json_decode($result, true); // Giải mã JSON
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo 'Lỗi khi giải mã JSON: ' . json_last_error_msg();
            return; // Dừng lại nếu có lỗi
        }
        
        // // Kiểm tra tồn tại payUrl và resultCode
        // if (isset($jsonResult['payUrl']) && isset($jsonResult['payUrl']['resultCode']) && $jsonResult['payUrl']['resultCode'] === "0") {
        //     $userId = Auth::id(); // Lấy user_id của người dùng hiện tại
        
        //     if ($userId) {
        //         // Xóa tất cả sản phẩm trong giỏ hàng của người dùng
        //         Cart::where('user_id', $userId)->delete(); // Xóa toàn bộ giỏ hàng
        //     } else {
        //         // Xử lý trường hợp không tìm thấy user_id
        //     }
        // }
        
     
        return redirect()->to($jsonResult['payUrl']);
        // dd($jsonResult);
        // Xử lý $jsonResult ở đây
    }
    public function handlePaymentSuccess(Request $request)
    {
        $data = $request->all();
    
        // Kiểm tra trạng thái thanh toán
        if ($data['errorCode'] === '0') {
            $userId = Auth::id();// Lấy user_id của người dùng hiện tại
    
            // Xóa tất cả sản phẩm trong giỏ hàng của người dùng
            Cart::where('user_id', $userId)->delete(); // Xóa toàn bộ giỏ hàng
        }
    
        return dd($data['errorCode']);
    }
}       