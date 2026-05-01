@extends('layouts.app')

@section('title', 'プロフィール')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/user/profile.css') }}">
@endsection

@section('content')
<div class="profile-container">
    {{-- ユーザー情報セクション --}}
    <div class="profile-header">
        <div class="profile-avatar">
            @if($user->profile && $user->profile->image_url)
                <img src="{{ asset('storage/' . $user->profile->image_url) }}" alt="ユーザーアイコン">
            @else
                <div class="no-avatar"><span>No Image</span></div>
            @endif
        </div>
        <div class="profile-info">
            <h1 class="profile-name">{{ $user->name }}</h1>
            <a href="{{ route('profile.edit') }}" class="profile-edit-link">プロフィールを編集</a>
        </div>
    </div>

    {{-- タブメニュー --}}
    <div class="profile-tabs">
        <a href="/mypage?tab=sell" class="tab-item {{ $tab == 'sell' ? 'active' : '' }}">出品した商品</a>
        <a href="/mypage?tab=buy" class="tab-item {{ $tab == 'buy' ? 'active' : '' }}">購入した商品</a>
    </div>

    <div class="tab-content active">
        <div class="items-grid">
            @forelse($items as $item)
                <a href="{{ route('item.show', $item->id) }}" class="item-card">
                    <div class="item-image">
                        @if(str_starts_with($item->image_url, 'items/'))
                        <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->item_name }}">
                    @else
                        <img src="{{ asset('img/' . $item->image_url) }}" alt="{{ $item->item_name }}">
                    @endif
                    </div>
                    <p class="item-name">{{ $item->item_name }}</p>
                </a>
            @empty
                <p class="empty-message">{{ $tab == 'buy' ? '購入した商品はありません。' : '出品した商品はありません。' }}</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
