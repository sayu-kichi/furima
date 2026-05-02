<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;
use App\Models\Like;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    /**
     * いいねした商品だけが表示される
     */
    public function test_only_liked_items_are_displayed_in_mylist()
    {
        $user = User::factory()->create();
        $itemLiked = Item::factory()->create(['item_name' => 'いいねした商品']);
        $itemNotLiked = Item::factory()->create(['item_name' => 'いいねしていない商品']);

        // いいねを登録
        Like::create([
            'user_id' => $user->id,
            'item_id' => $itemLiked->id,
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('いいねした商品');
        $response->assertDontSee('いいねしていない商品');
    }

    /**
     * 購入済み商品は「sold-label」が表示される
     */
    public function test_sold_label_is_displayed_on_purchased_items_in_mylist()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['item_name' => '売却済み商品']);
        
        // いいねを登録
        Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // 購入データを作成（OrderFactoryを使用）
        Order::factory()->create(['item_id' => $item->id]);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertStatus(200);
        // デザインに合わせてクラス名を確認
        $response->assertSee('sold-label');
    }

    /**
     * 未認証の場合は何も表示されない
     */
    public function test_nothing_is_displayed_in_mylist_when_not_authenticated()
    {
        Item::factory()->create(['item_name' => '適当な商品']);

        // ログインせずにマイリストにアクセス
        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        // 商品名が表示されていないことを確認
        $response->assertDontSee('適当な商品');
    }
}
