@extends('layouts.app')

@section('title', '購入画面')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user/purchase.css') }}">
@endsection

@section('content')
<main class="purchase-container">
    <div class="purchase-wrapper">

        <!-- 左側：詳細情報 -->
        <section class="purchase-details">
            <!-- 商品概要 -->
            <div class="item-summary">
                <div class="item-image-box">
                    <img src="{{ asset('img/' . $item->image_url) }}" alt="{{ $item->name }}">
                </div>
                <div class="item-info-box">
                    <h2 class="item-name">{{ $item->name }}</h2>
                    <p class="item-price">¥ {{ number_format($item->price) }}</p>
                </div>
            </div>

            <form action="{{ route('user.purchase.store', $item->id) }}" method="POST" id="purchase-form">
                @csrf
                
                <!-- 支払い方法 -->
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

                <!-- 配送先 -->
                <div class="selection-section border-none">
                    <div class="section-header">
                        <h3 class="section-title">配送先</h3>
                        <div class="flex-shrink-0">
                            <a href="{{ route('user.address.edit', ['item_id' => $item->id]) }}" 
                            class="text-red-500 hover:text-red-600 font-medium transition-colors text-sm">
                                変更する
                            </a>
                        </div>
                    </div>

                    <!-- 下段：住所情報 -->
                    <div class="address-display">
                        @if($profile)
                            <div class="text-sm text-gray-600 leading-relaxed">
                                <p>〒{{ $profile->post_code ?? $profile->postal_code }}</p>
                                <p>{{ $profile->address }}{{ $profile->building }}</p>
                            </div>
                        @else
                            <p class="text-sm text-gray-400">住所が登録されていません。</p>
                        @endif
                    </div>
                </div>
            </form>
        </section>

        <!-- 右側：サイドバー（決済確認） -->
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
                
                <div class="action-box">
                    {{-- フォームの外にあるボタンから送信するために form属性を指定 --}}
                    <form action="{{ route('user.purchase.store', ['item_id' => $item->id]) }}" method="POST">
                        @csrf
                    <button type="submit" form="purchase-form" class="btn-purchase">
                        購入する
                    </button>
                </div>
            </div>
        </aside>

    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('payment_method_select');
    const displayText = document.getElementById('selected-payment-text');

    if (select && displayText) {
        select.addEventListener('change', function() {
            displayText.textContent = this.value;
        });
    }
});
</script>
@endsection
