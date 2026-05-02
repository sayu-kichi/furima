<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;

class LogoutTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * ログアウトができる
     */
    public function test_user_can_logout()
    {
        // 1. ユーザーを作成してログイン状態にする
        $user = User::factory()->create();
        $this->actingAs($user);

        // ログインしていることを確認
        $this->assertAuthenticatedAs($user);

        // 2. ログアウトボタン（エンドポイント）を押す
        // Laravel標準（Fortify等）ではPOSTリクエストが一般的です
        $response = $this->post('/logout');

        // 3. ログアウト処理が実行されたことを確認
        // ログアウト後は未認証状態になる
        $this->assertGuest();

        // ログアウト後のリダイレクト先を確認（トップページ / またはログイン画面を想定）
        $response->assertRedirect('/'); 
    }
}