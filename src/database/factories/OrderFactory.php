<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'item_id' => Item::factory(),
            'price'   => 1000,
            'payment_method' => 'コンビニ払い',
            'delivery_address' => '東京都渋谷区道玄坂1-2-3', // ← これを追加！
            'status' => 1,
        ];
    }
}
