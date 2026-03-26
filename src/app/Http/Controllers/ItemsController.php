<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item; 

class ItemsController extends Controller
{

    public function index()
    {

        $items = Item::all();

        // 2. 'index' という名前の View（index.blade.php）を表示します
        // その際、'items' という名前で取得したデータを画面側に渡します
        // これにより、Blade側で $items 変数が使えるようになります
        return view('index', ['items' => $items]);
    }
}