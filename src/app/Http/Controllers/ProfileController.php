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
    /**
     * プロフィール画面の表示
     */
    public function index()
    {
        $user = Auth::user();

        // 出品した商品を取得
        $sellingItems = $user->items ?? [];

        // 購入した商品を取得
        $boughtItems = $user->boughtItems ?? [];

        return view('user.profile', compact('user', 'sellingItems', 'boughtItems'));
    }

    /**
     * プロフィール編集画面の表示
     */
    public function edit()
    {
         $profile = auth()->user()->profile;
            if (!$profile) {
                    // プロフィールがない場合のデフォルト値を設定するか、新規作成画面へ飛ばすなどの処理
                }

            // 2. viewに $profile を渡す
            // compact('profile') を追加することで、Blade側で $profile が使えるようになります
            // また、画面表示に必要な $item_id なども一緒に渡します
            return view('user.address_edit', compact('profile', 'item_id'));

    }

    /**
     * プロフィールの更新処理
     */
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

        // 1. ユーザー名の更新 (usersテーブル)
        $user->update(['name' => $request->name]);

        // 2. プロフィールデータの準備
        $profileData = [
            'post_code' => $request->post_code,
            'address'   => $request->address,
            'building'  => $request->building,
        ];

        // 3. 画像処理
        if ($request->hasFile('image')) {
            // 既存のプロフィール情報を取得
            $currentProfile = $user->profile;

            // 古い画像ファイルがあればストレージから削除
            if ($currentProfile && $currentProfile->image_url) {
                Storage::disk('public')->delete($currentProfile->image_url);
            }

            // 新しい画像を保存し、パスを配列に追加
            $path = $request->file('image')->store('profiles', 'public');
            $profileData['image_url'] = $path;
        }

        // 4. プロフィール情報の保存（存在しなければ作成、あれば更新）
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        return redirect()->route('index')->with('message', 'プロフィールを更新しました');
    }
}