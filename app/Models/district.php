<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class district extends Model
{
    //
    protected $table = 'tb_districts';
    protected $fillable = [
        'name'
    ];


    use HasFactory;

    // Mối quan hệ với Province
    public function province()
    {
        return $this->belongsTo(province::class, 'province_id');
    }
}
