<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;    
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- 1. 誰でもアクセス可能なルート ---
Route::get('/', [ItemsController::class, 'index'])->name('index');
Route::get('/item/{item_id}', [ItemsController::class, 'show'])->name('item.show');

// --- 2. 未ログインユーザーのみ ---
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'create'])->name('register');
    Route::post('/register', [AuthController::class, 'store']);
    
});

// --- 3. ログイン済みユーザー（メール認証未完了でもOK） ---
Route::middleware('auth')->group(function () {
    
    /* メール認証関連 */
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->middleware('auth')->name('verification.notice');


    // メールのリンクをクリックした時の処理
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/mypage/profile');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', '認証リンクを再送信しました。');
    })->middleware('throttle:6,1')->name('verification.send');


    /* いいね機能 */
    Route::post('/item/{item_id}/like', [ItemsController::class, 'toggleLike'])->name('item.like');
    Route::post('/item/{item_id}/comment', [ItemsController::class, 'storeComment'])->name('item.comment')->middleware('auth');



    /* プロフィール編集（ここを verified の外に出すと、認証直後にスムーズに表示できます） */
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// --- 4. ログイン済み ＋ メール認証済み限定 ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    // マイページ（表示のみ）
    Route::get('/mypage', [ProfileController::class, 'index'])->name('profile.index');

    /* 購入関連 */
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'show'])->name('user.purchase.show'); 
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'store'])->name('user.purchase.store');
    Route::get('/purchase/success/{item_id}', [PurchaseController::class, 'success'])->name('user.purchase.success');
    
    // 購入フローの中での住所変更（item_idが必要なもの）
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'editAddress'])->name('user.address.edit');
    Route::put('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress'])->name('user.address.update');

    /* 出品関連 */
    Route::get('/sell', [ItemsController::class, 'create'])->name('item.create');
    Route::post('/sell', [ItemsController::class, 'store'])->name('item.store');
});