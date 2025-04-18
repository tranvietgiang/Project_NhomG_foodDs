<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class method_payments extends Model
{
    //
    protected $primaryKey = 'method_payment_id'; // Khai báo khóa chính mới
    public $incrementing = true;         // ID tự tăng
    protected $keyType = 'int';

    protected $fillable = [
        'method_payment_name',
        'method_payment_type',
    ];
}