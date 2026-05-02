<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->truncate();

        DB::table('comments')->insert([
            ['user_id' => 2, 'item_id' => 1, 'comment' => 'こちらの商品はお値下げ可能でしょうか？', 'created_at' => now()],
            ['user_id' => 1, 'item_id' => 1, 'comment' => 'コメントありがとうございます。多少であれば可能です。', 'created_at' => now()],
        ]);

    }
}
