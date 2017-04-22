<?php

namespace App\Http\Controllers\Admin;

use App\Cards\Card;
use App\Products\Lookup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CardsController extends Controller
{
    public function index()
    {
        return view('admin.cards.index');
    }

    public function store(Lookup $lookup)
    {
        $product = $lookup->withId(request('itemid'))->first();
        $product->save();

        return Card::create(['product_id' => $product->fresh()->id]);
    }

    public function delete(Card $card)
    {
        $card->delete();

        return response()->json('ok');
    }
}
