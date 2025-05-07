<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Product extends Model
{
    //
    use HasFactory;
    protected $primaryKey = 'product_id'; // Khai báo khóa chính mới
    public $incrementing = true;         // ID tự tăng
    protected $keyType = 'int';

    protected $fillable = [
        'product_name',
        'product_image',
        'categories_id',
        'product_price',
        'quantity_store',
        'description'
    ];


    public function categories(): belongsTo
    {
        /**
         * 1 là foreign key của products
         * 2 là primary key của categories
         */
        return $this->belongsTo(Categorie::class, 'categories_id', 'categories_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'product_id', 'product_id');
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'product_id', 'product_id');
    }

    public function cartbuyed(): HasMany
    {
        return $this->hasMany(Cart::class, 'product_id', 'product_id');
    }

    public function bills()
    {
        return $this->belongsToMany(Bill::class, 'bill_products', 'product_id', 'bill_id')
            ->withPivot('quantity') // dùng để truy cập các cột phụ như quantity
            ->withTimestamps();
    }

    public function heart()
    {
        return $this->hasMany(listHeart::class, 'product_id', 'product_id');
    }
}