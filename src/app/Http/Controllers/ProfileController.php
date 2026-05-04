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
        
        $tab = $request->query('tab', 'sell');

        if ($tab === 'buy') {
            $items = Item::where('buyer_id', $user->id)->get();
        } else {
            $items = Item::where('user_id', $user->id)->get();
        }

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
        'name' => 'required|string|max:255',

        'email' => 'required|string|email|max:255|unique:users',

        'password' => 'required|string|min:8|confirmed',
    ], [
        'name.required' => 'お名前を入力してください。',
        'email.required' => 'メールアドレスを入力してください。',
        'password.required' => 'パスワードを入力してください。',
        'password.min' => 'パスワードは8文字以上で入力してください。',
        'password.confirmed' => 'パスワードと一致しません。',
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
        return redirect()->route('index')->with('message', 'プロフィールを更新しました');
    }
}