<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Models\Product;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class ChatboxController extends Controller
{

    public function chat(Request $request)
    {
        // Keyword gợi ý => tên danh mục
        $mapping = [
            'khát' => 'đồ uống',
            'khát nước' => 'đồ uống',
            'ăn' => 'đồ ăn',
            'uống' => 'đồ uống',
            'mệt' => 'nước tăng lực',
            'ngọt' => 'bánh kẹo',
            'tráng miệng' => 'bánh ngọt',
            'rượu' => "rượu",
        ];


        $keyword = strtolower(trim($request->input('inputClient')));


        // Nếu không có từ khóa, trả về mặc định
        if ($keyword === '') {
            return response()->json(['data' => []]);
        }


        $mappedCategory = null;

        foreach ($mapping as $key => $mapped) {
            if (str_contains($keyword, $key)) {
                $mappedCategory = $mapped;
                break;
            }
        }

        $productsQuery = Product::query();

        if ($mappedCategory) {
            // Tìm theo tên danh mục ánh xạ
            $productsQuery->whereHas('categories', function ($query) use ($mappedCategory) {
                $query->where('categories_name', 'like', "%$mappedCategory%");
            });
        } else {
            // Tìm theo tên sản phẩm nếu không tìm thấy ánh xạ
            $productsQuery->where('product_name', 'like', "%$keyword%");
        }

        $products = $productsQuery->limit(5)->get();
        return response()->json(['data' => $products]);
    }
}
