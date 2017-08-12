<?php

namespace App\Http\Controllers\Admin;

use App\Articles\Article;
use App\GiftLists\GiftList;
use App\Http\Controllers\Controller;
use App\Recommendations\Request;

class GiftListsController extends Controller
{

    public function index()
    {
        $lists = GiftList::with('request', 'suggestions')->get();
        return view('admin.giftlists.index', ['lists' => $lists]);
    }

    public function show(GiftList $list)
    {
        $articles = Article::all()->map(function($article) {
            return [
                'id' => $article->id,
                'name' => $article->title
            ];
        });
        return view('admin.giftlists.show', ['list' => $list, 'articles' => $articles]);
    }

    public function store(Request $request)
    {
        $list = $request->createGiftList();
        return redirect('/admin/giftlists/' . $list->id);
    }

    public function update(GiftList $list)
    {
        $this->validate(request(), ['writeup' => 'required']);

        $list->update(['writeup' => request('writeup')]);

        return response()->json(['writeup' => request('writeup')]);
    }
}
