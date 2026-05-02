<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 商品名で部分一致検索ができる
     */
    public function test_can_search_items_by_name_partially()
    {
        Item::factory()->create(['item_name' => 'コーヒー豆']);
        Item::factory()->create(['item_name' => '紅茶の葉']);
        Item::factory()->create(['item_name' => '水']);

        // 「コーヒー」で検索
        $response = $this->get('/?keyword=コーヒー');

        $response->assertStatus(200);
        $response->assertSee('コーヒー豆');
        $response->assertDontSee('紅茶の葉');
        $response->assertDontSee('水');
    }

    /**
     * 検索状態がマイリストでも保持されている
     */
    public function test_search_keyword_is_retained_when_switching_to_mylist()
    {
        $user = User::factory()->create();
        
        // 1. まずキーワードを入力して検索
        // 2. その後、マイリストタブへ遷移してもキーワードがURLやセッション等で引き継がれていることを確認
        // ※このテストでは「マイリストに遷移した時のURLにkeywordが含まれているか」などを検証します
        
        $response = $this->actingAs($user)->get('/?keyword=コーヒー&tab=mylist');

        $response->assertStatus(200);
        // 検索窓（input）にキーワードが入っているか確認
        $response->assertSee('value="コーヒー"', false);
    }
}
