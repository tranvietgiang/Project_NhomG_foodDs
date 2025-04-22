<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Client;
use App\Models\daymonthyear;
use App\Models\district;
use App\Models\Product;
use App\Models\province;
use App\Models\User;
use App\Models\ward;
use App\Models\year;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\session\session;
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
            ->paginate(5); // Sử dụng paginate() để hỗ trợ firstItem()


        return view('component.header.admin.employees.show', compact('list_employees'));
    }



    public function listClient()
    {
        // Gọi hàm checkLogin() với `return` để xử lý redirect
        if ($redirect = $this->checkLogin()) {
            return $redirect;
        }



        // cần sửa cái phone không liên kết được
        $list_client = User::select('users.*') // chọn các cột từ bảng users
            ->join('clients', 'users.id', '=', 'clients.user_id') // join bảng clients
            ->where('users.role', 'user')
            ->orderByDesc('clients.login_count') // sắp xếp theo cột login_count trong bảng clients
            ->with('client') // load thêm quan hệ client nếu cần
            ->paginate(5);


        return view('component.header.admin.client.list-client', compact('list_client'));
    }
    public function client_detail_manager($user_id)
    {
        // Lấy thông tin chi tiết khách hàng
        // $userid = session()->put('userid', $user_id);
        $user_detail = Client::select('clients.*')
            ->join('users', 'clients.user_id', '=', 'users.id')
            ->where('clients.user_id', $user_id)
            ->first();

        // dd($user_detail);
        // Trả về view, truyền dữ liệu vào
        return view('component.header.admin.client.form-info-detail', compact('user_detail'));
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

        $list_client = User::with('client')->where('role', 'user')
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


    public function showVnPayCheckout()
    {
        return view('component.header.admin.pttt.vnpay-payment');
    }



    /** khách hàng cập nhật thông tin đầy đủ */
    public function update_client(Request $req)
    {
        $req->validate([
            'client_name' => 'required|max:50',
            'client_phone' => 'required|regex:/^[0-9]{10,11}$/'
        ], [
            'client_name.max' => 'Ký tự không vượt quá 50!',
            'client_phone.regex' => 'Số điện thoại phải gồm 10 hoặc 11 chữ số!',
        ]);

        $user = Auth::user();

        /** kiểm tra xem information trong table client created chưa?
         *  nếu chưa thì sẽ create một thông tin với user_id người đang đăng nhập
         */
        if (!optional(Auth::user()->client)->client_id) {
            Client::create([
                'user_id' => $user->id,
                'client_name' => $user->name,
            ]);
        }




        /** kiểm tra nếu sdt user đã tồn tại trong table vì nếu trùng sdt thì người giao hàng sẽ không điện mà 
         * người mình đang cần giao có đúng số điện này không.
         */
        $check_phone = $req->client_phone;
        if (Client::Where('client_phone', $check_phone)->exists()) {

            // Tìm client khác đang dùng cùng số điện thoại
            $duplicateClient = Client::where('client_phone', $check_phone)
                ->where('user_id', '!=', $user->id)
                ->first();

            // get ra client có sdt này có trùng với thằng đang login không.
            if ($duplicateClient) {
                return redirect()->back()->with(
                    'client_phone_unique',
                    'Xin lỗi quý khách, hãy kiểm tra lại số điện thoại mình dùng, vì đã có người khác sử dụng
                    có phải là sim chính chủ không, xin cảm ơn!'
                );
            }
        }

        $client = Client::where('user_id', $user->id)->first();

        if ($client) {
            // lấy giá trị các model
            $province = Province::where('province_id', $req->client_province)->first();
            $district = District::where('district_id', $req->client_district)->first();
            $ward = Ward::where('wards_id', $req->client_wards)->first();

            $year = year::find($req->client_year);  // Giả sử Year là bảng chứa thông tin năm


            $client->client_name = $req->client_name;
            $client->client_phone = $req->client_phone;
            $client->client_address = $province->name . ', ' . $district->name . ', ' . $ward->name;

            if ($req->client_address_tail !== "") {
                $client->client_address_detail = $req->client_address_detail;
            }


            $client->client_gender = $req->client_gender;
            $client->dat_of_birth = $req->client_day . '/0' . $req->client_month . '/' . $year->year;

            $client->save();
        }

        return redirect()->back()->with('update_client_success', 'bạn dã cập nhật thông tin thành công');
    }

    public function client_avatar_update(Request $req)
    {

        /** nếu mà chưa có client thì tạo new */
        if (!optional(Auth::user()->client)->client_id) {
            Client::create([
                'user_id' => Auth::id(),
                'client_name' => Auth::user()->name,
            ]);
        }

        $client = Client::where('user_id', Auth::user()->id)->first();
        /** uploads image */
        if ($req->hasFile('avatar-client')) { // Kiểm tra xem người dùng có upload file 'avatar-client' không
            $image = $req->file('avatar-client'); // Lấy file từ request
            $imageName = time() . '_' . $image->getClientOriginalName(); // Tạo tên mới cho file (thêm timestamp vào tên gốc)
            $image->move(public_path('image-store'), $imageName); // Di chuyển file vào thư mục public/image-store

            // Nếu client đã có ảnh cũ
            if (!empty($client->client_avatar)) {
                $oldImagePath = public_path('image-store/' . $client->client_avatar); // Tạo đường dẫn ảnh cũ
                if (file_exists($oldImagePath)) { // Kiểm tra xem ảnh cũ có tồn tại không
                    unlink($oldImagePath); // Nếu có thì xóa ảnh cũ đi khỏi thư mục
                }
            }

            $client->client_avatar = $imageName; // Gán tên ảnh mới vào cột 'image' của client (để lưu vào DB sau)
        }

        $client->save();

        return redirect()->back();
    }
}