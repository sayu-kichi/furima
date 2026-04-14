@extends('layouts.app')

@section('title', 'プロフィール設定')

@section('css')
    {{-- 分離したCSSファイルを読み込み --}}
    <link rel="stylesheet" href="{{ asset('css/user/edit_profile.css') }}">
@endsection

@section('content')
<div class="profile-edit-container">
    <h1 class="profile-title">プロフィール設定</h1>
    
    <pre>{{ var_dump(auth()->user()->toArray()) }}</pre>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- プロフィール画像設定 --}}
        <div class="profile-image-section">
            <div class="current-image-circle" id="image-preview-container">
                @if(auth()->user()->image_url)
                    <img src="{{ asset('storage/' . auth()->user()->image_url) }}" alt="ユーザー画像" id="preview-img">
                @endif
            </div>
            <label for="image-input" class="image-upload-label">
                画像を選択する
            </label>
            <input type="file" name="image" id="image-input" accept="image/*">
            @error('image')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- ユーザー名 --}}
        <div class="edit-form-group">
            <label for="name">ユーザー名</label>
            <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}">
            @error('name')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <!-- 郵便番号 -->
        <div class="form-group">
            <label>郵便番号</label>
            <input type="text" name="post_code" 
                value="{{ old('post_code', $user->profile->post_code ?? '') }}" 
                class="form-control">
        </div>

        <!-- 住所 -->
        <div class="form-group">
            <label>住所</label>
            <input type="text" name="address" 
                value="{{ old('address', $user->profile->address ?? '') }}" 
                class="form-control">
        </div>

        <!-- 建物名 -->
        <div class="form-group">
            <label>建物名</label>
            <input type="text" name="building" 
                value="{{ old('building', $user->profile->building ?? '') }}" 
                class="form-control">
        </div>

        <button type="submit" class="update-submit-btn">更新する</button>
    </form>
</div>
@endsection

@section('script')
<script>
    // 画像プレビューのリアルタイム表示
    document.getElementById('image-input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const container = document.getElementById('image-preview-container');
                container.innerHTML = `<img src="${event.target.result}" alt="プレビュー" id="preview-img">`;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection