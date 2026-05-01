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
     * プロフィール画面（マイページ）の表示
     */
    public function index(Request $request) // Requestを追加
    {
        $user = Auth::user();
        
        // 1. 現在のタブを取得（デフォルトは 'sell'：出品した商品）
        $tab = $request->query('tab', 'sell');

        // 2. タブに応じて表示するデータを切り替え
        if ($tab === 'buy') {
            // 購入済み商品：itemsテーブルのbuyer_idが自分のIDのもの
            $items = Item::where('buyer_id', $user->id)->get();
        } else {
            // 出品した商品：itemsテーブルのuser_idが自分のIDのもの
            $items = Item::where('user_id', $user->id)->get();
        }

        // 3. ビューに $tab と $items を渡す
        return view('user.profile', compact('user', 'items', 'tab'));
    }

    /**
     * プロフィール編集画面の表示
     */
    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile ?? new Profile();

        return view('user.edit_profile', compact('user', 'profile'));
    }


    /**
     * プロフィールの更新処理
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'      => 'required|string|max:255',
            'post_code' => 'required|string|max:8',
            'address'   => 'required|string|max:255',
            'building'  => 'nullable|string|max:255',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->update(['name' => $request->name]);

        $profileData = [
            'post_code' => $request->post_code,
            'address'   => $request->address,
            'building'  => $request->building,
        ];

        if ($request->hasFile('image')) {
            $currentProfile = $user->profile;
            if ($currentProfile && $currentProfile->image_url) {
                Storage::disk('public')->delete($currentProfile->image_url);
            }
            $path = $request->file('image')->store('profiles', 'public');
            $profileData['image_url'] = $path;
        }

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        // 更新後はマイページ（index）にリダイレクト
        return redirect()->route('mypage')->with('message', 'プロフィールを更新しました');
    }
}