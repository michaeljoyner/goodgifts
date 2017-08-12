<?php

namespace App\Http\Controllers;

use App\GiftLists\GiftList;
use App\GiftLists\GiftListPresenter;
use Illuminate\Http\Request;

class GiftListsController extends Controller
{
    public function show($slug)
    {
        return view('front.lists.show', ['list' => GiftList::withSlug($slug)->present(GiftListPresenter::class)]);
    }
}
