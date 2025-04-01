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
        'category_id',
        'product_price',
        'quantity_store'
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

    public function bills()
    {
        return $this->belongsToMany(Bill::class, 'bill_product', 'product_id', 'bill_id');
    }
}