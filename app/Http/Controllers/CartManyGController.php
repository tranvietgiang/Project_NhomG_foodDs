<?php

namespace App\Http\Controllers;

use App\Models\Cart;
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
                'total_price' => $goods_price,
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


        return response()->json([
            'cartCount' => Cart::where('user_id', Auth::id())->count(),
        ]);
    }
}