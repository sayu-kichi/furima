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
                {{-- Controllerで 'profiles' フォルダに保存しているため、そのままパスを結合 --}}
                <img src="{{ asset('storage/' . $user->profile->image_url) }}" alt="ユーザーアイコン">
            @else
                <div class="no-avatar">
                    <span>No Image</span>
                </div>
            @endif
        </div>
        <div class="profile-info">
            <h1 class="profile-name">{{ $user->name }}</h1>
            <a href="{{ route('profile.edit') }}" class="profile-edit-link">プロフィールを編集</a>
        </div>
    </div>

    {{-- タブメニュー --}}
    <div class="profile-tabs">
        <button class="tab-item active" data-target="selling">出品した商品</button>
        <button class="tab-item" data-target="bought">購入した商品</button>
    </div>

    {{-- 出品した商品一覧 --}}
    <div id="selling" class="tab-content active">
        <div class="items-grid">
            @forelse($sellingItems as $item)
                <a href="{{ route('item.show', $item->id) }}" class="item-card">
                    <div class="item-image">
                        @if($item->image_url)
                            <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}">
                        @else
                            <div class="placeholder">商品画像なし</div>
                        @endif
                    </div>
                    <p class="item-name">{{ $item->name }}</p>
                </a>
            @empty
                <p class="empty-message">出品した商品はありません。</p>
            @endforelse
        </div>
    </div>

    {{-- 購入した商品一覧 --}}
    <div id="bought" class="tab-content">
        <div class="items-grid">
            @forelse($boughtItems as $item)
                <a href="{{ route('item.show', $item->id) }}" class="item-card">
                    <div class="item-image">
                        @if($item->image_url)
                            <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}">
                        @else
                            <div class="placeholder">商品画像なし</div>
                        @endif
                    </div>
                    <p class="item-name">{{ $item->name }}</p>
                </a>
            @empty
                <p class="empty-message">購入した商品はありません。</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    // タブ切り替えのロジック
    document.querySelectorAll('.tab-item').forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-target');

            // タブのactiveクラス切り替え
            document.querySelectorAll('.tab-item').forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            // コンテンツの表示切り替え
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            const targetContent = document.getElementById(targetId);
            if (targetContent) {
                targetContent.classList.add('active');
            }
        });
    });
</script>
@endsection