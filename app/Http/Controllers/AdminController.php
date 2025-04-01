<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\session\session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function checkLogin()
    {
        if (!Auth::check()) {
            return redirect()->route('wayLogin', ['page' => 'login']);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function showEmployees()
    {
        // Gọi hàm checkLogin() với `return` để xử lý redirect
        if ($redirect = $this->checkLogin()) {
            return $redirect;
        }

        // Lấy danh sách nhân viên với phân trang và sắp xếp
        $list_employees = User::where('role', 'employees')
            ->orderByDesc('created_at')
            ->paginate(10); // Sử dụng paginate() để hỗ trợ firstItem()


        return view('component.header.admin.employees.show', compact('list_employees'));
    }



    public function listClient()
    {
        // Gọi hàm checkLogin() với `return` để xử lý redirect
        if ($redirect = $this->checkLogin()) {
            return $redirect;
        }

        $list_client = User::where('role', 'user')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('component.header.admin.client.list-client', compact('list_client'));
    }

    /** show information client */
    public function search_client(Request $reqName)
    {
        $keyword = $reqName->input('search');


        /**chỉ tìm một điều kiện closure */
        // $list_client = User::where('role', 'user')
        //     ->where('name', 'like', "%{$keyword}%")
        //     ->orderByDesc('created_at')
        //     ->paginate(4);

        /**
         *  lưu ý: closure , sử dụng từ khóa 'use' dể sử dụng varible keyword bên ngoài hàm
         *  nếu dùng 2 điều kiện search thì nên dùng closure nếu chỉ dùng một name để tìm thì ko cần dùng closure
         *  vd dùng name and email => closure
         */

        $list_client = User::where('role', 'user')
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
            })
            ->orderByDesc('created_at')
            ->paginate(4);

        return view('component.header.admin.client.list-client', compact('list_client'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }


    public function showVnPayCheckout()
    {
        return view('component.header.admin.pttt.vnpay-payment');
    }



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


    /** show data content-product */

    //     public function content_product()
    //     {
    //         $content_data = Product::orderByDesc('created_at')->paginate(5);
    //         return view('component.content.content', compact('content_data'));
    //     }
}
