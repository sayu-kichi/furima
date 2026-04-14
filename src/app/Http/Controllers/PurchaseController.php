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

    /**
     * 送付先住所変更画面の表示
     */
    public function edit($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        
        // Addressテーブルから現在の住所を取得
        $address = $user->address; // UserモデルにhasOne設定がある前提

        return view('purchase.address_edit', compact('item', 'address'));
    }

    /**
     * 送付先住所の更新処理
     */
    public function update(Request $request, $item_id)
    {
        $user = Auth::user();

        // バリデーション
        $validated = $request->validate([
            'post_code' => 'required',
            'address'   => 'required',
            'building'  => 'nullable',
        ]);

        // Addressテーブルを更新（または作成）
        $user->address()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        // 更新後は商品購入画面に戻る
        return redirect()->route('purchase.show', ['item_id' => $item_id])
                         ->with('message', '送付先を変更しました');
    }
    
}