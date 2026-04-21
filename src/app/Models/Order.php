<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'item_id',
        'price',
        'payment_method',
        'delivery_address',
        'status',
    ];

    /**
     * 購入したユーザーを取得
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 購入された商品を取得
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
