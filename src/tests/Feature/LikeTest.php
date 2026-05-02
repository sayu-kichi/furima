<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * いいねアイコンを押下して登録・解除ができる
     */
    public function test_user_can_toggle_like_on_item()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['item_name' => 'いいねテスト商品']);

        // 1. ログインして詳細ページへ
        $this->actingAs($user);
        
        // 2. いいねアイコンを押下
        $this->post("/item/{$item->id}/like");

        // 3. 詳細ページで合計値が増加し、色が変化（クラス名を確認）しているか
        $response = $this->get("/item/{$item->id}");
        $response->assertSee('1'); 
        $response->assertSee('is-liked'); // ← ここを is-liked に修正！

        // 4. 再度いいねアイコンを押下して解除
        $this->post("/item/{$item->id}/like");

        // DBから削除されているか確認
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // 5. 合計値が減少しているか確認
        $response = $this->get("/item/{$item->id}");
        $response->assertSee('0');
        $response->assertDontSee('is-liked'); // ← ここも修正
    }
}
