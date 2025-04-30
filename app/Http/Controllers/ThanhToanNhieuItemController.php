<?php

namespace App\Http\Controllers;

use App\Models\Cart;
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

        // $show_bill = Cart
    }


    public function cart_shows_goods(Request $request)
    {

        if (!Auth::check()) {
            return redirect()->route('wayLogin');
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


        // $total_price_final = 


        // session()->put('address_exists', '');
        return view('component.header.dathang.cartAddNhieuG', compact('cartMany'));
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
}