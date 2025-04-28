<?php

namespace App\Http\Controllers;

use App\Models\bill;
use App\Models\bill_product;
use App\Models\Cart;
use App\Models\Cart_buyed;
use App\Models\Client;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PTTTController extends Controller
{
    //
    public function vnpay_payment(Request $request)
    {
        // kiểm tra xem user đã có điạ chỉ chưa
        $check_address = Client::where('user_id', Auth::id())->exists();

        if (empty($check_address)) {
            return redirect()->back()->with('address_null', 'Vui lòng quay về form cá nhân để nhập thông tin địa chỉ, xin cảm ơn');
        }


        $vnp_TmnCode = "PR7H47SW"; // Mã website của bạn tại VNPAY
        $vnp_HashSecret = "WGUPUW7FBTFZHEF52ZPMDZ7IMFWT1Z7K"; // Chuỗi bí mật
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";

        $vnp_Returnurl = route('vnpay.return'); // URL nhận kết quả trả về
        $vnp_TxnRef =  time(); // Mã đơn hàng duy nhất
        $vnp_OrderInfo = "Thanh toán hóa đơn";
        $vnp_OrderType = "billpayment";
        $vnp_Amount = $request->input('total_price_payment') * 100; // Số tiền phải nhân 100 (VNPAY yêu cầu)
        $vnp_Locale = "vn";
        $vnp_BankCode = "NCB"; // Có thể đổi thành ngân hàng khác nếu cần
        // $vnp_IpAddr = $request->ip(); // IP khách hàng
        $vnp_IpAddr = $request->input('user_id_payment'); // IP khách hàng

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
            "vnp_ReturnUrl" => $vnp_Returnurl, // vnpay sẽ tra về route và sẽ tìm đến cái route vnp_Returnurl và xử lý tiếp
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



        $product_id = $request->input('product_id');

        $cart = Cart::where('user_id', Auth::id())->orderByDesc('cart_id')->first();

        // Lưu thông tin vào session (để hiển thị khi thanh toán thành công/thất bại)
        session([
            'vnpay' => [
                'name' => $request->input('product_name'),
                'price' => $vnp_Amount,
                'image' => $request->input('product_image'),
                'quantity' => $request->input('product_quantity'),
                'client_name' => Auth::user()?->name,
                'order_id' => $vnp_TxnRef,
                'delete_cart' => $cart->cart_id,
            ]
        ]);

        $cartbuyed = Cart_buyed::create([
            'cart_id' => $request->input('cart_id_payment'),
            'user_id' => Auth::id(),
            'product_id' => $product_id,
            'quantity_sp' => $request->input('product_quantity'),
            'total_price' => $request->input('product_price'),
            'image' =>  $request->input('product_image'),
        ]);

        // 1. Tạo bill
        $bill = bill::create([
            'user_id' => Auth::id(),
            'cart_id' => $cartbuyed->cart_id,
            'method_payment_id' => 1 // vnpay
        ]);

        // 2. Tạo bill_product
        bill_product::create([
            'bill_id' => $bill->bill_id, // nếu là bill_id thì sửa thành $bill->bill_id
            'product_id' =>  $product_id,
            'quantity' => 1 // 1 là số lượng mặc định mà khách hàng bấm vào sản phẩm và mua ngay
        ]);

        /** sau khi thanh toán thành công thì xóa đi cart của client */
        Cart::where('user_id', Auth::id())->where('cart_id', $cartbuyed->cart_id,)->delete();

        // Chuyển hướng (redirect) đến trang thanh toán VNPAY
        return redirect($vnp_Url);
    }

    /** show ra bills */
    public function vnpay_return(Request $request)
    {

        $vnpData = session('vnpay', []);


        // xau khi thanh toán thành công thì xóa đi cart
        /** tại vì phải xóa thằng bill mới xóa dc thằng cart */
        // bill::where('cart_id', $delete_cart)->where('user_id', Auth::id())->delete();
        // Cart::where('cart_id', $delete_cart)->where('user_id', Auth::id())->delete();

        // lưu data vào data base
        $name = $vnpData['name'];
        $price = $vnpData['price'];
        $orderId = $vnpData['order_id'];
        $image = $vnpData['image'];
        $quantity = $vnpData['quantity'];
        $client = $vnpData['client_name'];

        $status = 'success';

        return view('component.header.admin.pttt.form-vnpay-checkout', compact('status', 'orderId', 'name', 'price', 'image', 'quantity', 'client'));
    }




    /** thanh toán khi nhận hàng*/
    public function payment_cod(Request $req)
    {
        // kiểm tra xem user đã có điạ chỉ chưa
        $check_address = Client::where('user_id', Auth::id())->exists();

        /** nếu chưa quay về */
        if (empty($check_address)) {
            return redirect()->back()->with('address_null', 'Vui lòng quay về form cá nhân để nhập thông tin địa chỉ, xin cảm ơn');
        }


        $product_id = $req->input('product_id');
        $sl_client = $req->input('product_quantity');

        try {
            /** là khi client click mua đơn hàng tạo bên cart một cái id xong qua bên này add
             * cái đơn hàng mà người dùng đã mua đó xong thêm vào cái bill trách trường hợp xóa đơn
             * hàng sau khi thanh toán thành công ko bị lỗi
             */
            $cartbuyed = Cart_buyed::create([
                'cart_id' => $req->input('cart_id_payment'),
                'user_id' => Auth::id(),
                'product_id' => $product_id,
                'quantity_sp' => $req->input('product_quantity'),
                'total_price' => $req->input('product_price'),
                'image' =>  $req->input('product_image'),
            ]);

            // 1. Tạo bill
            $bill = bill::create([
                'user_id' => Auth::id(),
                'cart_id' => $cartbuyed->cart_id,
                'method_payment_id' => 2 // 2 là thanh toán khi nhận tiền mặc định của pttt
            ]);

            // 2. Tạo bill_product
            bill_product::create([
                'bill_id' => $bill->bill_id, // nếu là bill_id thì sửa thành $bill->bill_id
                'product_id' =>  $product_id,
                'quantity' => 1 // 1 là số lượng mặc định mà khách hàng bấm vào sản phẩm và mua ngay
            ]);

            /** sau khi thanh toán thành công thì xóa đi cart của client */
            Cart::where('user_id', Auth::id())->where('cart_id', $cartbuyed->cart_id,)->delete();

            /** trừ đi số lượng sản phẩm đã bán */
            $sl_items = Product::Where('product_id', $product_id)->value('quantity_store');

            $sl_store = $sl_items - $sl_client;


            Product::where('product_id', $product_id)->update([
                'quantity_store' => $sl_store
            ]);

            // 4. Trả về kết quả qua form bill
            return redirect()->route('bill.show_bill_product', ['cart_id' => $bill->cart_id]);
        } catch (\Exception $e) {
            // Nếu lỗi khi tạo bill hoặc bill_product thì bắt ở đây
            return redirect()->back()->with('payment-error', 'Đặt hàng thất bại: ' . $e->getMessage());
        }
    }
}