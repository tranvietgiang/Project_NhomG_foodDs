<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;

class EmployessController extends Controller
{
    public function export()
    {
        // Đây là dòng quan trọng xuất file Excel
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
