@extends('layouts.app')

@section('title', '商品一覧 - COACHTECH')

@section('content')
    <!-- タブメニューナビゲーション -->
    <nav class="tab-nav">
        <div class="tab-container">
            <a href="/" class="tab-item {{ !request('tab') || request('tab') == 'recommend' ? 'active' : '' }}">おすすめ</a>
            <a href="/?tab=mylist" class="tab-item {{ request('tab') == 'mylist' ? 'active' : '' }}">マイリスト</a>
        </div>
    </nav>

    <!-- メインコンテンツエリア -->
    <div class="main-content">
        <div class="product-grid">
            
            {{-- 
                Controller から渡された $items をループさせます。
            --}}
            @foreach ($items as $item)
                <div class="product-card">
                    <!-- 商品画像 -->
                    <a href="{{ route('item.show', ['id' => $item->id]) }}" class="product-card-link" style="text-decoration: none; color: inherit; display: block;">
                        <div class="product-image-box">
                            @if($item->image_url)
                                <img src="{{ asset('img/' . $item->image_url) }}" alt="{{ $item->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px;">
                            @else
                                <div class="no-image-placeholder">
                                    <p>No Image</p>
                                </div>
                            @endif
                        </div>
                        <!-- 商品名と価格 -->
                        <div class="product-info">
                            <p class="product-name-label">{{ $item->name }}</p>
                            <p style="font-weight: bold; margin-top: 4px;">¥{{ number_format($item->price) }}</p>
                        </div>
                    </a>
                </div>
            @endforeach

        </div>
    </div>
@endsection