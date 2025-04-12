<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Match_;

class ViewController extends Controller
{

    /** form show_cart và review */
    public function show_cart(Request $req, $product_id)
    {

        $cart = Product::where('product_id', $req->product_id)->orderByDesc('created_at')->get();

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
         */

        $client_review_category = Review::where('product_id', $product_id)
            ->select('review_rating', DB::raw('count(*) as total'))
            ->groupBy('review_rating')
            ->pluck('total', 'review_rating');


        $list_review = Review::with('users')
            ->where('product_id',  $req->route('product_id'))
            ->orderByDesc('created_at')->get();

        /** có 3 cách lấy id từ url là 
         * 1: $req->route('product_id') với điều kiện là phải chuyền id qua router vd: cart/{product_id}'
         * 2: $req->query('product)
         * 3: thêm parament(tham số) vào show_cart(Request $req, $product_id)
         */

        return view('component.content.cartCa', compact(['cart', 'list_review', 'review_count_rating', 'final_rating_tbc', 'client_review_category']));
    }
}