<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'item_name' => $this->faker->word(),
            'image_url' => 'test.png',
            'brand' => 'テストブランド',
            'description' => 'テスト説明',
            'price' => 1000,
            'condition' => '良好',
        ];
    }
}
