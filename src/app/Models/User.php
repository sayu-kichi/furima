<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
}