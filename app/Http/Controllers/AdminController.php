<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function checkLogin()
    {
        if (!Auth::check()) {
            return redirect()->route('wayLogin', ['page' => 'login']);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function showEmployees()
    {
        // Gọi hàm checkLogin() với `return` để xử lý redirect
        if ($redirect = $this->checkLogin()) {
            return $redirect;
        }

        // Lấy danh sách nhân viên với phân trang và sắp xếp
        $list_employees = User::where('role', 'employees')
            ->orderByDesc('created_at')
            ->paginate(10); // Sử dụng paginate() để hỗ trợ firstItem()


        return view('component.header.admin.employees.show', compact('list_employees'));
    }



    public function listClient()
    {
        // Gọi hàm checkLogin() với `return` để xử lý redirect
        if ($redirect = $this->checkLogin()) {
            return $redirect;
        }

        $list_client = User::where('role', 'user')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('component.header.admin.client.list-client', compact('list_client'));
    }

    /** show information client */
    public function search_client(Request $reqName)
    {
        $keyword = $reqName->input('search');


        /**chỉ tìm một điều kiện closure */
        // $list_client = User::where('role', 'user')
        //     ->where('name', 'like', "%{$keyword}%")
        //     ->orderByDesc('created_at')
        //     ->paginate(4);

        /**
         *  lưu ý: closure , sử dụng từ khóa 'use' dể sử dụng varible keyword bên ngoài hàm
         *  nếu dùng 2 điều kiện search thì nên dùng closure nếu chỉ dùng một name để tìm thì ko cần dùng closure
         *  vd dùng name and email => closure
         */

        $list_client = User::where('role', 'user')
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
            })
            ->orderByDesc('created_at')
            ->paginate(4);

        return view('component.header.admin.client.list-client', compact('list_client'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}