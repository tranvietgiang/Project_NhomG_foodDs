<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('categories')->get();
        return view('component.belowContent.content-ca', compact('products'));
    }

    public function showContent() 
    {
        \Log::info('Fetching products...');
        
        $newProducts = Product::latest()->take(4)->get();
        \Log::info('New products count: ' . $newProducts->count());
        
        $bestSellers = Product::orderBy('sold_count', 'desc')->take(4)->get();
        $specialProducts = Product::where('category_id', 1)->take(8)->get();

        return view('component.content.content', compact(
            'newProducts',
            'bestSellers', 
            'specialProducts'
        ));
    }
}