<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\VerifyEmailResponse as VerifyEmailResponseContract;

/**
 * メール認証完了後のリダイレクト先を「プロフィール設定画面」へ上書きするクラス
 */
class VerifyEmailResponse implements VerifyEmailResponseContract
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        // 4-d の要件に基づき、リダイレクト先を /mypage/profile に設定
        return redirect()->route('profile.edit')->with('status', 'verified');
    }
}