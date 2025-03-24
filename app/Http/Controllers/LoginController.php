<?php

namespace App\Http\Controllers;

use App\Http\Middleware\checkLogin;
use App\Http\Middleware\LastActivity;
use App\Models\login;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($page)
    {
        //
        $checkWay = ['login', 'register', 'forgot'];

        if (!in_array($page, $checkWay)) {
            abort(404);
        }

        if (!view()->exists("login.$page")) {
            abort(404, "Page not found"); // Hoặc redirect, tùy ý
        }

        return view("login.$page");
    }

    /**
     * login
     */


    public function login(Request $req)
    {
        $checkData = ([
            'email' => $req->input('email'),
            'password' => $req->input('password'),
        ]);

        if (Auth::attempt($checkData)) {
            $user = Auth::user();

            if ($user->role == 'admin') {

                /** lấy name */
                session()->put('role_admin', $user->name);
                return redirect()->route('manager')->with('manage-success', 'Welcome admin to website');
            } else if ($user->role == 'employees') {

                $id_status = $user->id;
                /** check co dang online */
                User::where('id', $id_status)->update(['last_activity' => "online"]);

                session()->put('role_employees', $user->id);
                return redirect()->route('employees');
            } else {

                session()->put('role_client', $user->name);
                return redirect()->route('website-main');
            }
        }

        // Nếu đăng nhập thất bại, không có $user, nên không lưu session
        return redirect()->back()->with('login-error', 'Invalid email or password');
    }

    /**
     * laravel support
     * logout
     */
    public function logout(Request $req)
    {

        User::where('id', Auth::user()->id)->update(['last_activity' => "off"]);
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();

        return redirect()->route('wayLogin', ['page' => 'login'])->with('logout-success', "logout successfully!");
    }

    public function checkLogin()
    {

        if (!Auth::check()) {
            return redirect()->route('wayLogin', ['page' => 'login']);
        }
    }

    /**
     * show the form
     */
    public function showIndex()
    {

        // Gọi hàm checkLogin() với `return` để xử lý redirect
        if ($redirect = $this->checkLogin()) {
            return $redirect;
        }

        // layout main website
        return view('layout.index');
    }

    public function showAdmin()
    {
        // Gọi hàm checkLogin() với `return` để xử lý redirect
        if ($redirect = $this->checkLogin()) {
            return $redirect;
        }

        // layout Admin
        return view('component.header.admin.client.list-client');
    }

    public function showEmployees()
    {
        // Gọi hàm checkLogin() với `return` để xử lý redirect
        if ($redirect = $this->checkLogin()) {
            return $redirect;
        }

        // layout Employees
        return redirect()->route('list_employees');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}