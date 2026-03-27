<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧画面 - COACHTECH</title>
    <!-- 外部CSS (public/css/style.css) を読み込みます -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <!-- ヘッダーセクション -->
    <header class="header-bg">
        <div class="header-container">
            
            <div class="logo">
                <img src="{{ asset('img/titlle.png') }}" alt="COACHTECH" class="logo-img">
            </div>
            
            <!-- 検索バー -->
            <div class="search-container">
                <input type="text" placeholder="なにお探しですか？" class="search-input">
            </div>

            <!-- 右側ナビゲーション -->
            <nav class="nav-menu">
                <a href="#" class="nav-link">ログイン</a>
                <a href="#" class="nav-link">マイページ</a>
                <a href="#" class="sell-button">出品</a>
            </nav>
        </div>
    </header>

    <!-- タブメニューナビゲーション -->
    <nav class="tab-nav">
        <div class="tab-container">
            <a href="#" class="tab-item active">おすすめ</a>
            <a href="#" class="tab-item">マイリスト</a>
        </div>
    </nav>

    <!-- メインコンテンツエリア -->
    <main class="main-content">
        <div class="product-grid">
            
            {{-- 
                Controller から渡された $items をループさせます。
            --}}
            @foreach ($items as $item)
                <div class="product-card">
                    <!-- 商品画像 -->
                    <a href="{{ route('item.show', ['id' => $item->id]) }}" class="product-card" style="text-decoration: none; color: inherit; display: block;">
                        <div class="product-image-box">
                            @if($item->image_url)
                                <img src="{{ asset('img/' . $item->image_url) }}" alt="{{ $item->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px;">
                            @else
                                <p>No Image</p>
                            @endif
                        </div>
                        <!-- 商品名と価格 -->
                        <p class="product-name-label">{{ $item->name }}</p>
                        <p style="font-weight: bold;">¥{{ number_format($item->price) }}</p>
                    </a>
                </div>
            @endforeach

        </div>
    </main>

</body>
</html>