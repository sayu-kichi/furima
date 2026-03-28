<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メール認証の確認 | COACHTECH</title>
    <!-- 共通スタイルと認証用スタイルを読み込み -->
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
</head>
<body class="auth-page">
    <main class="auth-main">
        <div class="auth-content" style="text-align: center; max-width: 800px; padding-top: 100px;">
            <!-- 画像の指示通りのテキスト -->
            <p style="font-size: 1.2rem; font-weight: bold; line-height: 1.8; margin-bottom: 50px;">
                登録していただいたメールアドレスに認証メールを送付しました。<br>
                メール認証を完了してください。
            </p>

            <!-- 画像に基づいたグレー背景・黒枠のボタン -->
            <div style="margin-bottom: 50px;">
                <a href="/" class="btn-gray">認証はこちらから</a>
            </div>

            <!-- 再送用のリンク（ボタンではなく青いテキストリンク形式） -->
            <div>
                <form action="{{ route('verification.send') }}" method="POST">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #3498db; cursor: pointer; text-decoration: none; font-size: 1rem;">
                        認証メールを再送する
                    </button>
                </form>
            </div>

            <!-- 再送完了時のメッセージ表示 -->
            @if (session('message'))
                <div style="color: #28a745; margin-top: 20px; font-weight: bold;">
                    {{ session('message') }}
                </div>
            @endif
        </div>
    </main>
</body>
</html>