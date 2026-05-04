@extends('layouts.app')

@section('title', '会員登録 - COACHTECH')
@section('is-auth-page', true)

@section('css')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
@endsection

@section('content')
    <main class="auth-main">
        <div class="auth-content">
            <h1 class="auth-title">会員登録</h1>

            <form action="{{ route('register') }}" method="POST" class="auth-form">
                @csrf

                <div class="form-group">
                    <label for="name">ユーザー名</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" >
                    @error('name')
                        <div class="error-message" style="color: red;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="error-message" style="color: red;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password" id="password" name="password">
                    @error('password')
                        <div class="error-message" style="color: red;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">確認用パスワード</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" >
                </div>

                <button type="submit" class="auth-submit-btn">登録する</button>

                <div class="auth-footer-link">
                    <a href="{{ route('login') }}">ログインはこちら</a>
                </div>
            </form>
        </div>
    </main>
@endsection