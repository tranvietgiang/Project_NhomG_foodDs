<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bills extends Model
{
    //
    protected $primaryKey = 'bill_id'; // Khai báo khóa chính mới
    public $incrementing = true;         // ID tự tăng
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'cart_id',
        'method_payment_id',
    ];

    // Relationship với User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relationship với Cart
    public function cart()
    {
        return $this->belongsTo(Carts::class, 'cart_id', 'cart_id');
    }

    // Relationship với Payment Method
    public function paymentMethod()
    {
        return $this->belongsTo(method_payments::class, 'method_payment_id', 'method_payment_id');
    }

    public function products()
    {
        return $this->belongsToMany(Products::class, 'bill_product', 'bill_id', 'product_id');
    }
}