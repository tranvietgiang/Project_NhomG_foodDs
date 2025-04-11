<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PTTTController extends Controller
{
    //
    public function vnpay_payment(Request $request)
    {
        $vnp_TmnCode = "PR7H47SW"; // Mã website của bạn tại VNPAY
        $vnp_HashSecret = "WGUPUW7FBTFZHEF52ZPMDZ7IMFWT1Z7K"; // Chuỗi bí mật
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";

        $vnp_Returnurl = route('vnpay.return'); // URL nhận kết quả trả về
        $vnp_TxnRef = 'madonhang' . time(); // Mã đơn hàng duy nhất
        $vnp_OrderInfo = "Thanh toán hóa đơn";
        $vnp_OrderType = "billpayment";
        $vnp_Amount = $request->input('price') * 100; // Số tiền phải nhân 100 (VNPAY yêu cầu)
        $vnp_Locale = "vn";
        $vnp_BankCode = "NCB"; // Có thể đổi thành ngân hàng khác nếu cần
        $vnp_IpAddr = $request->ip(); // IP khách hàng

        // Tạo dữ liệu gửi đi
        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        ];

        // Tạo chữ ký bảo mật (checksum)
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret); // Tạo mã bảo mật
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;

        // Lưu thông tin vào session (để hiển thị khi thanh toán thành công/thất bại)
        session([
            'vnpay-name' => $request->input('name'),
            'vnpay-price' => $request->input('price')
        ]);

        // Chuyển hướng (redirect) đến trang thanh toán VNPAY
        return redirect($vnp_Url);
    }

    /** show ra bills */
    public function vnpay_return(Request $request)
    {
        // lưu data vào data base
        $status = 'success'; // Hoặc lấy từ logic kiểm tra
        $vnp_TxnRef = $request->input('vnp_TxnRef', 'No Data');
        $name = session('vnpay-name');
        $price = session('vnpay-price');

        return view('component.header.admin.pttt.form-vnpay-checkout', compact('status', 'vnp_TxnRef', 'name', 'price'));
    }
}
