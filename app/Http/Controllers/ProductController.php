<?php

namespace App\Http\Controllers;

use App\Models\bill_product;
use App\Models\Cart;
use App\Models\Client;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use App\Models\Favorite;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //

    /** kiểm tra xem client đã mua hàng chưa rồi mới cho đánh giá controller thêm comment */
    public function review(Request $req)
    {

        $product_id = $req->input('product_id');

        $client_comment = $req->input('review_content');
        $client_rating = $req->input('client_rating');




        $user = Auth::user();

        $review = User::select('users.*')
            ->join('bills', 'users.id', '=', 'bills.user_id')
            ->join('bill_products', 'bills.bill_id', '=', 'bill_products.bill_id')
            ->where('bill_products.product_id', $product_id)
            ->where('users.id', $user->id)->exists();

        if ($review) {
            /** lưu ý nếu dùng upload của là laravel form phải là post */
            if ($req->hasFile('image_attached')) {
                $image_attached = $req->file('image_attached');
                // Lấy tên file gốc
                $image_name_only = time() . '_' . $image_attached->getClientOriginalName();
                // Di chuyển file đến thư mục lưu trữ
                $image_attached->move(public_path('image-store'), $image_name_only);

                Review::create([
                    'review_rating' => $client_rating,
                    'review_comment' => $client_comment,
                    'product_id' => $product_id,
                    'user_id' => $user->id,
                    'review_image' => $image_name_only
                ]);
            } else {
                Review::create([
                    'review_rating' => $client_rating,
                    'review_comment' => $client_comment,
                    'product_id' => $product_id,
                    'user_id' => $user->id,
                ]);
            }
        } else {
            return redirect()->back()->with('client-not-buy', '× Vui lòng mua và trải nghiệm sản phẩm trước khi để lại đánh giá cho FOODMAP bạn nhé!');
        }

        return redirect()->back();
    }

    // public function getAvatar()
    // {


    //     return view('component.header.dathang.cartGiang', compact('client_Avatar'));
    // }

    /** delete comment */
    public function delete_review($review_id)
    {
        Review::where('user_id', Auth::id())->where('review_id', $review_id)->delete();

        return redirect()->back();
    }

    /** chỉnh sủa nếu client muốn sửa lại comment
     * cái review_id là lấy từ cái get mà khi client click vào cart
     * git controller edit comment
     */
    public function update_review(Request $req, $review_id)
    {
        $edit_update_review = Review::where('user_id', Auth::id())->where('review_id', $review_id)->first();

        if ($edit_update_review) {
            $edit_update_review->review_comment = $req->input('edit_comment_input');
            // $edit_update_review->created_at->now();
            $edit_update_review->save();
        }

        return redirect()->back();
    }

    /** đặt đơn hàng */

    /** ca */
    public function show_cartCa()
    {
        return view('component.belowContent.cart');
    }

    // thêm vào giỏ hàng 
    public function addtocart(Request $request)
    {

        Cart::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,

            ],
            [
                'image' => $request->input('product_image') ?? "0",
                'total_price' => $request->input('product_price'),
                'quantity_sp' => DB::raw('IFNULL(quantity_sp, 0) + ' . $request->quantity_sp),
                'updated_at' => now(),
            ]

        );

        // hiển thị sản phẩm trong  giỏ hàng
        $cartItems = Cart::select('carts.*', 'products.product_name', 'products.product_image', 'products.product_price')
            ->join('products', 'carts.product_id', '=', 'products.product_id')
            ->where('carts.user_id', Auth::id())
            ->get();

        $totalAmount = $cartItems->sum(function ($item) {
            return $item->product_price * $item->quantity_sp;
        });

        // Chuyển hướng đến phương thức show_cartCa và truyền dữ liệu cartItems

        return view('component.belowContent.cart', compact('cartItems', 'totalAmount'));
    }

    // xóa giỏ hàng 
    public function removeCart($id)
    {
        Cart::where('product_id', $id)->delete();
        $cartItems = Cart::select('carts.*', 'products.product_name', 'products.product_image', 'products.product_price')
            ->join('products', 'carts.product_id', '=', 'products.product_id') // Đảm bảo sử dụng đúng cột khoá chính
            ->where('carts.user_id', Auth::id())
            ->get();

        $totalAmount = $cartItems->sum(function ($item) {
            return $item->product_price * $item->quantity_sp;
        });

        // Chuyển hướng đến phương thức show_cartCa và truyền dữ liệu cartItems

        return view('component.belowContent.cart', compact('cartItems', 'totalAmount'));
    }

    //  cập nhật giá khi số  lượng thay đổi
    public function updateSL(Request $request, $id)
    {
        $quantity = $request->input('quantity');

        // Cập nhật số lượng sản phẩm
        Cart::where('product_id', $id)
            ->update(['quantity_sp' => $quantity]);

        // Lấy danh sách sản phẩm trong giỏ hàng
        $cartItems = Cart::select('carts.*', 'products.product_name', 'products.product_image', 'products.product_price')
            ->join('products', 'carts.product_id', '=', 'products.product_id')
            ->where('carts.user_id', Auth::id())
            ->get();

        // tổng tiền 
        $totalAmount = $cartItems->sum(function ($item) {
            return $item->product_price * $item->quantity_sp;
        });

        // Chuyển hướng đến phương thức show_cartCa và truyền dữ liệu cartItems

        return view('component.belowContent.cart', compact('cartItems', 'totalAmount'));
    }


    // hiển thị tất cả sản phẩm

    public function showallproduct()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $products = $products = Product::paginate(12);
        $userFavorites = Auth::check() ? $user->favorites()->pluck('product_id')->toArray() : [];

        foreach ($products as $product) {
            $product->isFavorited = in_array($product->product_id, $userFavorites);
        }
        return view('component.belowContent.allproduct', compact('products'));
    }



    //tìm kiếm phân trang
    public function search(Request $request)
    {
        $query = $request->input('query');

        // tìm kiếm sản phẩm theo tên 
        $products = Product::where('product_name', 'LIKE', "%{$query}%")->paginate(6)->appends(['query' => $query]);

        return view('component.belowContent.allproduct', compact('products'));
    }

    // sắp xếp giá từ cao xuông thấp 
    public function sapxepgiacaoxuongthap(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $products = Product::orderBy('product_price', 'desc')->paginate(12);
        $userFavorites = Auth::check() ? $user->favorites()->pluck('product_id')->toArray() : [];

        foreach ($products as $product) {
            $product->isFavorited = in_array($product->product_id, $userFavorites);
        }
        return view('component.belowContent.allproduct', compact('products'));
    }

    // sắp xếp giá từ thấp đến cao
    public function sapxepgiathapdencao(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $products = Product::orderBy('product_price', 'asc')->paginate(12);
        $userFavorites = Auth::check() ? $user->favorites()->pluck('product_id')->toArray() : [];

        foreach ($products as $product) {
            $product->isFavorited = in_array($product->product_id, $userFavorites);
        }
        return view('component.belowContent.allproduct', compact('products'));
    }


    public function sanphamyeuthich(Request $request)
    {
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            // Lấy danh sách sản phẩm yêu thích
            $user = Auth::user();
            $favorites = $user->favorites()->pluck('product_id')->toArray();

            // Lấy thông tin sản phẩm từ bảng products
            $products = Product::whereIn('product_id', $favorites)->paginate(12);

            $userFavorites = Auth::check() ? $user->favorites()->pluck('product_id')->toArray() : [];

            foreach ($products as $product) {
                $product->isFavorited = in_array($product->product_id, $userFavorites);
            }
            // Trả về view cùng với danh sách sản phẩm yêu thích
            return view('component.belowContent.allproduct', compact('products'));
        }

        return redirect()->route('login')->with('message', 'Vui lòng đăng nhập để xem sản phẩm yêu thích.');
    }


    /** fun this have featured whe clien only input search thì will show recommnet */
    public function header_show_render(Request $req)
    {
        $value = $req->get('valueSearch');

        $temp = Product::where('product_name', 'like', "%$value%")->limit(5)->get();
        return response()->json([
            'data' => $temp
        ]);
    }
}