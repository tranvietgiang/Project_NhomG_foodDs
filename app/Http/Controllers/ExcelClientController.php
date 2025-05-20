<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\CustomersExport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelClientController extends Controller
{
    //
    public function export()
    {
        return Excel::download(new CustomersExport, 'customers.xlsx');
    }
}
