<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;
use App\Models\User;

class ProfileSeeder extends Seeder
{
    /**
     * データベースに対するデータ設定の実行
     */
    public function run(): void
    {
        // 既存のユーザーを取得（ユーザーが存在することが前提）
        $user = User::first();

        if ($user) {
            Profile::create([
                'user_id'   => $user->id,
                'display_name' =>'太郎',
                'post_code' => '123-4567',
                'address'   => '東京都渋谷区道玄坂1-2-3',
                'building'  => 'テックビル 5F',
            ]);
        }
    }
}