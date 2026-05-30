<?php

namespace App\Http\Controllers;

use App\Models\bill_product;
use App\Models\Cart;
use App\Models\Cart_buyed;
use App\Models\Cartbuyed;
use App\Models\Client;
use App\Models\Product;
use App\Models\User;
use App\Mail\OrderConfirmationMail;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Expr\Match_;

class ViewController extends Controller
{

    /** form show_cart vÃƒÂ  review info detail products */
    public function show_cart(Request $req, $product_id)
    {

        /** lÃ¡ÂºÂ¥y ra sÃ¡ÂºÂ£n phÃ¡ÂºÂ©m nÃƒÂ¨ */
        $cart = Product::where('product_id', $req->product_id)->orderByDesc('created_at')->get();

        /** nÃ¡ÂºÂ¿u id product ko cÃƒÂ³ trong table products thÃƒÂ¬ quay vÃ¡Â»Â main */

        $check_cart = false;
        foreach ($cart as $i) {
            $check_cart =  Product::whereIn('product_id', $i)->exists();
        }

        // dd($check_cart);
        if (!$check_cart) {
            return redirect()->route('website-main');
        }


        /** sÃ¡Â»â€˜ lÃ†Â°Ã¡Â»Â£t Ã„â€˜ÃƒÂ¡nh giÃƒÂ¡ */
        $review_count_rating = Review::where('product_id', $product_id)->count();

        /** total rating */
        $avenger_rating = Review::where('product_id', $product_id)->avg('review_rating');

        /** tÃƒÂ­nh trung bÃƒÂ¬nh Ã„â€˜ÃƒÂ¡nh giÃƒÂ¡ 5 */
        $final_rating_tbc = round($avenger_rating, 1);

        /** phÃƒÂ¢n loÃ¡ÂºÂ¡i sÃ¡Â»â€˜ Ã„â€˜ÃƒÂ¡nh giÃƒÂ¡ theo nhÃƒÂ³m */
        /**
         * DB::raw() lÃƒÂ  gÃƒÂ¬?
         * DB::raw() dÃƒÂ¹ng Ã„â€˜Ã¡Â»Æ’ viÃ¡ÂºÂ¿t cÃƒÂ¢u SQL "thÃƒÂ´" (raw SQL) bÃƒÂªn trong Eloquent query cÃ¡Â»Â§a Laravel.
         * NÃƒÂ³ cho phÃƒÂ©p bÃ¡ÂºÂ¡n dÃƒÂ¹ng nhÃ¡Â»Â¯ng hÃƒÂ m SQL mÃƒÂ  Laravel khÃƒÂ´ng hÃ¡Â»â€” trÃ¡Â»Â£ sÃ¡ÂºÂµn hoÃ¡ÂºÂ·c khÃƒÂ´ng cÃƒÂ³ hÃƒÂ m tÃ†Â°Ã†Â¡ng Ã¡Â»Â©ng.
         * pluck: tÃ¡ÂºÂ¡o ra array vÃ¡Â»â€ºi key value
         */

        /** phÃƒÂ¢n loÃ¡ÂºÂ¡i lÃ†Â°Ã¡Â»Â£t Ã„â€˜anh giÃƒÂ¡ */
        $client_review_category = Review::where('product_id', $product_id)
            ->select('review_rating', DB::raw('count(*) as total'))
            ->groupBy('review_rating')
            ->pluck('total', 'review_rating');


        /** lÃ¡ÂºÂ¥y ra danh sÃƒÂ¡ch Ã„â€˜ÃƒÂ¡nh giÃƒÂ¡ cÃ¡Â»Â§a sÃ¡ÂºÂ£n phÃ¡ÂºÂ©m */
        $list_review = Review::with(['users.client']) // NÃ¡ÂºÂ¡p thÃƒÂªm quan hÃ¡Â»â€¡ client cÃ¡Â»Â§a user
            ->where('product_id', $req->route('product_id'))
            ->orderByDesc('created_at')
            ->get();

        /** cÃƒÂ³ 3 cÃƒÂ¡ch lÃ¡ÂºÂ¥y id tÃ¡Â»Â« url lÃƒÂ
         * 1: $req->route('product_id') vÃ¡Â»â€ºi Ã„â€˜iÃ¡Â»Âu kiÃ¡Â»â€¡n lÃƒÂ  phÃ¡ÂºÂ£i chuyÃ¡Â»Ân id qua router vd: cart/{product_id}'
         * 2: $req->query('product)
         * 3: thÃƒÂªm parament(tham sÃ¡Â»â€˜) vÃƒÂ o show_cart(Request $req, $product_id)
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


    /** show cart sÃ¡ÂºÂ£n phÃ¡ÂºÂ©m mÃƒÂ  khÃƒÂ¡ch hÃƒÂ ng Ã„â€˜ÃƒÂ£ bÃ¡ÂºÂ¥m mua ngay  */
    public function show_cart_mua_ngay(Request $req, $product_id)
    {
        $req->validate([
            'cart_quantity' => 'required|integer|min:1|max:99',
        ]);

        /** sÃ¡Â»â€˜ lÃ†Â°Ã¡Â»Â£ng mÃƒÂ  khÃƒÂ¡ch hÃƒÂ ng Ã„â€˜ÃƒÂ£ chÃ¡Â»Ân */
        $product_client_quantity = $req->input('cart_quantity');

        /** lÃ¡ÂºÂ¥y ra sÃ¡ÂºÂ£n phÃ¡ÂºÂ©m mÃƒÂ  client bÃ¡ÂºÂ¥m mua ngay dÃ¡Â»Â±a vÃƒÂ o id */
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

        try {
            Mail::to(Auth::user()->email)->send(new OrderConfirmationMail($cart));
        } catch (\Throwable $exception) {
            Log::warning('Order confirmation mail failed after direct checkout', [
                'message' => $exception->getMessage(),
                'user_id' => Auth::id(),
            ]);
        }

        return view('component.header.dathang.checkout', compact(['cart', 'product_id']));
    }


    /** hiÃ¡Â»Æ’n thÃ¡Â»â€¹ ra sÃ¡ÂºÂ£n phÃ¡ÂºÂ©m mÃƒÂ  client bÃ¡ÂºÂ¥m mua ngay */
    public function show_bill_product($cart_id)
    {
        $show_bill = User::select('clients.*', 'products.*', 'cart_buyeds.quantity_sp', DB::raw('(cart_buyeds.quantity_sp * cart_buyeds.total_price) AS TOTAL_PRICE'))
            ->join('clients', 'users.id', '=', 'clients.user_id')
            ->join('cart_buyeds', 'users.id', '=', 'cart_buyeds.user_id')
            ->join('products', 'cart_buyeds.product_id', '=', 'products.product_id')
            ->where('users.id', Auth::id())->where('cart_buyeds.cart_id', $cart_id)->limit('1')->get();

        return view('component.header.dathang.bill', compact('show_bill'))->with('order-success', 'Thanh toÃƒÂ¡n Ã„â€˜Ã†Â¡n hÃƒÂ ng thÃƒÂ nh cÃƒÂ´ng.');
    }
}
