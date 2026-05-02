<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Profile;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 1. 支払い方法の選択が反映されるかを確認
     */
    public function test_selected_payment_method_is_reflected_on_purchase_page()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['price' => 1000]);

        $this->actingAs($user);

        // 実際のルートに合わせてPOST（ルート名がある場合はそれに合わせるのがベストです）
        $this->post("/purchase/{$item->id}", [
            'payment_method' => 'コンビニ払い'
        ]);

        $response = $this->get(route('user.purchase.show', ['item_id' => $item->id]));
        $response->assertStatus(200);
        $response->assertSee('コンビニ払い');
    }

    /**
     * 2. 送付先住所変更画面で登録した住所が商品購入画面に反映されているか
     */
    public function test_updated_address_is_reflected_on_purchase_page()
    {
        $user = User::factory()->create();
        Profile::create([
            'user_id' => $user->id,
            'post_code' => '111-1111',
            'address' => '元の住所',
            'building' => '元のビル'
        ]);

        $item = Item::factory()->create();
        $this->actingAs($user);

        // 住所変更を実行
        $response = $this->put(route('user.address.update', ['item_id' => $item->id]), [
            'post_code' => '999-8888',
            'address' => '新しく登録した住所',
            'building' => '新しいビル'
        ]);

        // リダイレクト先で購入画面が表示されるか
        $response->assertRedirect(route('user.purchase.show', ['item_id' => $item->id]));

        // 購入画面を実際に取得して、新しい住所が表示されているか確認
        $response = $this->get(route('user.purchase.show', ['item_id' => $item->id]));
        
        $response->assertStatus(200);
        $response->assertSee('999-8888');
        $response->assertSee('新しく登録した住所');
    }

    /**
     * 3. 購入した商品に送付先住所が正しく紐づいて登録されるか
     */
    public function test_purchased_item_is_linked_with_correct_shipping_address()
    {
        $user = User::factory()->create();
        Profile::create([
            'user_id' => $user->id,
            'post_code' => '222-2222',
            'address' => '紐付けテスト住所',
            'building' => 'テストビル'
        ]);

        $item = Item::factory()->create(['price' => 2000]);
        $this->actingAs($user);

        // 購入確定処理を実行
        $this->get(route('user.purchase.success', ['item_id' => $item->id]));

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'delivery_address' => '紐付けテスト住所'
        ]);
    }

    /**
     * 4. 購入完了後のステータス変更とリスト反映
     */
    public function test_user_can_purchase_item_and_check_status_in_lists()
    {
        $user = User::factory()->create();
        Profile::create([
            'user_id' => $user->id,
            'post_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル'
        ]);

        $item = Item::factory()->create([
            'item_name' => '購入テスト商品',
            'is_sold' => false,
            'price' => 1000
        ]);

        $this->actingAs($user);

        $response = $this->get(route('user.purchase.success', ['item_id' => $item->id]));
        $response->assertRedirect(route('item.show', ['item_id' => $item->id]));

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'price'   => 1000
        ]);

        $response = $this->get('/');
        $response->assertSee('class="sold-label"', false);

        $response = $this->get('/mypage?tab=buy');
        $response->assertSee('購入テスト商品');
    }
}
