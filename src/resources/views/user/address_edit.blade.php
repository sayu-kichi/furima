@extends('layouts.app')

@section('title', '住所の変更')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/user/address_edit.css') }}">
@endsection

@section('content')
<div class="address-edit-container">
    <h1 class="address-edit-title">住所の変更</h1>

    
    <form action="{{ route('user.address.update', ['address' => $address->id ?? 0, 'item_id' => $item_id]) }}" method="POST">

        
        @csrf
        @method('PUT')

        {{-- 郵便番号 --}}
        <div class="form-group">
            <label for="post_code" class="form-label">郵便番号</label>
            <input 
                type="text" 
                id="post_code" 
                name="post_code" 
                class="form-input" 
                value="{{ old('post_code', $profile->post_code) }}"
                placeholder="123-4567"
            >
            @error('post_code')
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
                value="{{ old('address', $profile->address) }}"
                placeholder="〇〇県〇〇市..."
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
                value="{{ old('building', $profile->building) }}"
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