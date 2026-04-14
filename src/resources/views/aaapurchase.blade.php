@extends('layouts.app')

@section('title', '商品購入画面 - COACHTECH')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item_detail.css') }}">
@endsection

@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-12">
        
        <!-- 左側：詳細エリア -->
        <div class="flex-1">
            <!-- 商品情報 -->
            <div class="flex gap-8 mb-12">
                <div class="w-40 h-40 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500 text-xs">商品画像</span>
                </div>
                <div>
                    <h1 class="text-2xl font-bold mb-4">{{ $item->name }}</h1>
                   <p class="text-xl">¥ {{ number_format($item->price) }}</p>
                </div>
            </div>

            <hr class="mb-8">

            <!-- 支払い方法 -->
            <div class="mb-12">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="font-bold">支払い方法</h2>
                </div>
                <select class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="" disabled selected>選択してください</option>
                    <option value="konbini">コンビニ払い</option>
                    <option value="card">クレジットカード</option>
                </select>
            </div>

            <hr class="mb-8">

            <!-- 配送先 -->
            <div class="mb-12">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="font-bold">配送先</h2>
                    <a href="#" class="text-blue-500 text-sm">変更する</a>
                </div>
                <div class="text-sm">
                    <p class="mb-1">〒 XXX-YYYY</p>
                    <p>ここには住所と建物名が入ります</p>
                </div>
            </div>

            <hr class="mb-8">
        </div>

        <!-- 右側：決済エリア -->
        <div class="w-full md:w-1/3">
            <div class="border border-gray-300 p-6 rounded-sm shadow-sm">
                <div class="flex justify-between mb-6">
                    <span class="text-sm">商品代金</span>
                    <span class="font-bold">¥ {{ number_format($item->price) }}</span>
                </div>
                <div class="flex justify-between mb-10">
                    <span class="text-sm">支払い方法</span>
                    <span class="text-sm">コンビニ払い</span>
                </div>
                
                <button type="button" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-3 rounded transition duration-200">
                    購入する
                </button>
            </div>
        </div>

    </div>
</div>
@endsection