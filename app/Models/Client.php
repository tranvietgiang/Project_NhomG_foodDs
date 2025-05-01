<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    //
    protected $primaryKey = 'client_id'; // Khai báo khóa chính mới
    public $incrementing = true;         // ID tự tăng
    protected $keyType = 'int';          // Kiểu dữ liệu là số nguyên

    protected $fillable = [
        'user_id',
        'client_name',
        'client_phone',
        'client_address',
        'client_gender',
        'client_address_detail',
        'dat_of_birth',
        'client_avatar',
        'login_count',
    ];


    /** mỗi client chỉ thuộc 1 user */
    public function user(): belongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }



    //         Nếu client_avatar không được set, gán giá trị mặc định
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($client) {
    //         if (empty($client->client_avatar)) {
    //             $client->client_avatar = 'user_default.png';
    //         }
    //     });
    // }
}