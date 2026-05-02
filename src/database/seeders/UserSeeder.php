<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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
        User::query()->delete();

        DB::table('users')->insert([
            ['id' => 1, 'name' => 'テストユーザー1', 'email' => 'test1@example.com', 'password' => Hash::make('password')],
            ['id' => 2, 'name' => 'テストユーザー2', 'email' => 'test2@example.com', 'password' => Hash::make('password')],
        ]);
    }
}