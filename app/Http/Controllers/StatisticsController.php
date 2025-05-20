<?php

namespace App\Http\Controllers;

use App\Models\bill_product;
use App\Models\Client;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;

use function Laravel\Prompts\table;

class StatisticsController extends Controller
{
    //

    public function view()
    {
        /** những sản phẩm gần hết số lượng */
        $count = Product::where('quantity_store', '<=', 10)->count();

        // $topReview = Review::select('', DB::raw('COUNT() ROUND())'));

        /** bán chạy nhất */
        $sale_count = DB::table('bill_products')
            ->selectRaw('products.product_id, products.product_name, SUM(products.product_price) as total_sale')
            ->join('products', 'bill_products.product_id', '=', 'products.product_id')
            ->groupBy('products.product_id', 'products.product_name')
            ->havingRaw('SUM(products.product_price) >= ?', [10000000])
            ->orderByDesc('total_sale') // 👈 sắp xếp theo tổng giá giảm dần
            ->count();

        // người hay vào website
        $potential_count = Client::where('login_count', '>=', 50)->orderByDesc('login_count')->count();

        // những sản phẩm được mua nhiều
        $review_count = Review::select(
            'reviews.product_id',
            'products.product_name',
            'products.product_image',
            'products.product_price',
            'products.quantity_store',
            DB::raw('AVG(reviews.review_rating) as average_rating')
        )
            ->join('products', 'reviews.product_id', '=', 'products.product_id')
            ->groupBy(
                'reviews.product_id',
                'products.product_name',
                'products.product_image',
                'products.product_price',
                'products.quantity_store'
            )
            ->havingRaw('count(reviews.review_id) >= 3.5')->count();

        return view('component.header.admin.thongke.thongke', compact('sale_count', 'count', 'potential_count', 'review_count'));
    }

    public function quantitysp_store()
    {
        /** những sản phẩm gần hết số lượng */
        $OutOfStore = Product::where('quantity_store', '<=', 10)->paginate(5);
        return view('component.header.admin.thongke.viewTK', [
            'OutOfStore' => $OutOfStore,
            "mode" => 'OutOfStore'
        ]);
    }
    public function Sale()
    {
        /** bán chạy nhất */
        $sale_products = DB::table('bill_products')
            ->selectRaw('products.product_id, products.product_name, products.product_image, products.quantity_store, products.product_price, SUM(products.product_price) as total_sale')
            ->join('products', 'bill_products.product_id', '=', 'products.product_id')
            ->groupBy('products.product_id', 'products.product_name', 'products.product_image', 'products.quantity_store', 'products.product_price')
            ->havingRaw('SUM(products.product_price) >= ?', [10000000])
            ->orderByDesc('total_sale')
            ->paginate();


        return view('component.header.admin.thongke.viewTK', [
            'sale_products' => $sale_products,
            "mode" => 'sale_products'
        ]);
    }

    public function potential_customers()
    {
        $potential_customers = Client::where('login_count', '>=', 50)->orderByDesc('login_count')->get();
        return view('component.header.admin.thongke.viewTK', [
            'potential_customers' => $potential_customers,
            "mode" => 'potential_customers'
        ]);
    }

    public function reviewGoods()
    {
        $reviewGoods = Review::select(
            'reviews.product_id',
            'products.product_name',
            'products.product_image',
            'products.product_price',
            'products.quantity_store',
            DB::raw('AVG(reviews.review_rating) as average_rating')
        )
            ->join('products', 'reviews.product_id', '=', 'products.product_id')
            ->groupBy(
                'reviews.product_id',
                'products.product_name',
                'products.product_image',
                'products.product_price',
                'products.quantity_store'
            )
            ->havingRaw('count(reviews.review_id) >= 3.5')
            ->get();

        return view('component.header.admin.thongke.viewTK', [
            'reviewGoods' => $reviewGoods,
            'mode' => 'reviewGoods'
        ]);
    }
}