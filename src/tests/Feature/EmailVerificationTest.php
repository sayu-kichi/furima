<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 1. 会員登録後、認証メールが送信される
     */
    public function test_verification_email_is_sent_after_registration()
    {
        Notification::fake();

        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // 登録後にログイン状態になるため、ユーザーを取得
        $user = User::where('email', 'test@example.com')->first();

        // 認証メールが送信されていることを確認
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    /**
     * 2. 認証メール内のリンク（ボタン）を押下するとメール認証が完了する
     */
    public function test_email_can_be_verified()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        // 署名付きの認証URLを生成
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        // 認証URLにアクセス
        $response = $this->actingAs($user)->get($verificationUrl);

        // 3. プロフィール設定画面に遷移することを確認
        // リダイレクト先が /mypage/profile であることを想定しています
        $response->assertRedirect(route('profile.edit'));
        
        // ユーザーが認証済みになっていることを確認
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }

    /**
     * 3. 未認証状態でマイページ等にアクセスした際、認証誘導画面が表示される
     */
    public function test_unverified_user_is_redirected_to_verification_notice()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        // 未認証でマイページにアクセス
        $response = $this->actingAs($user)->get('/mypage');

        // 認証誘導画面（/email/verify）にリダイレクトされることを確認
        $response->assertRedirect('/email/verify');
    }
}
