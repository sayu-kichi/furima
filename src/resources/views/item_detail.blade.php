<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $item->name }} | COAHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/item_detail.css') }}">
    <!-- アイコン用のライブラリ（FontAwesomeなど）があればここで読み込み -->
</head>
<body>
    <header class="header-bg">
        <div class="header-container">
            <div class="logo">
                <a href="/"><img src="{{ asset('img/titlle.png') }}" alt="COACHTECH" class="logo-img"></a>
            </div>
            <div class="search-container">
                <input type="text" class="search-input" placeholder="なにをお探しですか？">
            </div>
            <nav class="nav-menu">
                <a href="#" class="nav-link">ログイン</a>
                <a href="#" class="nav-link">マイページ</a>
                <a href="#" class="sell-button">出品</a>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <div class="detail-container">
            <!-- 左側：商品画像 (CSSでsticky設定済み) -->
            <section class="detail-image-section">
                <div class="detail-main-image">
                    <img src="{{ asset('img/' . $item->image_url) }}" alt="{{ $item->name }}">
                </div>
            </section>

            <!-- 右側：商品情報 -->
            <section class="detail-info-section">
                <h1 class="detail-item-name">{{ $item->name }}</h1>
                <p class="detail-item-brand">ブランド名</p>
                <p class="detail-item-price"><span>¥</span>{{ number_format($item->price) }}</p>

                <div class="detail-actions">
                    <!-- お気に入りボタン -->
                    <button class="action-item" id="like-button">
                        <button class="action-item" id="like-button">
                            <span class="action-icon">
                                <svg class="heart-icon" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
                                </svg>
                            </span>
                        <span id="like-count">0</span>
                    </button>

                    <!-- コメントボタン（クリックするとコメント入力欄へスクロール） -->
                    <a href="#comment-section" class="action-item">
                        <span class="action-icon">
                            <svg class="comment-icon" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                            </svg>
                        </span>
                        <span>0</span>
                    </a>
                </div>

                <a href="#" class="purchase-button">購入手続きへ</a>

                <h2 class="detail-section-title">商品説明</h2>
                <div class="detail-description">
                    {{ $item->description }}
                </div>

                <h2 class="detail-section-title">商品の情報</h2>
                <div class="detail-info-table">
                    <div class="info-row">
                        <div class="info-label">カテゴリー</div>
                        <div class="info-value">
                            <span class="info-badge">レディース</span>
                            <span class="info-badge">アクセサリー</span>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">商品の状態</div>
                        <div class="info-value">良好</div>
                    </div>
                </div>

                <!-- コメントセクション -->
                <h2 class="detail-section-title">コメント(0)</h2>
                
                <!-- 既存コメントのループ表示（仮） -->
                {{-- @foreach($item->comments as $comment) ... @endforeach --}}

                @auth
                    <!-- ログインユーザーのみ表示 -->
                    <form class="comment-form">
                        <p class="detail-section-title" style="font-size: 1rem;">商品へのコメント</p>
                        <textarea name="comment"></textarea>
                        <button type="submit" class="comment-submit">コメントを送信する</button>
                    </form>
                @else
                    <!-- 非ログインユーザーへのメッセージ -->
                    <div class="login-message">
                        <p>コメントするにはログインが必要です。</p>
                        <a href="#" class="nav-link" style="color: blue; text-decoration: underline;">ログインはこちら</a>
                    </div>
                @endauth
            </section>
        </div>
    </main>
</body>
</html>