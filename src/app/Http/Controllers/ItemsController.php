<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ItemsController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::query();

        if ($request->filled('keyword')) {
            $query->where('item_name', 'like', '%' . $request->keyword . '%');
        }

        if (auth()->check()) {
            $query->where('user_id', '!=', auth()->id());
        }

        if ($request->query('tab') === 'mylist') {
            if (auth()->check()) {
                $user = auth()->user();
                $likedItemIds = $user->likes()->pluck('item_id');
                $query->whereIn('id', $likedItemIds);
            } else {
                $items = collect(); 
                return view('index', compact('items'));
            }
        }

        $items = $query->get();
        return view('index', compact('items'));
    }

    public function create()
    {
        $categories = Category::all();
        $conditions = ['良好', '目立った傷や汚れなし', 'やや傷や汚れあり']; 
        return view('sell', compact('categories', 'conditions'));
    }

    public function show($id)
    {
        $item = Item::with(['comments.user', 'categories'])
            ->withCount(['likes', 'comments'])
            ->findOrFail($id);
        
        return view('item_detail', compact('item'));
        
    }

    public function store(Request $request)
    {
        $request->validate([
        'item_name'   => 'required|string|max:255',
        'brand'       => 'nullable|string|max:255',
        'description' => 'required|string|max:516',
        'price'       => 'required|integer|min:0',
        'condition'   => 'required|string',
        'image'       => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $path = $request->file('image')->store('items', 'public');

    $item = Item::create([
        'user_id'     => Auth::id(),
        'item_name'   => $request->item_name,
        'image_url'   => $path,
        'brand'       => $request->brand,
        'description' => $request->description,
        'price'       => $request->price,
        'condition'   => $request->condition,
    ]);

        if ($request->has('categories')) {
               $item->categories()->attach($request->categories);
}
        return redirect()->route('index')->with('message', '商品を出品しました');
    }

        public function storeComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|max:255',
            ], [
                'comment.required' => 'コメントを入力してください',
                'comment.max' => 'コメントは255文字以内で入力してください',
            ]);

         Comment::create([
             'user_id' => auth()->id(),
             'item_id' => $id,
             'comment' => $request->comment,
         ]);

        return back()->with('message', 'コメントを投稿しました');
    }

    public function toggleLike($item_id)
    {
        if (!auth()->check()) {
        return redirect()->route('login');
        }
        
        $user = auth()->user();

        $user_id = $user->id;
        
        $like = \App\Models\Like::where('user_id', $user->id)
                            ->where('item_id', $item_id)
                            ->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'user_id' => $user_id,
                'item_id' => $item_id,
            ]);
        }

        return back();
    }
}