<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller
{

    /** form show_cart và review */
    public function show_cart(Request $req)
    {

        $cart = Product::where('product_id', $req->product_id)->orderByDesc('created_at')->get();

        $list_review = Review::with('users')
            ->where('product_id',  $req->route('product_id'))
            ->orderByDesc('created_at')->get();

        /** có 3 cách lấy id từ url là 
         * 1: $req->route('product_id') với điều kiện là phải chuyền id qua router vd: cart/{product_id}'
         * 2: $req->query('product)
         * 3: thêm parament(tham số) vào show_cart(Request $req, $product_id)
         */

        return view('component.content.cartCa', compact(['cart', 'list_review']));
    }
}
