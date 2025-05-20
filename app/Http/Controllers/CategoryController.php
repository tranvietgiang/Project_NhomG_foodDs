<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Categorie::all();
        return view('component.content.categories.viewcategories', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'categories_name' => 'required|max:50|unique:categories',
        ], [
            'categories_name.required' => 'Vui lòng nhập tên loại sản phẩm',
            'categories_name.unique' => 'Tên loại sản phẩm đã tồn tại'
        ]);

        Categorie::create([
            'categories_name' => $request->categories_name
        ]);

        return redirect()->back()->with('success', 'Thêm loại sản phẩm thành công');
    }

    public function update(Request $request, $id)
    {
        $category = Categorie::findOrFail($id);

        $request->validate([
            'categories_name' => 'required|max:50|unique:categories,categories_name,' . $id . ',categories_id'
        ], [
            'categories_name.required' => 'Vui lòng nhập tên loại sản phẩm',
            'categories_name.unique' => 'Tên loại sản phẩm đã tồn tại'
        ]);

        $category->update([
            'categories_name' => $request->categories_name
        ]);

        return redirect()->back()->with('success', 'Cập nhật thành công');
    }

    public function destroy($id)
    {
        $category = Categorie::findOrFail($id);

        $check_cate = Product::where('categories_id', $id)->exists();

        if ($check_cate) {
            return redirect()->back()->with('destroy-categories-failed', 'xóa không được tại vì đã có sản phẩm');
        }

        $category->delete();
        return redirect()->back()->with('success', 'Xóa thành công');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $categories = Categorie::where('categories_name', 'like', '%' . $search . '%')
            ->latest()
            ->paginate(10);

        return view('component.content.categories.viewcategories', compact('categories'));
    }
}