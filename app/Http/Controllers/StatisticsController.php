<?php

namespace App\Http\Controllers;

use App\Models\bill_product;
use App\Models\Categorie;
use App\Models\Client;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

use function Laravel\Prompts\table;

class StatisticsController extends Controller
{
    //

    public function view(Request $request)
    {
        /** những sản phẩm gần hết số lượng */
        $count = Product::where('quantity_store', '<=', 100)->count();

        // $topReview = Review::select('', DB::raw('COUNT() ROUND())'));

        /** bán chạy nhất */
        $sale_count = DB::table('bill_products')
            ->selectRaw('products.product_id, products.product_name, SUM(products.product_price * bill_products.quantity) as total_sale')
            ->join('products', 'bill_products.product_id', '=', 'products.product_id')
            ->groupBy('products.product_id', 'products.product_name')
            ->havingRaw('SUM(products.product_price * bill_products.quantity) >= ?', [10000000])
            ->orderByDesc('total_sale')
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


        // Truy vấn tổng tiền theo tháng (12 tháng gần nhất)
        $monthlySales = DB::table('bill_products')
            ->selectRaw('DATE_FORMAT(bill_products.created_at, "%m/%Y") as month, SUM(products.product_price * bill_products.quantity) as total')
            ->join('products', 'bill_products.product_id', '=', 'products.product_id')
            ->groupByRaw('month')
            ->orderByRaw('MIN(bill_products.created_at)')
            ->limit(12)
            ->get();


        // Dữ liệu trả về mảng cho chart
        $labels = $monthlySales->pluck('month')->toArray();
        $totals = $monthlySales->pluck('total')->map(function ($val) {
            return (int)$val;
        })->toArray();

        $top_clients = DB::table('bills')
            ->join('bill_products', 'bills.bill_id', '=', 'bill_products.bill_id')
            ->join('products', 'bill_products.product_id', '=', 'products.product_id')
            ->join('users', 'bills.user_id', '=', 'users.id')
            ->select('users.id', 'users.name', DB::raw('SUM(products.product_price * bill_products.quantity) as total_spent'))
            ->groupBy('users.id', 'users.name')
            ->having('total_spent', '>=', 100000)
            ->orderByDesc('total_spent')
            ->count();

        // dd($top_clients);

        // // filter
        // $categoryId = $request->input('category_id'); // hoặc category_ids nếu chọn nhiều

        // $filter_products = Product::where('categories_id', $categoryId)->get();
        // // Controller
        // $categories = Categorie::all(); // hoặc paginate / limit


        $product_arrId = bill_product::pluck('product_id');
        $sale_not_buy = Product::whereNotIn('product_id', $product_arrId)->count();
        // dd($sale_not_buy);


        return view('component.header.admin.thongke.thongke', compact(
            'sale_count',
            'count',
            'potential_count',
            'review_count',
            'labels',
            'totals',
            'top_clients',
            'sale_not_buy'
        ));
    }

    public function quantitysp_store()
    {
        /** những sản phẩm gần hết số lượng */
        $OutOfStore = Product::where('quantity_store', '<=', 100)->paginate(5);
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
            ->havingRaw('SUM(products.product_price * bill_products.quantity) >= ?', [10000000])
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

    public function top_client()
    {
        $top_clients = DB::table('bills')
            ->join('bill_products', 'bills.bill_id', '=', 'bill_products.bill_id')
            ->join('products', 'bill_products.product_id', '=', 'products.product_id')
            ->join('users', 'bills.user_id', '=', 'users.id')
            ->selectRaw('users.id, users.name, users.email, users.phone, SUM(products.product_price * bill_products.quantity) as total_spent')
            ->groupBy('users.id', 'users.name', 'users.email', 'users.phone')
            ->having('total_spent', '>=', 100000)
            ->orderByDesc('total_spent')
            ->get();
        // dd(DB::table('users')->first());

        return view('component.header.admin.thongke.viewTK', [
            'top_clients' => $top_clients,
            'mode' => 'top_clients'
        ]);
    }

    public function qty(Request $request)
    {
        $qty_id = $request->input('qty_id');
        $qty_sl = $request->input('qty_sl');

        if (!$qty_id || !$qty_sl) {
            return response()->json(['error' => 'Thiếu dữ liệu'], 400);
        }

        $qty_check = Product::where('product_id', $qty_id)->first();
        if ($qty_check) {
            $qty_check->quantity_store = $qty_sl + 5;
            $qty_check->save();
        }

        $qty_data = $qty_check->quantity_store;
        return response()->json([
            'data' => $qty_data
        ]);
    }

    public function sale_not_buy()
    {
        $product_arrId = bill_product::pluck('product_id');
        $sale_not_buy = Product::whereNotIn('product_id', $product_arrId)->get();

        return view('component.header.admin.thongke.viewTK', [
            'sale_not_buy' => $sale_not_buy,
            'mode' => 'sale_not_buy'
        ]);
    }
}