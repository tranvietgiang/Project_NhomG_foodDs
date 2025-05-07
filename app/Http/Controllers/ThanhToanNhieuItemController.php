<?php

namespace App\Http\Controllers;

use App\Models\bill;
use App\Models\bill_product;
use App\Models\Cart;
use App\Models\Cart_buyed;
use App\Models\Client;
use App\Models\Product;
use App\Models\ThanhToanNhieuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ThanhToanNhieuItemController extends Controller
{
    public function momo(Request $request) {}
    public function call_back(Request $request) {}



    public function cod(Request $request)
    {

        $checkAddress = Client::where('user_id', Auth::id())->exists();
        if (!$checkAddress) {
            return redirect()->back()->with('addressNotExists', 'Bạn chưa có thông tin nhận hàng, vui lòng điền thông tin để nhận hàng tại đây');
        }

        $cartShow = json_decode($request->input('arrShow')); // giờ mới là array of object

        foreach ($cartShow as $item) {
            $cartExit = Cart_buyed::where('cart_id', $item->cart_id)
                ->where('product_id', $item->product_id)
                ->where('user_id', Auth::id())->exists();

            if (!$cartExit) {
                Cart_buyed::create([
                    'cart_id' => $item->cart_id ?? null,
                    'product_id' => $item->product_id ?? null,
                    'user_id' => Auth::id(),
                    'quantity_sp' => $item->quantity_sp ?? null,
                    'total_price' => $item->total_price ?? null,
                ]);

                $bills = bill::create([
                    'user_id' => Auth::id(),
                    'cart_id' => $item->cart_id,
                    'method_payment_id' => 2
                ]);

                bill_product::create([
                    'bill_id' => $bills->bill_id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity_sp
                ]);

                Cart::where('cart_id', $item->cart_id)->where('user_id', Auth::id())->delete();
            }
        }

        return view('component.header.dathang.billSuccessCartMany');
    }

    // ==================================================================================================
    public function cart_shows_goods(Request $request)
    {

        if (!Auth::check()) {
            return redirect()->route('wayLogin', ['page' => 'login']);
        }

        // Lấy user hiện tại
        $userId = Auth::id();


        $cartMany = DB::table('carts')
            ->select('products.*', 'carts.*')
            ->join('products', 'carts.product_id', '=', 'products.product_id')
            ->where('user_id', $userId)
            ->orderByDesc('carts.created_at')->get();


        $check_address = Client::where('user_id', $userId)->exists();

        if (!$check_address) {
            session()->put('address_exists', 'Quý khách vui lòng kiểm tra lại đơn hàng và thông tin địa chỉ trước khi tiến
                hành thanh toán');
        } else {
            session()->put('address_exists', '');
        }


        /** get amount categories */
        $amount_cart_header =  Cart::where('user_id', Auth::id())->count();

        return view('component.header.dathang.cartAddNhieuG', compact('cartMany', 'amount_cart_header'));
    }


    /** handle_amount */
    public function handle_amount(Request $request)
    {
        $itemId = $request->get('item_id');
        $quantity = $request->get('quantity');


        // Kiểm tra xem có sản phẩm trong giỏ của người dùng không
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $itemId)
            ->first();

        // Cập nhật số lượng
        $cartItem->quantity_sp = $quantity;
        $cartItem->save();


        // Tính lại tổng tiền giỏ hàng
        $totalAmount = Cart::where('user_id', Auth::id())
            ->sum(DB::raw('quantity_sp * total_price'));

        return response()->json([
            "success" => true,
            'totalAmount' => number_format($totalAmount) // Đảm bảo trả về tổng tiền đã được tính toán
        ]);
    }


    /** xóa goods client choose */
    public function handle_remove_giang(Request $request)
    {
        $goods_id = $request->get('goods_remove');

        Cart::where('user_id', Auth::id())->where('product_id', $goods_id)->delete();
    }

    /** xóa goods */
    public function handle_remove_all_giang()
    {
        Cart::where('user_id', Auth::id())->delete();
    }



    public function routeBill(Request $request)
    {
        $json = $request->input('arrItems', '[]');
        session(['cart_many_selected' => $json]);

        return response()->json([
            'redirect_url' => route('show.bill.cartMany')
        ]);
    }

    // Controller: show_billCartMany
    public function show_billCartMany(Request $request)
    {
        /**
         * json_decode() là hàm PHP dùng để chuyển đổi chuỗi JSON thành mảng hoặc object. 
         */
        $json = session('cart_many_selected', '[]');
        $arr = json_decode($json, true); // trả về kiểu arr kết hợp <=> không có 'true' sẽ thành mảng các object


        $productIds = [];

        foreach ($arr as $item) {
            try {
                $decryptedId = decrypt($item['product_id']);
                $productIds[] = $decryptedId;
            } catch (\Exception $e) {
                // Nếu decrypt thất bại => người dùng sửa dữ liệu => chuyển về trang chính
                return redirect()->route('website-main');
            }
        }


        $cartShow = Cart::with('products')
            ->where('user_id', Auth::id())
            ->whereIn('product_id', $productIds)
            ->get();

        return view('component.header.dathang.bill-cartMany', compact('cartShow'));
    }


    public function priceSelect(Request $request)
    {
        $tongTien = $request->input('priceClient');

        return response()->json([
            'totalItemSelect' => number_format($tongTien)
        ]);
    }

    public function zalopay(Request $request)
    {
        // Lấy cấu hình từ .env
        $config = [
            "appid" => 553,
            "key1" => "9phuAOYhan4urywHTh0ndEXiV3pKHr5Q",
            "key2" => "Iyz2habzyr7AG8SgvoBCbKwKi3UzlLi3",
            "endpoint" => "https://sandbox.zalopay.com.vn/v001/tpe/createorder"
        ];


        $temp = $request->input('arrShow');
        $arr = json_decode($temp);

        $count_arr = count($arr);

        $totalPrice = (int) $request->input('total_price_payment');

        $embeddata = [
            "merchantinfo" => "embeddata123",

            "redirecturl" => route('zalo.many.callback'),
        ];


        // Tính tổng số tiền từ các items

        $order = [
            "appid" => $config["appid"],
            "apptime" => round(microtime(true) * 1000), // milliseconds
            "apptransid" => date("ymd") . "_" . uniqid(), // mã giao dịch
            "appuser" => Auth::id(),
            "item" => json_encode($arr, JSON_UNESCAPED_UNICODE),
            "embeddata" => json_encode($embeddata, JSON_UNESCAPED_UNICODE),
            "amount" => $totalPrice,
            "description" => "ZaloPay Integration Demo",
            // Thay đổi hoặc bỏ qua bankcode để hiển thị trang chọn ngân hàng
            // "bankcode" => "zalopayapp"
        ];


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



        foreach ($arr as $item) {
            Cart_buyed::create([
                'cart_id' => $request->input('cart_id_payment'),
                'user_id' => Auth::id(),
                'product_id' => $item->product_id,
                'quantity_sp' => $item->quantity_sp,
                'total_price' => $item->total_price,
                'image' =>  $item->image,
            ]);

            // 1. Tạo bill
            $bill = bill::create([
                'user_id' => Auth::id(),
                'cart_id' => $item->cart_id,
                'method_payment_id' => 3 // zalopay
            ]);

            // 2. Tạo bill_product
            bill_product::create([
                'bill_id' => $bill->bill_id,
                'product_id' =>  $item->product_id,
                'quantity' => $count_arr
            ]);

            /** sau khi thanh toán thành công thì xóa đi cart của client */
            Cart::where('user_id', Auth::id())->where('cart_id', $item->cart_id,)->delete();
        }

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

    public function callback_many_zalopay(Request $request)
    {
        // Xử lý kết quả thanh toán từ ZaloPay
        $result = $request->all(); // Lấy tất cả dữ liệu trả về từ ZaloPay

        // Kiểm tra xem thanh toán có thành công không
        if (isset($result['error_code']) && $result['error_code'] == 0) {
            return redirect()->route('payment.many.payment.success');
        } else {
            return redirect()->route('payment.many.payment.failed');
        }
    }

    public function payment_failed()
    {
        return view('component.header.dathang.billFailedCartMany');
    }
    public function payment_success()
    {
        return view('component.header.dathang.billSuccessCartMany');
    }


    public function MyOrder(Request $request)
    {
        $my_order = bill::with(['products'])
            ->where("user_id", Auth::id())
            ->orderByDesc('created_at')
            ->paginate(4);

        // dd($my_order);
        return view('component.header.dathang.my-order', compact('my_order'));
    }
}