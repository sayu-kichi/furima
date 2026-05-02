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
    public function show($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        $profile = $user->profile; 

        return view('user.purchase', compact('item', 'user', 'profile'));
    }

    public function store(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);
        $paymentMethod = (string)$request->input('payment_method');
        
        $stripeSecret = config('services.stripe.secret');
        if (empty($stripeSecret)) {
            return back()->withErrors(['error' => 'StripeのAPIキーが設定されていません。']);
        }
        Stripe::setApiKey((string)$stripeSecret);

        $paymentTypes = ($paymentMethod === 'カード払い') ? ['card'] : ['konbini'];

        $sessionOptions = [
            'payment_method_types' => $paymentTypes,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => (string)$item->item_name,
                    ],
                    'unit_amount' => (int)$item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => (string)route('user.purchase.success', ['item_id' => $item->id]),
            'cancel_url' => (string)route('user.purchase.show', ['item_id' => $item->id]),
        ];

        // コンビニ払いの場合は顧客のメールアドレスが必須
        if ($paymentMethod !== 'カード払い') {
            $user = Auth::user();
            $sessionOptions['customer_email'] = (string)$user->email;
        }

        try {
            // Stripeセッションの作成
            $session = Session::create($sessionOptions);
            return redirect($session->url, 303);
            
        } catch (\Exception $e) {
            // エラーが発生した場合、詳細を画面に表示してデバッグしやすくする
            return back()->withErrors(['error' => 'Stripe Error: ' . $e->getMessage()]);
        }
    }

    

    /**
     * 送付先住所変更画面の表示
     */
    
    public function editAddress(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id); 
        $user = Auth::user();

        $user = auth()->user();

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

        $validated = $request->validate([
            'post_code' => ['required', 'string', 'max:8'], 
            'address'   => ['required', 'string', 'max:255'],
            'building'  => ['nullable', 'string', 'max:255'],
        ]);

         $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return redirect()->route('user.purchase.show', ['item_id' => $item_id])
                        ->with('message', '配送先を更新しました');


    }

        public function success($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = auth()->user(); 
        $profile = $user->profile;

        $item->update([
            'is_sold' => true,
            'sold_at' => now(),
            'buyer_id' => $user->id,
        ]);

        Order::create([
            'user_id'          => $user->id,
            'item_id'          => $item->id,
            'price'            => $item->price,
            'payment_method'   => 'カード払い',
            'delivery_address' => $profile ? $profile->address : '未設定', 
            'status'           => 1,
        ]);

        return redirect()->route('item.show', ['item_id' => $item->id]);
    }
}