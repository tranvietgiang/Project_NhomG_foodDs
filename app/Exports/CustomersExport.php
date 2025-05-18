<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Client::select('client_name', 'client_phone', 'client_address', 'client_gender', 'dat_of_birth', 'client_avatar', 'login_count', 'created_at')->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Phone',
            'Address',
            'gender',
            'dat_of_birht',
            'Avatar',
            'login_count',
            'Created At',
        ];
    }
}
