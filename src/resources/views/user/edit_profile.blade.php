@extends('layouts.app')

@section('title', 'プロフィール設定')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user/edit_profile.css') }}">
@endsection

@section('content')

<div class="profile-edit-container">
<h1 class="profile-title">プロフィール設定</h1>

<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- プロフィール画像設定 --}}
    <div class="profile-image-section">
        <div class="current-image-circle" id="image-preview-container">
            @if($user->profile && $user->profile->image_url)
                <img src="{{ asset('storage/' . $user->profile->image_url) }}" alt="ユーザー画像" id="preview-img">
            @else
                {{-- 画像がない場合のプレースホルダー --}}
                <div id="no-preview-text">No Image</div>
            @endif
        </div>
        <label for="image-input" class="image-upload-label">
            画像を選択する
        </label>
        <input type="file" name="image" id="image-input" accept="image/*" style="display: none;">
        @error('image')
            <p class="error-message">{{ $message }}</p>
        @enderror
    </div>

    {{-- ユーザー名 --}}
    <div class="edit-form-group">
        <label for="name">ユーザー名</label>
        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control">
        @error('name')
            <p class="error-message">{{ $message }}</p>
        @enderror
    </div>

    {{-- 郵便番号 --}}
    <div class="edit-form-group">
        <label for="post_code">郵便番号</label>
        <input type="text" id="post_code" name="post_code" 
            value="{{ old('post_code', $user->profile->post_code ?? '') }}" 
            class="form-control">
        @error('post_code')
            <p class="error-message">{{ $message }}</p>
        @enderror
    </div>

    {{-- 住所 --}}
    <div class="edit-form-group">
        <label for="address">住所</label>
        <input type="text" id="address" name="address" 
            value="{{ old('address', $user->profile->address ?? '') }}" 
            class="form-control">
        @error('address')
            <p class="error-message">{{ $message }}</p>
        @enderror
    </div>

    {{-- 建物名 --}}
    <div class="edit-form-group">
        <label for="building">建物名</label>
        <input type="text" id="building" name="building" 
            value="{{ old('building', $user->profile->building ?? '') }}" 
            class="form-control">
        @error('building')
            <p class="error-message">{{ $message }}</p>
        @enderror
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
        container.innerHTML = &lt;img src=&quot;${event.target.result}&quot; alt=&quot;プレビュー&quot; id=&quot;preview-img&quot;&gt;;
        };
        reader.readAsDataURL(file);
        }
        });
</script>

@endsection