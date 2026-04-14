<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 既存のユーザーを削除
        User::query()->delete();

        // 1. ログイン確認用の固定ユーザー
        User::create([
            'name'      => 'テスト太郎',
            'email'     => 'test@example.com',
            'password'  => Hash::make('password123'),
        ]);

        // 2. その他のデモ用ユーザー
        User::create([
            'name'      => 'サンプル花子',
            'email'     => 'hanako@example.com',
            'password'  => Hash::make('password123'),
        ]);
    }
}