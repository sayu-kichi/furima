<?php

namespace App\Providers;

use App\Models\User;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // singleton で登録することで、Fortify標準の挙動を自作クラスで上書きします
        $this->app->singleton(
        \Laravel\Fortify\Contracts\VerifyEmailResponse::class,
        \App\Http\Responses\VerifyEmailResponse::class
    );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ユーザー作成・更新・パスワードリセットのロジックを登録
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // ログイン試行回数の制限（1分間に5回まで）
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());
            return Limit::perMinute(5)->by($throttleKey);
        });

        // --- ビュー（画面）の紐付け設定 ---

        // ログイン画面
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // 会員登録画面
        Fortify::registerView(function () {
            return view('auth.register');
        });

        // メール認証の確認画面（「認証メールを送りました」という案内画面）
        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });

        // --- ログイン・登録後の挙動カスタマイズ ---

        // ログイン時に使用するカラムを user_id または email に指定
        // 今回の要件に合わせて、リクエストから判断するように設定
        Fortify::authenticateUsing(function (Request $request) {
             $user = User::where('email', $request->email)->first();

            if ($user && \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
                return $user;
            }
        });
    }
}