<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions; // エラー回避のため変更を推奨
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ItemStoreTest extends TestCase
{
    // 先ほど解決したDBエラーを再発させないため Transactions を使用
    use DatabaseTransactions;

    public function test_user_can_create_item()
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'ファッション']);
        Storage::fake('public'); 

        // 再利用するためにファイルを変数に代入します
        $dummyImage = UploadedFile::fake()->create('test.jpg', 100); 

        $response = $this->actingAs($user)->post('/sell', [
            'item_name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => '商品の説明文です。',
            'price' => 1000,
            'condition' => '良好',
            'image' => $dummyImage, // 変数を使用
            'categories' => [$category->id],
        ]);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('items', [
            'item_name' => 'テスト商品',
            'price' => 1000,
            'condition' => '良好',
        ]);

        // 保存されたファイル名のハッシュ値を正しく比較
        Storage::disk('public')->assertExists('items/' . $dummyImage->hashName());
    }
}