<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;

class ItemListTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * 全商品を取得できる
     */
    public function test_can_get_all_items()
    {
        $this->seed(\Database\Seeders\ItemSeeder::class);
        
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * 購入済み商品は「Sold」と表示される
     */
    public function test_sold_label_is_displayed_on_purchased_items()
    {
        $item = Item::factory()->create();
        
        Order::factory()->create(['item_id' => $item->id]);

        $response = $this->get('/');

        $response->assertSee('sold-label');
    }

    /**
     * 自分が出品した商品は表示されない
     */
    public function test_my_items_are_not_displayed_in_list()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $otherUser = User::factory()->create();
        
        $myItem = Item::factory()->create([
            'user_id' => $user->id,
            'item_name' => '私の出品商品',
            'image_url' => 'test.png', 
            'price' => 1000,           
            'description' => 'test',
            'condition' => '良好',  
        ]);

        $othersItem = Item::factory()->create([
            'user_id' => $otherUser->id, 
            'item_name' => '他人の出品商品'
        ]);

        $response = $this->get('/');

        $response->assertSee('他人の出品商品');
        $response->assertDontSee('私の出品商品');
    }
}