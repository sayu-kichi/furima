@extends('layouts.app')

@section('title', '住所の変更')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/user/address_edit.css') }}">
@endsection

@section('content')
<div class="address-edit-container">
    <h1 class="address-edit-title">住所の変更</h1>

    <form action="{{ route('address.update') }}" method="POST">
        @csrf
        @method('PATCH')

        {{-- 郵便番号 --}}
        <div class="form-group">
            <label for="postal_code" class="form-label">郵便番号</label>
            <input 
                type="text" 
                id="postal_code" 
                name="postal_code" 
                class="form-input" 
                value="{{ old('postal_code', $user->postal_code) }}"
                placeholder="123-4567"
            >
            @error('postal_code')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- 住所 --}}
        <div class="form-group">
            <label for="address" class="form-label">住所</label>
            <input 
                type="text" 
                id="address" 
                name="address" 
                class="form-input" 
                value="{{ old('address', $user->address) }}"
                placeholder="東京都渋谷区..."
            >
            @error('address')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- 建物名 --}}
        <div class="form-group">
            <label for="building" class="form-label">建物名</label>
            <input 
                type="text" 
                id="building" 
                name="building" 
                class="form-input" 
                value="{{ old('building', $user->building) }}"
                placeholder="マンション名・部屋番号など"
            >
            @error('building')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- 更新ボタン --}}
        <div class="submit-button-container">
            <button type="submit" class="submit-button">更新する</button>
        </div>
    </form>
</div>
@endsection