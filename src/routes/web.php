<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [ItemsController::class, 'index']);

Route::get('/item/{id}', [ItemsController::class, 'show'])->name('item.show');

Route::get('/register', [AuthController::class, 'create'])->name('register');

Route::post('/register', [AuthController::class, 'store']);

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// ログイン処理 (POST) - 必要に応じてコントローラーを作成してください
Route::post('/login', [AuthController::class, 'login']);


/* --- メール認証関連 --- */

// メール認証が必要な旨を表示する画面
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// メールのリンクをクリックした時の処理
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

// 認証メールの再送処理
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', '認証リンクを再送信しました。');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// ログアウト処理 (verify-email.blade.php などで使用)
Route::post('/logout', function (Request $request) {
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');