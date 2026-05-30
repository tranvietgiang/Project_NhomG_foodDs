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

    /** show information client search client paginate */
    public function search_client(Request $reqName)
    {
        $validated = $reqName->validate([
            'search' => 'nullable|string|max:100',
        ], [
            'search.max' => 'Từ khóa tìm kiếm không được vượt quá 100 ký tự.',
        ]);

        $keyword = trim($validated['search'] ?? '');


        $list_client = User::with('client')->where('role', 'user')
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
            })
            ->orderByDesc('created_at')
            ->paginate(1)->appends(['search' => $keyword]);

        return view('component.header.admin.client.list-client', compact('list_client'));
    }

    /**staff.search_employees */
    public function search_staff(Request $req)
    {
        $validated = $req->validate([
            'search_staff' => 'nullable|string|max:100',
        ], [
            'search_staff.max' => 'Từ khóa tìm kiếm không được vượt quá 100 ký tự.',
        ]);

        $keyword = trim($validated['search_staff'] ?? '');

        $list_employees = User::where('role', 'employees')
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            })
            ->orderByDesc('created_at')
            ->paginate(5)
            ->appends(['search_staff' => $keyword]);

        return view('component.header.admin.employees.show', compact('list_employees'));
    }




    public function showVnPayCheckout()
    {
        return view('component.header.admin.pttt.vnpay-payment');
    }



    /** khách hàng cập nhật thông tin đầy đủ git */
    public function update_client(Request $req)
    {
        $req->validate([
            'client_name' => 'required|max:50',
            'client_phone' => 'required|regex:/^[0-9]{10,11}$/',
            'client_address_detail' => 'nullable|string|max:255',
            'client_gender' => 'nullable|in:male,female',
            'client_province' => 'nullable|integer|exists:tb_provinces,province_id',
            'client_district' => 'nullable|integer|exists:tb_districts,district_id',
            'client_wards' => 'nullable|integer|exists:tb_wards,wards_id',
            'client_province_name' => 'nullable|string|max:100',
            'client_district_name' => 'nullable|string|max:100',
            'client_ward_name' => 'nullable|string|max:100',
            'client_day' => 'required|integer|min:1|max:31',
            'client_month' => 'required|integer|min:1|max:12',
            'client_year' => 'required|integer|exists:years,year_id',
        ], [
            'client_name.max' => 'Ký tự không vượt quá 50!',
            'client_phone.regex' => 'Số điện thoại phải gồm 10 hoặc 11 chữ số!',
            'client_address_detail.max' => 'Địa chỉ chi tiết không được vượt quá 255 ký tự.',
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
            $year = year::find($req->client_year);
            $provinceName = $req->input('client_province_name');
            $districtName = $req->input('client_district_name');
            $wardName = $req->input('client_ward_name');

            if (!$provinceName || !$districtName || !$wardName) {
                $province = Province::where('province_id', $req->client_province)->first();
                $district = District::where('district_id', $req->client_district)->first();
                $ward = Ward::where('wards_id', $req->client_wards)->first();

                $provinceName = $provinceName ?: optional($province)->name;
                $districtName = $districtName ?: optional($district)->name;
                $wardName = $wardName ?: optional($ward)->name;
            }

            $client->client_name = $req->client_name;
            $client->client_phone = $req->client_phone;
            $newAddress = collect([$provinceName, $districtName, $wardName])->filter()->implode(', ');

            if ($newAddress !== '') {
                $client->client_address = $newAddress;
            }

            if ($req->filled('client_address_detail')) {
                $client->client_address_detail = $req->client_address_detail;
            }


            $client->client_gender = $req->client_gender;
            $client->dat_of_birth = $req->client_day . '/0' . $req->client_month . '/' . $year->year;

            $client->save();
        }

        return redirect()->back()->with('update_client_success', 'bạn dã cập nhật thông tin thành công');
    }

    /** cập nhật avatar cho client git */
    public function client_avatar_update(Request $req)
    {
        $req->validate([
            'avatar-client' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'avatar-client.max' => 'Ảnh đại diện không được vượt quá 2MB.',
        ]);

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

    public function edit_view_staff(Request $req)
    {
        $id = $req->route('employees_id');
        $employee = User::where('id', $id)->first();

        $getRole = User::all();

        return view('component.header.admin.employees.edit-show', compact('employee', 'getRole'));
    }

    public function edit_staff(Request $req)
    {
        $id = $req->route('staff');
        $employees = User::where('id', $id)->first();
        $email = $req->input('staff_email');
        $phone = $req->input('staff_phone');
        $role = $req->input('staff_role');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', "email không hợp lệ");
        }

        $req->validate([
            "staff_name" => "required|string|max:100",
            "staff_email" => "required|email|min:5|max:255",
            "staff_phone" => "nullable|regex:/^[0-9]{10,11}$/",
        ], [
            "staff_name.max" => "Tên nhân viên quá dài",
            "staff_email.max" => "email quá dài (lớn hơn 5 or nhỏ hơn 255)",
            "staff_email.min" => "email quá ngắn email quá dài (lớn hơn 5 or nhỏ hơn 255)",
            "staff_phone.regex" => "Số điện thoại phải gồm 10 hoặc 11 chữ số.",
        ]);

        $roleEdit = $role ? "employees" : $role;
        if ($employees) {
            $employees->update([
                'name' => $req->input('staff_name'),
                'email' => $email,
                "phone" => $phone,
                "role" => $roleEdit
            ]);
        }

        $getname = User::where('id', $id)->value('name');
        return redirect()->route('employees')->with('success', 'Sửa thông tin nhân viên thành công ' . $getname);
    }

    public function remove_staff(Request $req)
    {

        $id = $req->route('employees_id');
        $getname = User::where('id', $id)->value('name');
        User::where('id', $id)->delete();

        return redirect()->route('employees')->with('success', 'Xóa thành công nhân viên ' . $getname);
    }


    public function add_view_staff()
    {
        return view('component.header.admin.employees.add-show');
    }
}
