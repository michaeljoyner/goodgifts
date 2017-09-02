<?php

namespace App\Http\Controllers\Admin;

use App\GiftLists\GiftList;
use App\GiftLists\Pick;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopPicksController extends Controller
{
    public function store()
    {
        $this->validate(request(), ['pick_id' => 'required|exists:gift_list_suggestion,id']);

        $pick = tap(Pick::find(request('pick_id')), function($pick) {
            $pick->update(['top_pick' => true]);
        });

        return ['pick_id' => $pick->id, 'top_pick' => $pick->top_pick];
    }

    public function delete(Pick $pick)
    {
        $pick->update(['top_pick' => false]);
    }
}
