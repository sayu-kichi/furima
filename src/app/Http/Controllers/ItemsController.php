<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item; 

class ItemsController extends Controller
{

    public function index()
    {

        $items = Item::all();
        return view('index', ['items' => $items]);
    }

    public function show($id)
    {
        // IDに一致する商品を1件取得。なければ404エラー
        $item = Item::findOrFail($id);
        
        // 商品詳細ビューを表示
        return view('item_detail', compact('item'));
    }
}