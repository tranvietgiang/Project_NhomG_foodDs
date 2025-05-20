<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    // Lấy dữ liệu muốn export
    public function collection()
    {
        return User::select(
            'name',
            'email',
            'phone',
            'role',
            'last_activity',
            'created_at',
            'updated_at'
        )->get();
    }

    // Đặt tiêu đề cho từng cột
    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Phone',
            'Role',
            'Status',
            'Created At',
            'Updated At',
        ];
    }
}
