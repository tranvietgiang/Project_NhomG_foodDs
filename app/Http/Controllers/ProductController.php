<?php

namespace App\Http\Controllers;

use App\Models\bill_product;
use App\Models\Cart;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;

class ProductController extends Controller
{
    //

    /** kiểm tra xem client đã mua hàng chưa rồi mới cho đánh giá */
    public function review(Request $req)
    {
        $client_comment = $req->input('review_content');
        $client_rating = $req->input('client_rating');
        $product_id = $req->input('product_id');



        $user = Auth::user();

        $review = User::select('users.*')
            ->join('bills', 'users.id', '=', 'bills.user_id')
            ->join('bill_product', 'bills.bill_id', '=', 'bill_product.bill_id')
            ->where('bill_product.product_id', $product_id)
            ->where('users.id', $user->id)->exists();


        // dd($client_comment, $product_id, $client_rating, $user->id, $product_id, $review);

        if ($review) {
            $client_reviews = Review::create([
                'review_rating' => $client_rating,
                'review_comment' => $client_comment,
                'product_id' => $product_id,
                'user_id' => $user->id,
            ]);

            // dd($client_reviews);

            $client_reviews->save();
        } else {
            return redirect()->back()->with('client-not-buy', '× Vui lòng mua và trải nghiệm sản phẩm trước khi để lại đánh giá cho FOODMAP bạn nhé!');
        }


        return redirect()->back();
    }

    public function delete_review($review_id)
    {
        Review::where('user_id', Auth::id())->where('review_id', $review_id)->delete();

        return redirect()->back()->with('success', 'Đã xóa đánh giá.');
    }
}
