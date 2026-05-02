<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\Comment;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 商品詳細ページに必要な情報が表示される
     */
    public function test_all_required_information_is_displayed_on_item_detail_page()
    {
        $user = User::factory()->create();
        $category1 = Category::create(['name' => 'ファッション']);
        $category2 = Category::create(['name' => 'メンズ']);

        $item = Item::factory()->create([
            'item_name' => 'テスト商品',
            'brand' => 'テストブランド', // ← ここを brand に修正
            'price' => 5000,
            'description' => 'これはテスト商品の説明です。',
            'condition' => '良好',
        ]);

        // カテゴリを紐付け
        $item->categories()->attach([$category1->id, $category2->id]);

        // コメントを作成
        $commentUser = User::factory()->create(['name' => 'コメントした人']);
        Comment::create([
            'item_id' => $item->id,
            'user_id' => $commentUser->id,
            'comment' => '素敵な商品ですね！',
        ]);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);

        // 基本情報の確認
        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('5,000');
        $response->assertSee('これはテスト商品の説明です。');
        $response->assertSee('良好');

        // カテゴリ（複数選択）の確認
        $response->assertSee('ファッション');
        $response->assertSee('メンズ');

        // コメント情報の確認
        $response->assertSee('コメントした人');
        $response->assertSee('素敵な商品ですね！');
        
        // 数値の確認（1件のコメントがあるはずなので）
        $response->assertSee('1'); 
    }
}
