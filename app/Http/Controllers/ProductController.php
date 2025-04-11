<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;

use Illuminate\Http\Request;

class ProductController extends Controller
{
   
    public function show_cartCa(){
        return view('component.belowContent.cart');
    }
}
