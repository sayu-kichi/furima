<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ItemStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_item()
    {
        $user = User::factory()->create();
        $category = Category::create(['content' => 'ファッション']);
        Storage::fake('public'); 

        $response = $this->actingAs($user)->post('/sell', [
            'item_name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => '商品の説明文です。',
            'price' => 1000,
            'condition' => '良好',
            'image' => UploadedFile::fake()->image('test.jpg'),
            'categories' => [$category->id],
        ]);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('items', [
            'item_name' => 'テスト商品',
            'price' => 1000,
            'condition' => '良好',
        ]);

        Storage::disk('public')->assertExists('items/' . UploadedFile::fake()->image('test.jpg')->hashName());
    }
}