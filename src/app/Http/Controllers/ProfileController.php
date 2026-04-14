<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\Profile;
use App\Models\Item;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 出品した商品を取得
        $sellingItems = $user->items ?? [];

        // 購入した商品を取得
        $boughtItems = $user->boughtItems ?? [];

        return view('user.profile', compact('user', 'sellingItems', 'boughtItems'));
    }

    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile;

        return view('user.edit_profile', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // バリデーション
        $request->validate([
            'name'      => 'required|string|max:255',
            'post_code' => 'required|string|max:8',
            'address'   => 'required|string|max:255',
            'building'  => 'nullable|string|max:255',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 1. ユーザー名の更新 (Userテーブル)
        $user->update(['name' => $request->name]);

        // 2. 画像処理を先に行う（$pathを確定させる）
        $path = null;
        if ($request->hasFile('image')) {
            // 古い画像があれば削除（Profileモデルのimage_pathをチェックする場合）
            if ($user->profile && $user->profile->image_path) {
                Storage::disk('public')->delete($user->profile->image_path);
            }
            
            // 新しい画像を保存
            $path = $request->file('image')->store('profiles', 'public');
        } else {
            // 新しい画像がアップロードされない場合は、既存のパスを維持する
            $path = $user->profile->image_path ?? null;
        }

        // 3. プロフィール情報の保存（updateOrCreate）
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id], // 検索条件
            [
                'post_code'  => $request->post_code,
                'address'    => $request->address,
                'building'   => $request->building,
                'image_path' => $path, 
            ]
        );

        return redirect()->route('index')->with('message', 'プロフィールを更新しました');
    }
}