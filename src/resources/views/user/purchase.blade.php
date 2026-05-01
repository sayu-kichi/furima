@extends('layouts.app')

@section('title', '購入画面')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user/purchase.css') }}">
{{-- 分離したCSSを読み込み --}}
<link rel="stylesheet" href="{{ asset('css/user/purchase_custom.css') }}">
@endsection

@section('content')
<main class="purchase-container">
    <div class="purchase-wrapper">

        <!-- 左側：詳細情報 -->
        <section class="purchase-details">
            <div class="item-summary">
                <div class="item-image-box" id="main-item-image">
                    <img src="{{ asset('img/' . $item->image_url) }}" alt="{{ $item->name }}">
                </div>
                <div class="item-info-box">
                    <h2 class="item-name">{{ $item->name }}</h2>
                    <p class="item-price">¥ {{ number_format($item->price) }}</p>
                </div>
            </div>

            <form action="{{ route('user.purchase.store', $item->id) }}" method="POST" id="purchase-form">
                @csrf
                
                <div class="selection-section">
                    <h3 class="section-title">支払い方法</h3>
                    <div class="select-wrapper">
                        <select name="payment_method" id="payment_method_select" required>
                            <option value="" disabled selected>選択してください</option>
                            <option value="コンビニ払い">コンビニ払い</option>
                            <option value="カード払い">カード払い</option>
                        </select>
                    </div>
                </div>

                <div class="selection-section border-none">
                    <div class="section-header">
                        <h3 class="section-title">配送先</h3>
                        <a href="{{ route('user.address.edit', ['item_id' => $item->id]) }}" class="text-red-500 text-sm">変更する</a>
                    </div>
                    <div class="address-display">
                        @if($profile)
                            <p>〒{{ $profile->post_code ?? $profile->postal_code }}</p>
                            <p>{{ $profile->address }}{{ $profile->building }}</p>
                        @else
                            <p class="text-sm text-gray-400">住所が登録されていません。</p>
                        @endif
                    </div>
                </div>
            </form>
        </section>

        <!-- 右側：サイドバー -->
        <aside class="purchase-sidebar">
            <div class="summary-card">
                <div class="summary-row main-row">
                    <span class="label">商品代金</span>
                    <span class="value">¥ {{ number_format($item->price) }}</span>
                </div>
                <div class="summary-row sub-row">
                    <span class="label">支払い方法</span>
                    <span class="value" id="selected-payment-text">未選択</span>
                </div>
                @if ($errors->any())
                    <div class="error-messages" style="color: #e3342f; background: #fee2e2; padding: 1rem; margin-bottom: 1rem; border-radius: 0.5rem;">
                        <ul style="margin: 0; list-style: none; padding: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="action-box">
                    <button type="submit" form="purchase-form" class="btn-purchase">購入する</button>
                </div>
            </div>
        </aside>
    </div>
</main>

{{-- 
  モーダルは layout の外（mainの外）に配置されるように 
  Bladeの末尾で判定します 
--}}
@if(session('purchase_completed') || request()->query('test') == '1')
<div id="purchase-success-modal" class="modal-overlay">
    <div class="modal-bg" onclick="window.location.href='{{ url('/') }}'"></div>
    <div class="modal-content">
        <div style="margin-bottom: 1.5rem;">
            <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                <circle cx="40" cy="40" r="40" fill="#E2FBE7"/>
                <path d="M28 40L36 48L52 32" stroke="#22C55E" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <h2 style="font-size: 1.6rem; font-weight: bold; color: #333; margin-bottom: 0.75rem;">購入が完了しました</h2>
        <p style="font-size: 0.95rem; color: #666; margin-bottom: 2.5rem; line-height: 1.6;">
            ありがとうございます！<br>
            出品者からの発送通知をお待ちください。
        </p>
        <a href="{{ url('/') }}" class="btn-close-modal">閉じる</a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageBox = document.getElementById('main-item-image');
        if (imageBox) {
            const sold = document.createElement('div');
            sold.className = 'sold-label';
            sold.innerHTML = '<span class="sold-text">SOLD</span>';
            imageBox.style.position = 'relative';
            imageBox.appendChild(sold);
        }
    });
</script>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('payment_method_select');
    const display = document.getElementById('selected-payment-text');
    if (select && display) {
        select.addEventListener('change', function() {
            display.textContent = this.value;
        });
    }
});
</script>
@endsection