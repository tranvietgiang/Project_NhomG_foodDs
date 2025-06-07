<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Client;
use App\Models\day;
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
        $keyword = $reqName->input('search');


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
        $keyword = $req->input('search_staff');

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


    public function update_client(Request $req)
    {
        // 1. Validate chỉ các trường có trong request
        $req->validate([
            'client_phone'    => 'sometimes|required|regex:/^[0-9]{10,11}$/',
            'client_province' => 'sometimes|required',
            'client_district' => 'sometimes|required',
            'client_wards'    => 'sometimes|required',
            'client_day'      => 'sometimes|required|min:1|max:31',
            'client_month'    => 'sometimes|required|min:1|max:12',
            // 'client_year'     => 'sometimes|required|',
            'client_gender'   => 'sometimes|required|in:Nam,Nữ',
        ], [
            'required'          => 'Vui lòng nhập đầy đủ thông tin.',
            'client_phone.regex' => 'Số điện thoại phải gồm 10 hoặc 11 chữ số!',
            'in'                => 'Giới tính không hợp lệ.',
            'digits'            => 'Độ dài chữ số không hợp lệ.',
        ]);

        $user = Auth::user();

        // 2. Đảm bảo luôn có record Client
        $client = Client::firstOrCreate(
            ['user_id' => $user->id],
            ['client_name' => $user->name]
        );

        // 3. Cập nhật số điện thoại + tên
        if ($req->filled('client_phone')) {
            // kiểm tra unique phone
            $exists = Client::where('client_phone', $req->client_phone)
                ->where('user_id', '!=', $user->id)
                ->exists();
            if ($exists) {
                return redirect()->back()->with(
                    'client_phone_unique',
                    'Số điện thoại này đã có người sử dụng.'
                );
            }
            $client->client_phone = $req->client_phone;
        }

        // 4. Cập nhật địa chỉ theo province/district/ward
        if ($req->filled(['client_province', 'client_district', 'client_wards'])) {
            $province = Province::where('province_id', $req->client_province)->first();
            $district = District::where('district_id', $req->client_district)->first();
            $ward = Ward::where('wards_id', $req->client_wards)->first();

            $client->client_address = $province->name . ', ' . $district->name . ', ' . $ward->name;
        }

        // 5. Cập nhật address_detail nếu có
        if ($req->filled('client_address_detail')) {
            $client->client_address_detail = $req->client_address_detail;
        }

        // 6. Cập nhật giới tính
        if ($req->filled('client_gender')) {
            $client->client_gender = $req->client_gender;
        }

        // 7. Cập nhật ngày sinh
        if ($req->filled(['client_day', 'client_month', 'client_year'])) {
            $d = (int)$req->client_day;
            $m = (int)$req->client_month;
            $y = (int)$req->client_year;

            if (!checkdate($m, $d, $y) || $y > date('Y')) {
                return redirect()->back()->with('date_int', 'Ngày sinh không hợp lệ!');
            }

            $year = Year::find($req->client_year);
            $year_old = Year::where('year', $req->input('client_year'))->first();

            // dd($d, $m, $year->year);

            if (empty($year)) {
                $year = $year_old->year;
            } else {
                $year = $year->year;
            }

            if ($d < 10 && $m < 10) {
                $client->dat_of_birth = '0' . $d . '/0' . $m . '/' . $year;
            } else {
                $client->dat_of_birth =  $d . '/' . $m . '/' . $year;
            }
        }

        // 8. Lưu và trả về
        $client->save();

        return redirect()->back()->with('update_client_success', 'Cập nhật thông tin thành công!');
    }


    /** cập nhật avatar cho client git */
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
            "staff_name" => "max:100",
            "staff_email" => "max:255",
            "staff_email" => "min:5"
        ], [
            "staff_name.max" => "Tên nhân viên quá dài",
            "staff_email.max" => "email quá dài (lớn hơn 5 or nhỏ hơn 255)",
            "staff_email.min" => "email quá ngắn email quá dài (lớn hơn 5 or nhỏ hơn 255)"
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