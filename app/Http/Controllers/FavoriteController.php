<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{

    // thêm sản phẩm yêu thích
    public function addFavorite(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
        ]);

        $userId = Auth::id();
        $productId = $request->product_id;

        // Kiểm tra sản phẩm đã yêu thích chưa
        $favorite = Favorite::where('user_id', $userId)->where('product_id', $productId)->first();

        if ($favorite) {
            // Nếu đã yêu thích, xóa nó khỏi danh sách
            $favorite->delete();
            return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi danh sách yêu thích!');
        } else {
            // Nếu chưa yêu thích, thêm vào
            Favorite::create([
                'user_id' => $userId,
                'product_id' => $productId,
            ]);
            return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào yêu thích!');
        }
    }
}