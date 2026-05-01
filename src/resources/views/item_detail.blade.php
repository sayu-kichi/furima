@extends('layouts.app')

@section('title', '商品詳細 - COACHTECH')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item_detail.css') }}">
@endsection

@section('content')
<main class="main-content">
    <div class="detail-container">
        <!-- 左側：商品画像 -->
        <section class="detail-image-section">
            <div class="detail-main-image">
                @if($item->is_sold)
                    <div class="sold-label"></div>
                @endif

                @if(str_starts_with($item->image_url, 'items/'))
                    <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->item_name }}">
                @else
                    <img src="{{ asset('img/' . $item->image_url) }}" alt="{{ $item->item_name }}">
                @endif
            </div>
        </section>

        <!-- 右側：商品情報 -->
        <section class="detail-info-section">
            <h1 class="detail-item-name">{{ $item->item_name }}</h1>
            <p class="detail-item-brand">{{ $item->brand ?? 'ブランド名なし' }}</p>
            <p class="detail-item-price"><span>¥</span>{{ number_format($item->price) }}</p>

            <div class="detail-actions">
                <div class="action-item-wrapper">
                    <form action="{{ route('item.like', ['item_id' => $item->id]) }}" method="POST">
                        @csrf
                        <button class="action-item" type="submit" style="background: none; border: none; cursor: pointer; padding: 0;">
                            <span class="action-icon">
                                <svg class="heart-icon {{ $item->isLikedBy(auth()->user()) ? 'is-liked' : '' }}" 
                                    xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" 
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
                                </svg>
                            </span>
                        </button>
                    </form>
                    <span id="like-count">{{ $item->likes_count ?? 0 }}</span>
                </div>

                <div class="action-item-wrapper">
                    <a href="#comment-section" class="action-item" style="text-decoration: none; color: inherit;">
                        <span class="action-icon">
                            <svg class="comment-icon" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                            </svg>
                        </span>
                    </a>
                    <span>{{ $item->comments_count ?? count($item->comments) }}</span>
                </div>
            </div>

           @if($item->is_sold)
                <button class="purchase-button disabled" disabled>売り切れました</button>
            @else
                <a href="{{ route('user.purchase.show', ['item_id' => $item->id]) }}" class="purchase-button">購入手続きへ</a>
            @endif

            <h2 class="detail-section-title">商品説明</h2>
            <div class="detail-description">
                {{ $item->description }}
            </div>

            <h2 class="detail-section-title">商品の情報</h2>
            <div class="detail-info-table">
                <div class="info-row">
                    <div class="info-label">カテゴリー</div>
                    <div class="info-value">
                        @foreach($item->categories as $category)
                            <span class="info-badge">{{ $category->name }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">商品の状態</div>
                    <div class="info-value">{{ $item->condition ?? '良好' }}</div>
                </div>
            </div>

            <!-- コメントセクション -->
            <div id="comment-section">
                <h2 class="detail-section-title">コメント({{ count($item->comments) }})</h2>
                
                <div class="comment-list">
                    @foreach($item->comments as $comment)
                        <div class="comment-item">
                            <div class="comment-user">
                                <div class="comment-user-icon">
                                    @if($comment->user->profile && $comment->user->profile->image_url)
                                        <img src="{{ asset('storage/' . $comment->user->profile->image_url) }}" alt="user-icon">
                                    @else
                                        {{-- 画像がない場合はグレーの円を表示 --}}
                                        <div class="default-icon"></div>
                                    @endif
                                </div>
                                <span class="comment-user-name">{{ $comment->user->name }}</span>
                            </div>
                            <div class="comment-text-container">
                                {{ $comment->comment }}
                            </div>
                        </div>
                    @endforeach
                </div>

                @auth
                
                    <form action="{{ route('item.comment', ['item_id' => $item->id]) }}" method="POST" class="comment-form">
                        @csrf
                        <p class="detail-section-title" style="font-size: 1rem; margin-top: 20px;">商品へのコメント</p>
                        <textarea name="comment" required></textarea>
                        <button type="submit" class="comment-submit">コメントを送信する</button>
                    </form>
                @else
                    <div class="login-message">
                        <p>コメントするにはログインが必要です。</p>
                        <a href="{{ route('login') }}" class="nav-link" style="color: blue; text-decoration: underline;">ログインはこちら</a>
                    </div>
                @endauth
            </div>
        </section>
    </div>
</main>


@endsection
