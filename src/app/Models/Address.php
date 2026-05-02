<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    /**
     * 一括割り当て可能な属性
     */
    protected $fillable = [
        'user_id',
        'post_code',
        'address',
        'building', // ビル名・建物名を追加
    ];

    /**
     * この住所を所有するユーザーを取得
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}