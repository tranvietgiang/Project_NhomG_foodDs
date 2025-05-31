<?php

namespace App\Http\Controllers;

use App\Models\bill_product;
use App\Models\Cart;
use App\Models\Cart_buyed;
use App\Models\Cartbuyed;
use App\Models\Client;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Expr\Match_;
use App\Mail\OrderConfirmationMail;

class ViewController extends Controller
{

    /** form show_cart và review info detail products */
    public function show_cart(Request $req, $product_id)
    {

        /** lấy ra sản phẩm nè */
        $cart = Product::where('product_id', $req->product_id)->orderByDesc('created_at')->get();

        /** nếu id product ko có trong table products thì quay về main */

        $check_cart = false;
        foreach ($cart as $i) {
            $check_cart =  Product::whereIn('product_id', $i)->exists();
        }

        // dd($check_cart);
        if (!$check_cart) {
            return redirect()->route('website-main');
        }


        /** số lượt đánh giá */
        $review_count_rating = Review::where('product_id', $product_id)->count();

        /** total rating */
        $avenger_rating = Review::where('product_id', $product_id)->avg('review_rating');

        /** tính trung bình đánh giá 5 */
        $final_rating_tbc = round($avenger_rating, 1);

        /** phân loại số đánh giá theo nhóm */
        /**
         * DB::raw() là gì?
         * DB::raw() dùng để viết câu SQL "thô" (raw SQL) bên trong Eloquent query của Laravel.
         * Nó cho phép bạn dùng những hàm SQL mà Laravel không hỗ trợ sẵn hoặc không có hàm tương ứng.
         * pluck: tạo ra array với key value
         */

        /** phân loại lượt đanh giá */
        $client_review_category = Review::where('product_id', $product_id)
            ->select('review_rating', DB::raw('count(*) as total'))
            ->groupBy('review_rating')
            ->pluck('total', 'review_rating');


        /** lấy ra danh sách đánh giá của sản phẩm */
        $list_review = Review::with(['users.client']) // Nạp thêm quan hệ client của user
            ->where('product_id', $req->route('product_id'))
            ->orderByDesc('created_at')
            ->get();

        /** có 3 cách lấy id từ url là 
         * 1: $req->route('product_id') với điều kiện là phải chuyền id qua router vd: cart/{product_id}'
         * 2: $req->query('product)
         * 3: thêm parament(tham số) vào show_cart(Request $req, $product_id)
         */


        /** get quantity client review(5 star) product */
        $quantity_item_review = Review::where('product_id', $product_id)
            ->where('review_rating', 5)
            ->count();

        /** get quantity in warehouse */
        $quantity_store = Product::where('product_id', $product_id)->value('quantity_store');


        /** get amount client buyed */
        $goods_sold = bill_product::where('product_id', $req->route('product_id'))->count();

        /** show avatar */
        // $client_Avatar = Client::where('user_id', Auth::id())->value('client_avatar');

        return view('component.header.dathang.cartGiang', compact(['cart', 'list_review', 'review_count_rating', 'final_rating_tbc', 'client_review_category', 'quantity_item_review', 'quantity_store', 'goods_sold']));
    }


    /** show cart sản phẩm mà khách hàng đã bấm mua ngay  */
    public function show_cart_mua_ngay(Request $req, $product_id)
    {

        /** số lượng mà khách hàng đã chọn */
        $product_client_quantity = $req->input('cart_quantity');

        /** lấy ra sản phẩm mà client bấm mua ngay dựa vào id */
        $product_get = Product::where('product_id', $product_id)->first();

        $cart_add = Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $product_id,
            'quantity_sp' => $product_client_quantity,
            'total_price' => $product_get->product_price,
            'image' => $product_get->product_image,
        ]);



        $cart = Cart::select('carts.*', 'products.*')
            ->join('products', 'carts.product_id', '=', 'products.product_id')
            ->where('user_id', Auth::id())
            ->where('carts.cart_id', $cart_add->cart_id)
            ->get();



        // Gửi email cho user hiện tại
        Mail::to(Auth::user()->email)->send(new OrderConfirmationMail($cart));

        return view('component.header.dathang.checkout', compact(['cart', 'product_id']));
    }


    /** hiển thị ra sản phẩm mà client bấm mua ngay */
    public function show_bill_product($cart_id)
    {
        $show_bill = User::select('clients.*', 'products.*', 'cart_buyeds.quantity_sp', DB::raw('(cart_buyeds.quantity_sp * cart_buyeds.total_price) AS TOTAL_PRICE'))
            ->join('clients', 'users.id', '=', 'clients.user_id')
            ->join('cart_buyeds', 'users.id', '=', 'cart_buyeds.user_id')
            ->join('products', 'cart_buyeds.product_id', '=', 'products.product_id')
            ->where('users.id', Auth::id())->where('cart_buyeds.cart_id', $cart_id)->limit('1')->get();

        return view('component.header.dathang.bill', compact('show_bill'))->with('order-success', 'Thanh toán đơn hàng thành công.');
    }
}