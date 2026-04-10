<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class PurchaseController extends Controller
{
    /**
     * 商品購入画面の表示
     *
     * @param int $item_id
     * @return \Illuminate\View\View
     */
    public function show($item_id)
    {
        // 1. 実際のデータベースから商品を取得
        // findOrFail を使うことで、商品が見つからない場合に自動的に404エラーを返します
        $item = Item::findOrFail($item_id);

        // 2. 現在ログイン中のユーザー情報を取得
        $user = Auth::user();

        // 3. ビューにデータを渡す
        return view('user.purchase', compact('item', 'user'));
    }

    /**
     * 購入処理の実行（例）
     *
     * @param Request $request
     * @param int $item_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $item_id)
    {
        // ここに購入確定時のロジックを記述します
        // 例: $item = Item::findOrFail($item_id);
        //     $user = Auth::user();
        //     ...決済処理など...

        return redirect()->route('item.show', $item_id)->with('message', '購入が完了しました');
    }
}