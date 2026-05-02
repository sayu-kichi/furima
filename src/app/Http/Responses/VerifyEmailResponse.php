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
        if ($request->wantsJson()) {
            return new JsonResponse('', 204);
        }

        return redirect('/mypage/profile')->with('status', 'verified');
    }
}