<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductTuyenController extends Controller
{
    //
    public function view_admin_product()
    {
        if (!Auth::check()) {
            return redirect()->route('wayLogin', ['page' => 'login']);
        } else {
            $user = User::where('id', Auth::id())->value('role');
            if ($user == "admin") {
                $show_product_admin = Product::with('categories')->orderByDesc('created_at')->paginate(5);
                return view('component.footer.admin.view', compact(['show_product_admin']));
            } else {
                return redirect()->route('wayLogin', ['page' => 'login']);
            }
        }
    }

    public function add_view_product()
    {
        if (!Auth::check()) {
            return redirect()->route('wayLogin', ['page' => 'login']);
        } else {
            $user = User::where('id', Auth::id())->value('role');
            if ($user == "admin") {

                $cates = Categorie::all();
                return view('component.footer.admin.add-product', compact('cates'));
            } else {
                return redirect()->route('wayLogin', ['page' => 'login']);
            }
        }
    }

    public function search_client_product(Request $request)
    {
        $name = $request->input('search');
        $show_product_admin = Product::where('product_name', 'like', "%$name%")->paginate(5)->appends(['search' => $name]);

        return view('component.footer.admin.view', compact('show_product_admin'));
    }

    public function quantityStore(Request $request)
    {
        $show_product_admin = Product::with('categories')->orderBy('quantity_store', "ASC")->paginate(5);
        return view('component.footer.admin.view', compact('show_product_admin'));
    }

    public function quantityStoreDesc(Request $request)
    {
        $show_product_admin = Product::with('categories')->orderBy('quantity_store', "Desc")->paginate(5);
        return view('component.footer.admin.view', compact('show_product_admin'));
    }

    public function ViewProductUpdate(Request $request)
    {
        $show_product_admin = Product::with('categories')->orderBy('updated_at', "desc")->paginate(5);
        return view('component.footer.admin.view', compact('show_product_admin'));
    }

    public function add_product(Request $request)
    {

        if ($request->hasFile('product-image')) {
            $image = $request->file('product-image'); // <-- Sửa chỗ này
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('component/image-product'), $imageName); // Lưu ảnh vào thư mục public/image-store

            // Tạo sản phẩm
            Product::create([
                'product_name' => $request->input('product-name') ?? null,
                'product_image' => $imageName, // <-- Chỉ lưu tên ảnh
                'categories_id' => $request->input('categories_name'),
                'product_price' => $request->input('product-price') ?? 0,
                'quantity_store' => $request->input('product-amount') ?? 0,
                'description' => $request->input('product-description') ?? null,
            ]);
        }

        return redirect()->route('admin.view.product')->with('success', 'Đã thêm sản phẩm thành công!');
    }
    public function edit_view_product(Request $request)
    {
        $idProduct = $request->get('product_id');
        $getCateAll = Categorie::all();

        $getEdit = Product::with('categories')->where('product_id', $idProduct)->first();
        return view('component.footer.admin.edit-view-product', ['getEdit' => $getEdit, 'cates' => $getCateAll]);
    }
    public function edit_product(Request $request)
    {
        $idProduct = $request->input('product_id');
        // dd($idProduct);  
        $getEdit = Product::with('categories')->where('product_id', $idProduct)->first();



        if ($getEdit) {
            $image = $request->file('product-image');
            if (!is_null($image)) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('component/image-product'), $imageName);

                $getEdit->update([
                    'product_name' => $request->input('product-name') ?? null,
                    'product_price' => $request->input('product-price') ?? null,
                    'quantity_store' => $request->input('product-amount') ?? null,
                    'categories_id' => $request->input('categories_name'),
                    'product_image' => $imageName,
                    'description' => $request->input('product-description') ?? null,
                    'updated_at' => now()
                ]);
            } else {
                $getEdit->update([
                    'product_name' => $request->input('product-name') ?? null,
                    'product_price' => $request->input('product-price') ?? null,
                    'quantity_store' => $request->input('product-amount') ?? null,
                    'categories_id' => $request->input('categories_name'),
                    'description' => $request->input('product-description') ?? null,
                    'updated_at' => now()
                ]);
            }
        }
        $show_product_admin = Product::with('categories')->orderByDesc('updated_at')->paginate(5);
        return view('component.footer.admin.view', compact('show_product_admin'))->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function remove_product(Request $request)
    {
        $idProduct = $request->get('product_id');
        Product::where('product_id', $idProduct)->delete();
        return redirect()->route('admin.view.product')->with('success', 'Xóa thành công');
    }
}
