<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * プロフィール編集画面の表示
     */
    public function edit()
    {
        $user = Auth::user();
        return view('user.edit_profile', compact('user'));
    }

    /**
     * プロフィール更新処理
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'post_code' => 'required|string|max:8',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 画像アップロード処理
        if ($request->hasFile('image')) {
            // 古い画像があれば削除
            if ($user->image_url) {
                Storage::disk('public')->delete($user->image_url);
            }
            $path = $request->file('image')->store('profiles', 'public');
            $user->image_url = $path;
        }

        // データの更新
        $user->update([
            'name' => $request->name,
            'post_code' => $request->post_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        return redirect()->route('index')->with('message', 'プロフィールを更新しました');
    }

    /**
     * プロフィール画面（マイページ）の表示
     */
    public function show()
    {
        $user = Auth::user();
        
        // 出品した商品と購入した商品をダミーで定義（後にモデルから取得）
        $sellingItems = []; 
        $boughtItems = [];

        return view('user.profile', compact('user', 'sellingItems', 'boughtItems'));
    }
}