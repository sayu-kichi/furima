<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Profile;
use App\Models\Like;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    

    /**
     * 一括代入可能な属性
     * DBのusersテーブルに存在するカラムのみを指定します。
     * post_codeなどはaddressesテーブル側で管理するため、ここからは削除します。
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function profile()
        {
            return $this->hasOne(Profile::class);
        }


    /**
     * シリアル化時に非表示にする属性
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * キャストする必要のある属性
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function address()
        {
            // Addressモデルと1対1の関係であることを定義
            return $this->hasOne(\App\Models\Address::class);
        }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    
}