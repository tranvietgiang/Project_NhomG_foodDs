<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bill_product extends Model
{
    protected $primaryKey = 'bill_product_id'; // Khóa chính của bảng trung gian
    public $incrementing = true;                // ID tự tăng
    protected $keyType = 'int';

    protected $fillable = [
        'bill_id',
        'product_id',
        'quantity',
    ];

    // Quan hệ với bảng bills
    public function bill()
    {
        return $this->belongsTo(Bill::class, 'bill_id', 'bill_id');
    }

    // Quan hệ với bảng products
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}