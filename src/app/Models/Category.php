<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // テーブル名が categories であることを明示
    protected $table = 'categories';

    // 複数代入を許可するカラム
    protected $fillable = ['name'];

    /**
     * 商品とのリレーション（1対多）
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}