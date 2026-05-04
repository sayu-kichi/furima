@extends('layouts.app')

@section('title', 'ログイン | COACHTECH')

{{-- ヘッダーをロゴのみにするためのフラグ --}}
@section('is-auth-page', true)

@section('css')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
@endsection


@section('content')
<div class="auth-page">
    <main class="auth-main">
        <div class="auth-content">
            <h1 class="auth-title">ログイン</h1>

            <form action="{{ route('login') }}" method="POST" class="auth-form" novalidate>
                @csrf

                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password" id="password" name="password" required>
                    @error('password')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="auth-submit-btn">ログインする</button>

                <div class="auth-footer-link">
                    <a href="{{ route('register') }}">会員登録はこちら</a>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection