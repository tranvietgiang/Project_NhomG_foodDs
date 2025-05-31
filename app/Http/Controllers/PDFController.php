<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;

class PDFController extends Controller
{
    public function exportPdf(Request $request)
    {
        $mode = $request->input('mode');

        // Khởi tạo MPDF với cấu hình font
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'roboto', // Viết thường
            'fontDir' => [storage_path('fonts')], // Đường dẫn font
            'fontdata' => [
                'roboto' => [ // Tên font viết thường
                    'R' => 'Roboto-Regular.ttf', // Tên file font chính xác
                ],
            ],
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
            'tempDir' => sys_get_temp_dir(),
        ]);

        // Đặt font mặc định
        $mpdf->SetDefaultFont('roboto');

        // Lấy dữ liệu với giới hạn
        switch ($mode) {
            case 'OutOfStore':
                $OutOfStore = Product::where('quantity_store', '<=', 100)->limit(30)->get();
                $html = view('component.header.admin.thongke.viewTK', [
                    'OutOfStore' => $OutOfStore,
                    'mode' => $mode,
                    'pdf' => true, // Thêm dòng này
                ])->render();
                break;

            case 'sale_products':
                $sale_products = DB::table('bill_products')
                    ->selectRaw('products.product_id, products.product_name, products.product_image, products.quantity_store, products.product_price, SUM(products.product_price) as total_sale')
                    ->join('products', 'bill_products.product_id', '=', 'products.product_id')
                    ->groupBy('products.product_id', 'products.product_name', 'products.product_image', 'products.quantity_store', 'products.product_price')
                    ->havingRaw('SUM(products.product_price * bill_products.quantity) >= ?', [10000000])
                    ->orderByDesc('total_sale')
                    ->paginate();
                $html = view('component.header.admin.thongke.viewTK',  [
                    'sale_products' => $sale_products,
                    'mode' => $mode,
                    'pdf' => true
                ])->render();
                break;

            case 'potential_customers':
                $potential_customers = Client::where('login_count', '>=', 3)->limit(30)->get();
                $html = view('component.header.admin.thongke.viewTK', compact('potential_customers', 'mode'))->render();
                break;

            case 'reviewGoods':
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
                $html = view('component.header.admin.thongke.viewTK',  [
                    'reviewGoods' => $reviewGoods,
                    'mode' => $mode,
                    'pdf' => true
                ])->render();
                break;

            case 'top_clients':
                $top_clients = DB::table('bills')
                    ->join('bill_products', 'bills.bill_id', '=', 'bill_products.bill_id')
                    ->join('products', 'bill_products.product_id', '=', 'products.product_id')
                    ->join('users', 'bills.user_id', '=', 'users.id')
                    ->selectRaw('users.id, users.name, users.email, users.phone, SUM(products.product_price * bill_products.quantity) as total_spent')
                    ->groupBy('users.id', 'users.name', 'users.email', 'users.phone')
                    ->having('total_spent', '>=', 100000)
                    ->orderByDesc('total_spent')
                    ->get();
                $html = view('component.header.admin.thongke.viewTK', [
                    'top_clients' => $top_clients,
                    'mode' => $mode,
                    'pdf' => true,
                ])->render();
                break;

            case 'sale_not_buy':
                $sale_not_buy = Product::where('total_sale', 0)->limit(30)->get();
                $html = view('component.header.admin.thongke.viewTK', compact('sale_not_buy', 'mode'))->render();
                break;

            case 'BestSeller':
                $bestsellers = DB::table('order_detail')
                    ->select('product_id', DB::raw('SUM(quantity) as total_sold'))
                    ->groupBy('product_id')
                    ->orderByDesc('total_sold')
                    ->limit(30)
                    ->get();
                $html = view('component.header.admin.thongke.viewTK', compact('bestsellers', 'mode'))->render();
                break;

            default:
                return redirect()->back()->with('error', 'Không xác định loại thống kê.');
        }

        // Tạo PDF
        $mpdf->WriteHTML($html);
        return $mpdf->Output('bao_cao_' . $mode . '.pdf', 'D');
    }
}
