<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    public function run()
    {
        // 既存の商品を一度削除して、重複を防ぐ
        Item::query()->delete();

        $items = [
            ['name' => '腕時計', 'price' => 15000, 'image_url' => 'Clock.jpg'],
            ['name' => 'HDD', 'price' => 5000, 'image_url' => 'Disk.jpg'],
            ['name' => '玉ねぎ3束', 'price' => 300, 'image_url' => 'onion.jpg'],
            ['name' => '革靴', 'price' => 4000, 'image_url' => 'Shoes.jpg'],
            ['name' => 'ノートPC', 'price' => 45000, 'image_url' => 'pc.jpg'],
            ['name' => 'マイク', 'price' => 8000, 'image_url' => 'Mic.jpg'],
            ['name' => 'ショルダーバッグ', 'price' => 3500, 'image_url' => 'bag.jpg'],
            ['name' => 'タンブラー', 'price' => 500, 'image_url' => 'Tumbler.jpg'],
            ['name' => 'コーヒーミル', 'price' => 4000, 'image_url' => 'Coffee.jpg'],
            ['name' => 'メイクセット', 'price' => 2500, 'image_url' => 'makeup.jpg'], 
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}