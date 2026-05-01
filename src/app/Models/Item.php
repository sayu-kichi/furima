<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_name',
        'image_url',
        'brand',
        'description',
        'price',
        'condition',
        'is_sold',
        'sold_at',
        'buyer_id',
    ];

    public function isLikedBy($user): bool
    {
        if (!$user) {
            return false;
        }

        return \DB::table('likes')
        ->where('user_id', $user->id)
        ->where('item_id', $this->id)
        ->exists();
    }

    /**
     * 商品が複数のカテゴリを持つ場合 (多対多)
     * ItemsController で $item->load('categories') としている場合はこちらが必要です。
     */
    public function categories(): BelongsToMany
    {
       return $this->belongsToMany(Category::class, 'category_item');
    }

    /**
     * 商品に紐づくコメントを取得
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * 商品に紐づくいいねを取得
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    /**
     * 出品者（ユーザー）を取得
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}