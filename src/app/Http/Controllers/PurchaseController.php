<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Order;
use App\Models\Profile;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Http\Requests\AddressRequest; 

class PurchaseController extends Controller
{
    /**
     * 商品購入画面の表示
     */
    public function show($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        $profile = $user->profile; 

        return view('user.purchase', compact('item', 'user', 'profile'));
    }

    /**
     * 決済処理（Stripe Checkout）
     */
    public function store(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);
        $paymentMethod = $request->payment_method; // 'カード払い' or 'コンビニ払い'

        Stripe::setApiKey(config('services.stripe.secret'));

        // 支払い方法の設定
        $paymentTypes = ($paymentMethod === 'カード払い') ? ['card'] : ['konbini'];

       $sessionOptions=[
            'payment_method_types' => $paymentTypes,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => ['name' => $item->name],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('user.purchase.success', ['item_id' => $item->id]),
            'cancel_url' => route('user.purchase.show', ['item_id' => $item->id]),
        ];

        return redirect($session->url, 303);
    }

    

    /**
     * 送付先住所変更画面の表示
     */
    public function success(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id); 
        $user = Auth::user();

       //$address = $user->address;
        //return view('user.address_edit', compact('item', 'user', 'address'));

        // 1. ログインユーザーを取得
        $user = auth()->user();

        // 2. ユーザーに紐づくプロフィール（住所情報）を取得
        // まだプロフィールがない場合は、空のインスタンスを作成する
        $profile = \App\Models\Profile::where('user_id', $user->id)->first();

        return view('user.address_edit', [
            'item_id' => $item_id,
            'profile' => $profile,
        ]);
    }

    /**
     * 送付先住所の更新処理
     */
    public function updateAddress(Request $request, $item_id)
    {
        $user = Auth::user(); 

        // バリデーション
        $validated = $request->validate([
            'post_code' => ['required', 'string', 'max:8'], 
            'address'   => ['required', 'string', 'max:255'],
            'building'  => ['nullable', 'string', 'max:255'],
        ]);

        // リレーション経由で保存/更新
         $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        // ★ここが購入画面へのリターン処理です
        return redirect()->route('user.purchase.show', ['item_id' => $item_id])
                        ->with('message', '配送先を更新しました');


    }
}