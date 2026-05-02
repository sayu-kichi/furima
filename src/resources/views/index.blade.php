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
            
            @foreach ($items as $item)
                <div class="product-card">
                    <!-- 商品画像 -->
                    <a href="{{ route('item.show', ['item_id' => $item->id]) }}" class="product-card-link" style="text-decoration: none; color: inherit; display: block;">
                        
                        <div class="product-image-box">
                            @if($item->is_sold)
                                <div class="sold-label"></div>
                            @endif

                            @if(str_starts_with($item->image_url, 'items/'))
                                <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->item_name }}">
                            @else
                                <img src="{{ asset('img/' . $item->image_url) }}" alt="{{ $item->item_name }}">
                            @endif
                        </div>
                        <!-- 商品名と価格 -->
                        <div class="product-info">
                            <p class="product-name-label">{{ $item->item_name }}</p>
                            <p style="font-weight: bold; margin-top: 4px;">¥{{ number_format($item->price) }}</p>
                        </div>
                    </a>
                </div>
            @endforeach

            @if($items->isEmpty() && request('tab') == 'mylist')
                <p style="grid-column: 1/-1; text-align: center; color: #666; margin-top: 50px;">
                    いいねした商品はまだありません
                </p>
            @endif

        </div>
    </div>
@endsection