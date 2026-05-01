<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\User;

use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Item::query()->delete();

        // 紐付けるユーザーを一人取得（いなければ作成）
        $user = User::first() ?? User::factory()->create();

        $items = [
            [
                'user_id' => $user->id,
                'item_name' => '腕時計',
                'price' => 15000,
                
                'brand' => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'image_url' => 'Clock.jpg',
                'condition' => '良好'
            ],
            [
                'user_id' => $user->id,
                'item_name' => 'HDD',
                'price' => 5000,
                'brand' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'image_url' => 'Disk.jpg',
                'condition' => '目立った傷や汚れなし'
            ],
            [
                'user_id' => $user->id,
                'item_name' => '玉ねぎ3束',
                'price' => 300,
                'brand' => 'なし',
                'description' => '新鮮な玉ねぎ3束のセット',
                'image_url' => 'onion.jpg',
                'condition' => 'やや傷や汚れあり'
            ],
            [
                'user_id' => $user->id,
                'item_name' => '革靴',
                'price' => 4000,
                'brand' => '',
                'description' => 'クラシックなデザインの革靴',
                'image_url' => 'Shoes.jpg',
                'condition' => '状態が悪い'
            ],
            [
                'user_id' => $user->id,
                'item_name' => 'ノートPC',
                'price' => 45000,
                'brand' => '',
                'description' => '高性能なノートパソコン',
                'image_url' => 'pc.jpg',
                'condition' => '良好'
            ],
            [
                'user_id' => $user->id,
                'item_name' => 'マイク',
                'price' => 8000,
                'brand' => 'なし',
                'description' => '高音質のレコーディング用マイク',
                'image_url' => 'Mic.jpg',
                'condition' => '目立った傷や汚れなし'
            ],
            [
                'user_id' => $user->id,
                'item_name' => 'ショルダーバッグ',
                'price' => 3500,
                'brand' => '',
                'description' => 'おしゃれなショルダーバッグ',
                'image_url' => 'bag.jpg',
                'condition' => 'やや傷や汚れあり'
            ],
            [
                'user_id' => $user->id,
                'item_name' => 'タンブラー',
                'price' => 500,
                'brand' => 'なし',
                'description' => '使いやすいタンブラー',
                'image_url' => 'Tumbler.jpg',
                'condition' => '状態が悪い'
            ],
            [
                'user_id' => $user->id,
                'item_name' => 'コーヒーミル',
                'price' => 4000,
                'brand' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'image_url' => 'Coffee.jpg',
                'condition' => '良好'
            ],
            [
                'user_id' => $user->id,
                'item_name' => 'メイクセット',
                'price' => 2500,
                'brand' => '',
                'description' => '便利なメイクアップセット',
                'image_url' => 'makeup.jpg',
                'condition' => '目立った傷や汚れなし'
            ],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}