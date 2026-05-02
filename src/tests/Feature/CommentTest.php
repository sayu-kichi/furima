<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ログイン済みのユーザーはコメントを送信できる
     */
    public function test_authenticated_user_can_send_comment()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);
        
        $commentData = ['comment' => 'テストコメントです'];
        $response = $this->post("/item/{$item->id}/comment", $commentData);

        // DBに保存されているか
        $this->assertDatabaseHas('comments', [
            'item_id' => $item->id,
            'user_id' => $user->id,
            'comment' => 'テストコメントです',
        ]);

        // 詳細ページでコメントが表示され、数が増えているか
        $response = $this->get("/item/{$item->id}");
        $response->assertSee('テストコメントです');
        $response->assertSee('1'); // コメント合計数
    }

    /**
     * ログイン前のユーザーはコメントを送信できない
     */
    public function test_unauthenticated_user_cannot_send_comment()
    {
        $item = Item::factory()->create();

        $commentData = ['comment' => '未ログインのコメント'];
        // ログインせずにPOST
        $response = $this->post("/item/{$item->id}/comment", $commentData);

        // ログインページへリダイレクトされるか、保存されていないことを確認
        $this->assertDatabaseMissing('comments', ['comment' => '未ログインのコメント']);
    }

    /**
     * コメントが入力されていない場合、バリデーションメッセージが表示される
     */
    public function test_comment_is_required()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->post("/item/{$item->id}/comment", ['comment' => '']);

        // セッションにエラーがあるか確認
        $response->assertSessionHasErrors(['comment']);
    }

    /**
     * コメントが255文字を超える場合、バリデーションメッセージが表示される
     */
    public function test_comment_max_length_validation()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        // 256文字のコメントを作成
        $longComment = str_repeat('あ', 256);
        $response = $this->post("/item/{$item->id}/comment", ['comment' => $longComment]);

        $response->assertSessionHasErrors(['comment']);
    }
}
