<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class ProductController extends Controller
{
   
    public function show_cartCa(){
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
                'quantity_sp' => DB::raw('IFNULL(quantity_sp, 0) + ' . $request->quantity_sp),
                'updated_at' => now(),
            ]
            
        );


        // hiển thị sản phẩm trong  giỏ hàng

        $cartItems = Cart::select('carts.*', 'products.product_name','products.product_image' , 'products.product_price')
        ->join('products', 'carts.product_id', '=', 'products.product_id') // Đảm bảo sử dụng đúng cột khoá chính
        ->where('carts.user_id', Auth::id())
        ->get();


        // dd($cartItems);
        return view('component.belowContent.cart',compact('cartItems'));
    }

 
}
