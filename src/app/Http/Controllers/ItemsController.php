<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ItemsController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('index', ['items' => $items]);
    }

    /**
     * 出品ページを表示するメソッド
     * GET /sell
     */
    public function create()
    {
        // 全てのカテゴリを取得してビューに渡す
        $categories = Category::all();
        
        // resources/views/sell.blade.php を表示（ファイル名は適宜合わせてください）
        return view('sell', compact('categories'));
    }

    public function show($id)
    {
        // IDに一致する商品を1件取得。なければ404エラー
        $item = Item::findOrFail($id);
        
        // 商品詳細ビューを表示
        return view('item_detail', compact('item'));
    }

    /**
     * 出品内容を保存するメソッド
     * POST /sell
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'image' => 'required|image',
        ]);

        // 画像の保存処理
        $imagePath = $request->file('image')->store('public/items');
        $dbPath = str_replace('public/', 'storage/', $path);


        Item::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'image_url' => basename($imagePath),
            'status' => 'selling', // 出品中
        ]);

        return redirect('/')->with('success', '出品が完了しました');
    }
}