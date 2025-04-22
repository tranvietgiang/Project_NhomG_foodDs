<?php

namespace App\Http\Controllers;

use App\Models\bill;
use App\Models\bill_product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ZaloPayController extends Controller
{
    public function zalopay(Request $request)
    {
        // Lấy cấu hình từ .env
        $config = [
            "appid" => 553,
            "key1" => "9phuAOYhan4urywHTh0ndEXiV3pKHr5Q",
            "key2" => "Iyz2habzyr7AG8SgvoBCbKwKi3UzlLi3",
            "endpoint" => "https://sandbox.zalopay.com.vn/v001/tpe/createorder"
        ];

        $amount = $request->input('total_price_payment');

        $embeddata = [
            "merchantinfo" => "embeddata123",

            /**
             * ✅ Mục đích:
             * Tạo 1 URL kèm tham số trên query string để chuyển hướng người dùng về trang callback, đồng thời truyền dữ liệu như tên, tên sản phẩm, hình ảnh, giá, số lượng… thông qua URL.
             */
            "redirecturl" => route('zalo.callback') . '?' . http_build_query([
                'client_name' => Auth::user()->name,
                'product_name' => $request->input('product_name'),
                'product_image' => $request->input('product_image'),
                'total_price' => $amount,
                'product_quantity' => $request->input('product_quantity')
            ]),
        ];


        // Tính tổng số tiền từ các items

        $order = [
            "appid" => $config["appid"],
            "apptime" => round(microtime(true) * 1000), // milliseconds
            "apptransid" => date("ymd") . "_" . uniqid(), // mã giao dịch
            "appuser" => "demo",
            "item" => json_encode([
                [
                    "itemid" => 'SanPham' . $request->input('product_id'),
                    "itemname" => $request->input('product_name'),
                    "itemprice" => $amount,
                    "itemquantity" => 1
                ]
            ], JSON_UNESCAPED_UNICODE),
            "embeddata" => json_encode($embeddata, JSON_UNESCAPED_UNICODE),
            "amount" => $amount,
            "description" => "ZaloPay Integration Demo",
            // Thay đổi hoặc bỏ qua bankcode để hiển thị trang chọn ngân hàng
            // "bankcode" => "zalopayapp"
        ];


        // bị  lỗi vì redirect qua nhiều trang khác nhau dẫn đến mất session dẫn đến zalo_callback ko nhận dc data đúng
        // session()->put('client_name', Auth::user()->name);
        // session()->put('product_name', $request->input('product_name'));
        // session()->put('product_image', $request->input('product_image'));
        // session()->put('total_price', $amount);
        // session()->put('product_quantity', $request->input('product_quantity'));



        // Tạo chuỗi dữ liệu để tính MAC
        $data = $order["appid"] . "|" . $order["apptransid"] . "|" . $order["appuser"] . "|" . $order["amount"]
            . "|" . $order["apptime"] . "|" . $order["embeddata"] . "|" . $order["item"];

        $order["mac"] = hash_hmac("sha256", $data, $config["key1"]);

        // Gửi yêu cầu tới ZaloPay API
        $context = stream_context_create([
            "http" => [
                "header" => "Content-type: application/x-www-form-urlencoded\r\n",
                "method" => "POST",
                "content" => http_build_query($order)
            ]
        ]);

        // Lưu thông tin đơn hàng vào session để dùng khi redirect về

        /** khi thanh toán đã thêm sản phẩm vào cart rồi */
        // DB::table('carts')->insert([
        //     'product_id' => $request->input('product_id'),
        //     'user_id' => Auth::id(),
        //     'product_id' => $request->input('product_id'),
        //     'quantity_sp' => $request->input('product_quantity'), // đây là số lượng sản phẩm mà user mua chứ không tổng các loại
        //     'total_price' => $request->input('product_price'), // là số tiền chưa cộng all lại
        // ]);

        $bills = bill::create([
            'user_id' => Auth::id(),
            'cart_id' => $request->input('cart_id_payment'),
            'method_payment_id' => 3
        ]);

        bill_product::create([
            'bill_id' => $bills->bill_id,
            'product_id' => $request->input('product_id'),
            'quantity' => 1
        ]);

        $resp = file_get_contents($config["endpoint"], false, $context);
        $result = json_decode($resp, true);

        // Kiểm tra kết quả trả về từ ZaloPay
        if (isset($result['orderurl'])) {
            header("Location: " . $result['orderurl']);
            exit();
        } else {
            echo "error-khong-gui-dc";
        }
    }


    public function callback_zalopay(Request $request)
    {
        // dd(session()->all());

        // Giả sử bạn truyền mã giao dịch qua embeddata hoặc lưu session lúc tạo đơn
        $orderId = $request->get('apptransid');


        // $client_name = session('client_name');
        // $product_name = session('product_name');
        // $product_image = session('product_image');
        // $total_price = session('total_price');
        // $product_quantity = session('product_quantity');
        // $status = 'success';

        $client_name = $request->get('client_name');
        $product_name = $request->get('product_name');
        $product_image = $request->get('product_image');
        $total_price = $request->get('total_price');
        $product_quantity = $request->get('product_quantity');
        $status = 'success';

        return view('component.header.admin.pttt.form-zalopay-checkout', compact(
            'status',
            'orderId',
            'product_name',
            'product_quantity',
            'total_price',
            'product_image',
            'client_name'
        ));
    }
}