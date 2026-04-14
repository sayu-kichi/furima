<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    // 一括割り当てを許可するカラムを指定（マイグレーションに合わせて調整してください）
    protected $fillable = [
        'user_id',
        'zip_code',
        'address',
        // 他にテーブルにあるカラム名を追加
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}