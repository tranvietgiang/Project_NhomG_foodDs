<?php

namespace App\Http\Controllers;

use App\Models\bill_product;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;

class StatisticsController extends Controller
{
    //

    public function view()
    {
        /** những sản phẩm gần hết số lượng */
        $count = Product::where('quantity_store', '<=', 10)->count();

        // $topReview = Review::select('', DB::raw('COUNT() ROUND())'));

        $sale = DB::table('bill_products')
            ->selectRaw('sum(total_price)')
            ->groupBy('product_id')
            ->get();

        return view('component.header.admin.thongke.thongke', compact('count'));
    }

    public function quantitysp_store()
    {
        /** những sản phẩm gần hết số lượng */
        $OutOfStore = Product::where('quantity_store', '<=', 10)->paginate(5);
        return view('component.header.admin.thongke.viewTK', compact('OutOfStore'));
    }
}