<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Profile;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 1. プロフィールページに必要な情報が表示される
     */
    public function test_profile_page_displays_required_information()
    {
        $user = User::factory()->create(['name' => 'テストユーザー']);
        Profile::create([
            'user_id' => $user->id,
            'image_url' => 'profiles/test_image.png',
            'post_code' => '123-4567',
            'address' => '東京都',
        ]);

        // 出品した商品
        Item::factory()->create([
            'user_id' => $user->id,
            'item_name' => '出品した商品名'
        ]);

        // 購入した商品
        Item::factory()->create([
            'buyer_id' => $user->id,
            'item_name' => '購入した商品名'
        ]);

        $this->actingAs($user);

        // マイページを表示（URL直接指定）
        $response = $this->get('/mypage');
        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
        $response->assertSee('test_image.png');
        $response->assertSee('出品した商品名');

        // 購入した商品タブを表示
        $response = $this->get('/mypage?tab=buy');
        $response->assertStatus(200);
        $response->assertSee('購入した商品名');
    }

    /**
     * 2. プロフィール編集画面で各項目の初期値が正しく表示されている
     */
    public function test_profile_edit_page_shows_initial_values()
    {
        $user = User::factory()->create(['name' => '編集前ユーザー']);
        Profile::create([
            'user_id' => $user->id,
            'image_url' => 'profiles/initial_image.png',
            'post_code' => '999-0000',
            'address' => '初期住所',
            'building' => '初期ビル'
        ]);

        $this->actingAs($user);

        // 教えていただいたルート名 'profile.edit' を使用
        $response = $this->get(route('profile.edit'));

        $response->assertStatus(200);
        $response->assertSee('編集前ユーザー');
        $response->assertSee('initial_image.png');
        $response->assertSee('999-0000');
        $response->assertSee('初期住所');
        $response->assertSee('初期ビル');
    }
}
