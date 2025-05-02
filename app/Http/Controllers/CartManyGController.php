<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\list_heart;
use App\Models\listHeart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartManyGController extends Controller
{
    //
    public function add_cartMany(Request $req)
    {

        if (!Auth::check()) {
            return redirect()->route('wayLogin', ['page' => 'login']);
        }


        $productID = $req->route('product_id');
        $goods_price = $req->route('price_goods');

        $existingCart = Cart::where('user_id', Auth::id())->where('product_id', $productID)->first();
        $image = Product::where('product_id', $productID)->value('product_image');


        if ($existingCart) {
            $existingCart->update([
                'quantity_sp' => DB::raw('quantity_sp + 1'),
            ]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productID,
                'quantity_sp' => 1,
                'total_price' => $goods_price,
                'image' => $image,
            ]);
        }

        $cartCount =  Cart::where('user_id', Auth::id())->count();
        return response()->json([
            'cartCount' => $cartCount
        ]);
    }

    public function show_heart(Request $req)
    {
        $amount_cart_header =  Cart::where('user_id', Auth::id())->count();
        $list_heart = listHeart::orderByDesc('created_at')->get();
        return view('component.header.dathang.listHeart', compact('amount_cart_header', 'list_heart'));
    }


    public function addHeartClient(Request $req)
    {
        // Lấy dữ liệu từ body request
        $productID = $req->input('heartID');
        $priceHeart = $req->input('priceHeart');


        $getProduct = Product::where('product_id', $productID)->first(['product_image', 'product_name']);

        $heartExists = listHeart::Where('user_id', Auth::id())
            ->where('product_id', $productID)->first();


        if (!$heartExists) {
            listHeart::create([
                'heart_name' => $getProduct->product_name,
                'heart_price' => $priceHeart,
                'heart_amount' => 1,
                'product_id' => $productID,
                'user_id' => Auth::id(),
                'heart_image' => $getProduct->product_image
            ]);
        }
    }
}