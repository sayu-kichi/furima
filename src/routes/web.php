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

Route::get('/', [ItemsController::class, 'index'])->name('index');
Route::get('/item/{id}', [ItemsController::class, 'show'])->name('item.show');
Route::get('/register', [AuthController::class, 'create'])->name('register');
Route::post('/register', [AuthController::class, 'store']);

// ログイン済みユーザーのみアクセス可能なルート（プロフィール関連）
Route::middleware(['auth', 'verified'])->group(function () {
    // プロフィール表示（マイページ）
    Route::get('/mypage', [ProfileController::class, 'index'])->name('profile.index');

    // プロフィール設定・編集画面の表示
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    // プロフィール更新処理
    Route::put('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
});

/* --- メール認証関連 --- */

// メール認証が必要な旨を表示する画面
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// メールのリンクをクリックした時の処理
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/mypage/profile');
})->middleware(['auth', 'signed'])->name('verification.verify');

// 認証メールの再送処理
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', '認証リンクを再送信しました。');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


/* --- 購入関連 --- */
Route::middleware('auth')->group(function () {
    
    // 購入画面表示
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'show'])
        ->name('user.purchase.show');

    // 購入処理
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'store'])
        ->name('user.purchase.store');

    Route::get('/purchase/success/{item_id}', [PurchaseController::class, 'success'])->name('user.purchase.success');


    // 住所変更画面の表示
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'edit'])
        ->name('user.address.edit');

    // 住所変更の更新処理（PUTに統一）
    // 名前を「updateAddress」に合わせ、名前付きルートも1つに絞ります
    Route::put('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress'])
        ->name('user.address.update');
    });
    

Route::get('/sell', [ItemsController::class, 'create'])->name('item.create');

Route::post('/sell', [ItemsController::class, 'store'])->name('item.store');