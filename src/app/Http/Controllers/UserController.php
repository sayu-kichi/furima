<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * マイページを表示する
     */
    public function mypage()
    {
        return view('mypage'); 
    }

    
}