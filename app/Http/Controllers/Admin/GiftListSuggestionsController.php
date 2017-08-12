<?php

namespace App\Http\Controllers\Admin;

use App\GiftLists\GiftList;
use App\Suggestions\Suggestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GiftListSuggestionsController extends Controller
{

    public function index(GiftList $list)
    {
        return $list->suggestions()->with('product')->get();
    }

    public function store(GiftList $list, Suggestion $suggestion)
    {
        $list->addSuggestion($suggestion);
    }

    public function delete(GiftList $list, Suggestion $suggestion)
    {
        $list->removeSuggestion($suggestion);
    }
}
