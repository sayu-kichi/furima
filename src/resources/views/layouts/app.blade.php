<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'COACHTECH')</title>
    <!-- 全画面共通のスタイルシート -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- 認証画面など個別のCSSが必要な場合 -->

    
    <link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
    @yield('css')
</head>
<body>
    {{-- 
        ヘッダーセクション 
        ここが一番上に記述されているため、画面の最上部に表示されます。
    --}}
    <header class="header-bg">
        <div class="header-container">
            <!-- ロゴ：常に表示 -->
            <div class="logo">
                <a href="/">
                    <img src="{{ asset('img/titlle.png') }}" alt="COACHTECH" class="logo-img">
                </a>
            </div>
            
            {{-- 
                認証系画面（is-auth-pageが定義されている時）以外で
                検索バーとナビを表示する
            --}}
            @if(!View::hasSection('is-auth-page'))
                <!-- 検索バー -->
                <div class="search-container">
                    <form action="/" method="GET">
                        <input type="text" name="keyword" placeholder="なにお探しですか？" class="search-input" value="{{ request('keyword') }}">
                    </form>
                </div>

                <!-- 右側ナビゲーション -->
                <nav class="nav-menu">
                    @auth
                        <!-- ログイン中の表示 -->
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="nav-link-btn">ログアウト</button>
                        </form>
                        <a href="/mypage" class="nav-link">マイページ</a>
                    @else
                        <!-- 未ログイン時の表示 -->
                        <a href="{{ route('login') }}" class="nav-link">ログイン</a>
                        <a href="{{ route('register') }}" class="nav-link">マイページ</a>
                    @endauth
                    <a href="/sell" class="sell-button">出品</a>
                </nav>
            @endif
        </div>
    </header>

    {{-- 
        メインコンテンツエリア
        ヘッダーの下に各画面の中身（@section('content')）が流し込まれます。
    --}}
    <main class="main-content-wrapper">
        @yield('content')
    </main>

    {{-- 個別のJavaScriptが必要な場合 --}}
    @yield('script')
</body>
</html>