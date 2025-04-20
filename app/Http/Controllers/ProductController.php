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

        $totalAmount = $cartItems->sum(function($item) {
            return $item->product_price * $item->quantity_sp;
        });
    
        // Chuyển hướng đến phương thức show_cartCa và truyền dữ liệu cartItems
        
    return view('component.belowContent.cart', compact('cartItems', 'totalAmount'));
    }

    // xóa giỏ hàng 
    public function removeCart($id){
            Cart::where('product_id', $id)->delete();
            $cartItems = Cart::select('carts.*', 'products.product_name','products.product_image' , 'products.product_price')
            ->join('products', 'carts.product_id', '=', 'products.product_id') // Đảm bảo sử dụng đúng cột khoá chính
            ->where('carts.user_id', Auth::id())
            ->get();
    
            $totalAmount = $cartItems->sum(function($item) {
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
        $totalAmount = $cartItems->sum(function($item) {
            return $item->product_price * $item->quantity_sp;
        });
    
        // Chuyển hướng đến phương thức show_cartCa và truyền dữ liệu cartItems
        
    return view('component.belowContent.cart', compact('cartItems', 'totalAmount'));
    }

  
    // hiển thị tất cả sản phẩm
    public function showallproduct(){
        $products = $products = Product::paginate(12);
        return view('component.belowContent.allproduct',compact('products'));
    }

 
}
