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

    // public function BillSuccsess() {
    //     return view('')
    // }
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

        $tongTien = 0;
        $productIds = [];

        foreach ($arr as $item) {
            $aaa = $item['price'] * $item['amount'];
            $tongTien += $aaa;
            $productIds[] = $item['product_id'];
        }


        $cartShow = Cart::with('products')
            ->where('user_id', Auth::id())
            ->whereIn('product_id', $productIds)
            ->get();

        return view('component.header.dathang.bill-cartMany', compact('cartShow', 'tongTien'));
    }


    public function priceSelect(Request $request)
    {
        $tongTien = $request->input('priceClient');

        return response()->json([
            'totalItemSelect' => number_format($tongTien)
        ]);
    }
}